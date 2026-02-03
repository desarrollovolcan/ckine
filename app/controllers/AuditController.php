<?php

declare(strict_types=1);

class AuditController extends BaseController
{
    public function index(): void
    {
        $this->requireLogin();
        $logs = (new AuditLogModel($this->db))->all();
        $this->render('audit/index', [
            'title' => 'Auditoría',
            'pageTitle' => 'Auditoría',
            'logs' => $logs,
        ]);
    }
}
