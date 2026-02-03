<?php

class PatientAccessController extends Controller
{
    public function login(): void
    {
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);

        $identifier = '';
        $password = '';
        $companyId = 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verify_csrf();
            $identifier = trim($_POST['identifier'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $companyId = (int)($_POST['company_id'] ?? 0);

            if ($companyId === 0) {
                $error = 'Selecciona una empresa.';
            } elseif ($identifier === '' || $password === '') {
                $error = 'Completa los datos solicitados.';
            } else {
                $field = Validator::email($identifier) ? 'email' : 'rut';
                if ($field === 'rut') {
                    $identifier = normalize_rut($identifier);
                }
                $patient = $this->db->fetch(
                    "SELECT * FROM patients WHERE {$field} = :identifier AND company_id = :company_id AND deleted_at IS NULL",
                    [
                        'identifier' => $identifier,
                        'company_id' => $companyId,
                    ]
                );
                if (!$patient || empty($patient['portal_password'])) {
                    $error = 'Las credenciales no son válidas.';
                } else {
                    $storedPassword = (string)$patient['portal_password'];
                    $passwordMatches = password_verify($password, $storedPassword);
                    if (!$passwordMatches && hash_equals($storedPassword, $password)) {
                        $passwordMatches = true;
                        $this->db->execute(
                            'UPDATE patients SET portal_password = :password, updated_at = :updated_at WHERE id = :id',
                            [
                                'password' => password_hash($password, PASSWORD_DEFAULT),
                                'updated_at' => date('Y-m-d H:i:s'),
                                'id' => $patient['id'],
                            ]
                        );
                    }
                    if (!$passwordMatches) {
                        $error = 'Las credenciales no son válidas.';
                    } else {
                        $_SESSION['patient_portal_id'] = $patient['id'];
                        $_SESSION['patient_company_id'] = $patient['company_id'];
                        $this->redirect('index.php?route=patients/portal');
                    }
                }
            }
        }

        $this->renderPublic('patients/portal-login', [
            'title' => 'Acceso portal paciente',
            'pageTitle' => 'Portal de pacientes',
            'hidePortalHeader' => true,
            'error' => $error,
            'identifier' => $identifier,
            'companyId' => $companyId,
            'companies' => (new CompaniesModel($this->db))->active(),
        ]);
    }

    public function portal(): void
    {
        $patientId = (int)($_SESSION['patient_portal_id'] ?? 0);
        $companyId = (int)($_SESSION['patient_company_id'] ?? 0);
        if ($patientId === 0 || $companyId === 0) {
            $_SESSION['error'] = 'Debes iniciar sesión para acceder al portal.';
            $this->redirect('index.php?route=patients/portal/login');
        }

        $patient = $this->db->fetch(
            'SELECT * FROM patients WHERE id = :id AND company_id = :company_id AND deleted_at IS NULL',
            ['id' => $patientId, 'company_id' => $companyId]
        );
        if (!$patient) {
            unset($_SESSION['patient_portal_id'], $_SESSION['patient_company_id']);
            $_SESSION['error'] = 'No encontramos un paciente asociado a este acceso.';
            $this->redirect('index.php?route=patients/portal/login');
        }

        $appointments = (new AppointmentsModel($this->db))->upcomingForPatient($companyId, $patientId, 5);

        $this->renderPublic('patients/portal', [
            'title' => 'Portal de pacientes',
            'pageTitle' => 'Portal de pacientes',
            'hidePortalHeader' => true,
            'patient' => $patient,
            'appointments' => $appointments,
        ]);
    }

    public function logout(): void
    {
        unset($_SESSION['patient_portal_id'], $_SESSION['patient_company_id']);
        $this->redirect('index.php?route=patients/portal/login');
    }
}
