<div class="row g-3">
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-1">Citas hoy</p>
                <h3 class="mb-0"><?php echo (int)$stats['appointments_today']; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-1">Pacientes activos</p>
                <h3 class="mb-0"><?php echo (int)$stats['patients']; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-1">Profesionales</p>
                <h3 class="mb-0"><?php echo (int)$stats['professionals']; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-1">Pendientes</p>
                <h3 class="mb-0"><?php echo (int)$stats['pending']; ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="card-title mb-0">Agenda del día</h4>
            <small class="text-muted">Citas programadas para hoy.</small>
        </div>
        <a href="<?php echo app_path('/agenda'); ?>" class="btn btn-outline-primary btn-sm">Ir a agenda</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Paciente</th>
                        <th>Profesional</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($appointments)): ?>
                        <tr>
                            <td colspan="4" class="text-muted text-center">Sin citas para hoy.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?php echo e(date('H:i', strtotime($appointment['start_at']))); ?></td>
                                <td><?php echo e($appointment['first_name'] . ' ' . $appointment['last_name']); ?></td>
                                <td><?php echo e($appointment['prof_name'] . ' ' . $appointment['prof_last']); ?></td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary"><?php echo e($appointment['status']); ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
