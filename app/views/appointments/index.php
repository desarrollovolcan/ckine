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
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?php echo e($appointment['id']); ?></td>
                            <td><?php echo e($appointment['patient']); ?></td>
                            <td><?php echo e($appointment['professional']); ?></td>
                            <td><?php echo e(format_date($appointment['date'])); ?></td>
                            <td><?php echo e($appointment['time']); ?></td>
                            <td><?php echo e($appointment['box']); ?></td>
                            <td><span class="badge bg-light text-dark"><?php echo e($appointment['status']); ?></span></td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Reagendar</button>
                                    <form method="post" action="index.php?route=appointments/delete" onsubmit="return confirm('¿Eliminar esta cita?');">
                                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="id" value="<?php echo e($appointment['id']); ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
