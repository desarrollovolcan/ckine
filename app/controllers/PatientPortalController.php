<?php

class PatientPortalController extends Controller
{
    private SettingsModel $settings;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->settings = new SettingsModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $portalConfig = $this->settings->get('patient_portal', []);
        if (!is_array($portalConfig)) {
            $portalConfig = [];
        }
        $defaultUrl = ($this->config['app']['url'] ?? '') . '/portal';
        $portalConfig = array_merge([
            'active' => true,
            'public_url' => $defaultUrl,
            'welcome_message' => 'Agenda tu hora en línea. Recibirás confirmación por correo.',
        ], $portalConfig);
        $this->render('patient_portal/index', [
            'title' => 'Portal de pacientes',
            'subtitle' => 'Agendamiento',
            'portalConfig' => $portalConfig,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        $this->settings->set('patient_portal', [
            'active' => !empty($_POST['active']),
            'public_url' => trim($_POST['public_url'] ?? ''),
            'welcome_message' => trim($_POST['welcome_message'] ?? ''),
        ]);
        audit($this->db, Auth::user()['id'], 'update', 'patient_portal');
        flash('success', 'Configuración del portal actualizada correctamente.');
        $this->redirect('index.php?route=patient-portal');
    }
}
