<?php
$patientName = $patient['name'] ?? 'Paciente';
$portalLogo = login_logo_src($companySettings ?? []);
?>

<style>
    .patient-portal-shell { min-height: 100vh; display: flex; flex-direction: column; gap: 20px; }
    .patient-portal-header { background: #ffffff; border-radius: 18px; padding: 24px; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08); }
    .patient-portal-header .badge { font-weight: 600; }
    .patient-portal-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; }
    .patient-portal-card { background: #ffffff; border-radius: 16px; padding: 20px; box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08); }
    .patient-portal-card h6 { font-weight: 700; }
    .patient-portal-card .text-muted { font-size: 0.85rem; }
    .patient-portal-section { background: #ffffff; border-radius: 16px; padding: 20px; box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08); }
    .patient-portal-appointments .table { margin-bottom: 0; }
    .patient-portal-nav { display: flex; align-items: center; gap: 12px; }
    .patient-portal-avatar { width: 48px; height: 48px; border-radius: 50%; background: #4361ee; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; }
</style>

<div class="patient-portal-shell">
    <div class="patient-portal-header d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-3">
            <img src="<?php echo e($portalLogo); ?>" alt="logo" style="height: 36px;">
            <div>
                <h4 class="mb-1">Hola, <?php echo e($patientName); ?> 👋</h4>
                <p class="text-muted mb-0">Bienvenido a tu portal personal de salud.</p>
            </div>
        </div>
        <div class="patient-portal-nav">
            <span class="badge bg-primary-subtle text-primary">Estado: <?php echo e($patient['status'] ?? 'Activo'); ?></span>
            <a class="btn btn-outline-secondary" href="index.php?route=patients/portal/logout">
                <i class="ti ti-logout me-1"></i> Cerrar sesión
            </a>
        </div>
    </div>

    <div class="patient-portal-grid">
        <div class="patient-portal-card">
            <h6 class="mb-2">Datos personales</h6>
            <p class="text-muted mb-1">RUT: <?php echo e($patient['rut'] ?? '—'); ?></p>
            <p class="text-muted mb-1">Fecha de nacimiento: <?php echo e($patient['birthdate'] ?? '—'); ?></p>
            <p class="text-muted mb-0">Ocupación: <?php echo e($patient['occupation'] ?? '—'); ?></p>
        </div>
        <div class="patient-portal-card">
            <h6 class="mb-2">Contacto</h6>
            <p class="text-muted mb-1">Correo: <?php echo e($patient['email'] ?? '—'); ?></p>
            <p class="text-muted mb-1">Teléfono: <?php echo e($patient['phone'] ?? '—'); ?></p>
            <p class="text-muted mb-0">Dirección: <?php echo e($patient['address'] ?? '—'); ?></p>
        </div>
        <div class="patient-portal-card">
            <h6 class="mb-2">Cobertura</h6>
            <p class="text-muted mb-1">Seguro/Isapre: <?php echo e($patient['insurance'] ?? '—'); ?></p>
            <p class="text-muted mb-1">Médico referente: <?php echo e($patient['referring_physician'] ?? '—'); ?></p>
            <p class="text-muted mb-0">Motivo de visita: <?php echo e($patient['reason_for_visit'] ?? '—'); ?></p>
        </div>
        <div class="patient-portal-card">
            <h6 class="mb-2">Alertas clínicas</h6>
            <p class="text-muted mb-1">Diagnóstico: <?php echo e($patient['diagnosis'] ?? '—'); ?></p>
            <p class="text-muted mb-1">Alergias: <?php echo e($patient['allergies'] ?? '—'); ?></p>
            <p class="text-muted mb-0">Notas: <?php echo e($patient['notes'] ?? '—'); ?></p>
        </div>
    </div>

    <div class="patient-portal-section patient-portal-appointments">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
            <div>
                <h5 class="mb-1">Próximas citas</h5>
                <p class="text-muted mb-0">Revisa tu agenda confirmada y la información de tu profesional.</p>
            </div>
            <div class="patient-portal-avatar" title="<?php echo e($patientName); ?>">
                <?php echo e(mb_substr($patientName, 0, 1)); ?>
            </div>
        </div>

        <?php if (!empty($appointments)): ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Profesional</th>
                            <th>Box</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?php echo e($appointment['appointment_date'] ?? '—'); ?></td>
                                <td><?php echo e($appointment['appointment_time'] ?? '—'); ?></td>
                                <td><?php echo e($appointment['professional_name'] ?? 'Por confirmar'); ?></td>
                                <td><?php echo e($appointment['box_name'] ?? 'Por confirmar'); ?></td>
                                <td>
                                    <span class="badge bg-success-subtle text-success">
                                        <?php echo e($appointment['status'] ?? 'Programada'); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-light border text-muted mb-0">
                No tienes citas próximas registradas. Si necesitas una, comunícate con la clínica.
            </div>
        <?php endif; ?>
    </div>
</div>
