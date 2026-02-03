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
        $portalSettings = $this->settings->get('patient_portal', [
            'enabled' => true,
            'public_url' => base_url() . '/portal',
            'welcome_message' => 'Agenda tu hora en línea. Recibirás confirmación por correo.',
        ]);
        $this->render('patient_portal/index', [
            'title' => 'Portal de pacientes',
            'subtitle' => 'Agendamiento',
            'portalSettings' => $portalSettings,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        $payload = [
            'enabled' => ($_POST['enabled'] ?? '1') === '1',
            'public_url' => trim($_POST['public_url'] ?? ''),
            'welcome_message' => trim($_POST['welcome_message'] ?? ''),
        ];
        $this->settings->set('patient_portal', $payload);
        flash('success', 'Configuración del portal actualizada.');
        $this->redirect('index.php?route=patient-portal');
    }
}
