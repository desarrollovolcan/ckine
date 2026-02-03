<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="card-title mb-0">Listado de citas</h4>
            <small class="text-muted">Control de agenda y estado de cada cita.</small>
        </div>
        <div class="d-flex gap-2">
            <a href="index.php?route=appointments/calendar" class="btn btn-outline-secondary">Ver calendario</a>
            <a href="index.php?route=appointments/create" class="btn btn-primary">Nueva cita</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Paciente</th>
                        <th>Profesional</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Box</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($appointments)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">No hay citas registradas.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?php echo e($appointment['id']); ?></td>
                                <td><?php echo e($appointment['patient_name'] ?? ''); ?></td>
                                <td><?php echo e($appointment['professional_name'] ?? ''); ?></td>
                                <td><?php echo e(format_date($appointment['appointment_date'] ?? null)); ?></td>
                                <td><?php echo e($appointment['appointment_time'] ?? ''); ?></td>
                                <td><?php echo e($appointment['box_name'] ?? ''); ?></td>
                                <td><span class="badge bg-light text-dark"><?php echo e($appointment['status'] ?? ''); ?></span></td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" disabled>Reagendar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
