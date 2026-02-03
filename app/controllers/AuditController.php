<?php

class AuditController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa para continuar.');
            $this->redirect('index.php?route=auth/switch-company');
        }
        $entries = $this->db->fetchAll(
            'SELECT audit_logs.created_at AS date,
                    users.name AS user_name,
                    audit_logs.action,
                    audit_logs.entity
             FROM audit_logs
             LEFT JOIN users ON audit_logs.user_id = users.id
             WHERE audit_logs.company_id = :company_id
             ORDER BY audit_logs.created_at DESC
             LIMIT 50',
            ['company_id' => $companyId]
        );
        $this->render('audit/index', [
            'title' => 'Auditoría y logs',
            'subtitle' => 'Administración',
            'entries' => $entries,
        ]);
    }
}
