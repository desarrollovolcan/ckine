<?php
$appointments = $appointments ?? [];
$companyName = $company['name'] ?? 'Clínica';
$todayLabel = $todayLabel ?? date('Y-m-d');
?>

<div class="container-fluid py-4 waiting-room-screen">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="mb-1"><?php echo e($companyName); ?></h2>
            <p class="text-muted mb-0">Sala de espera · <?php echo e($todayLabel); ?></p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary-subtle text-primary fs-6 px-3 py-2">
                <?php echo e(count($appointments)); ?> cita<?php echo count($appointments) === 1 ? '' : 's'; ?> hoy
            </span>
        </div>
    </div>

    <?php if (!empty($missingCompany)): ?>
        <div class="alert alert-warning">
            Configura el identificador de empresa en la URL para mostrar las citas públicas.
            <span class="d-block mt-2 text-muted">Ejemplo: <code>?route=appointments/waiting-room&amp;company_id=1</code></span>
        </div>
    <?php elseif (empty($appointments)): ?>
        <div class="alert alert-info">No hay citas programadas para hoy.</div>
    <?php else: ?>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Hora</th>
                                <th>Paciente</th>
                                <th>Box</th>
                                <th>Profesional</th>
                                <th class="pe-4">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appointments as $appointment): ?>
                                <tr>
                                    <td class="ps-4 fw-semibold"><?php echo e($appointment['appointment_time'] ?? ''); ?></td>
                                    <td><?php echo e($appointment['patient_name'] ?? ''); ?></td>
                                    <td><?php echo e($appointment['box_name'] ?? 'Sin box'); ?></td>
                                    <td><?php echo e($appointment['professional_name'] ?? ''); ?></td>
                                    <td class="pe-4">
                                        <?php $status = $appointment['status'] ?? 'Pendiente'; ?>
                                        <span class="badge bg-light text-dark"><?php echo e($status); ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .waiting-room-screen {
        min-height: 100vh;
        background: #f8fafc;
    }

    .waiting-room-screen .table td,
    .waiting-room-screen .table th {
        font-size: 1.1rem;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .waiting-room-screen h2 {
        font-size: 2rem;
    }
</style>
