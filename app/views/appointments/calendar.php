<div class="row g-3">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Calendario semanal</h4>
                <a href="index.php?route=appointments/create" class="btn btn-primary">Nueva cita</a>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-0">
                    Aquí se integrará el calendario interactivo.
                    Por ahora mostramos las próximas citas registradas.
                </div>
                <div class="mt-3">
                    <?php if (empty($upcoming ?? [])): ?>
                        <div class="text-muted">No hay citas próximas.</div>
                    <?php else: ?>
                        <?php foreach ($upcoming as $appointment): ?>
                            <div class="d-flex align-items-center justify-content-between border rounded p-3 mb-2">
                                <div>
                                    <div class="fw-semibold"><?php echo e($appointment['patient_name'] ?? 'Paciente'); ?></div>
                                    <small class="text-muted">
                                        <?php echo e(format_date($appointment['appointment_date'] ?? null)); ?> - <?php echo e($appointment['appointment_time'] ?? ''); ?>
                                    </small>
                                </div>
                                <span class="badge bg-light text-dark"><?php echo e($appointment['status'] ?? ''); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Resumen del día</h4>
            </div>
            <div class="card-body">
                <p class="text-muted">Resumen de la agenda cargada.</p>
                <ul class="list-group list-group-flush">
                    <?php if (empty($upcoming ?? [])): ?>
                        <li class="list-group-item text-muted">Sin citas registradas.</li>
                    <?php else: ?>
                        <?php foreach (array_slice($upcoming, 0, 4) as $appointment): ?>
                            <li class="list-group-item">
                                <?php echo e($appointment['appointment_time'] ?? ''); ?> - <?php echo e($appointment['patient_name'] ?? ''); ?>
                                <?php if (!empty($appointment['box_name'])): ?>
                                    (<?php echo e($appointment['box_name']); ?>)
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
