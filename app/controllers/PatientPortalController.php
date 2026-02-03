<?php

class PatientPortalController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $this->render('patient_portal/index', [
            'title' => 'Portal de pacientes',
            'subtitle' => 'Agendamiento',
        ]);
    }
}
