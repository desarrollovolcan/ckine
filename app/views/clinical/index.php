<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="card-title mb-0">Historial clínico</h4>
            <small class="text-muted">Seguimiento de tratamientos y evolución.</small>
        </div>
        <a href="index.php?route=patients" class="btn btn-outline-secondary">Ver pacientes</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Última visita</th>
                        <th>Profesional</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($records)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No hay pacientes registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($records as $record): ?>
                            <tr>
                                <td><?php echo e($record['patient']); ?></td>
                                <td><?php echo e(format_date($record['last_visit'] ?? null)); ?></td>
                                <td><?php echo e($record['professional'] ?? ''); ?></td>
                                <td><span class="badge bg-light text-dark"><?php echo e($record['status'] ?? ''); ?></span></td>
                                <td class="text-end">
                                    <a href="index.php?route=clinical/show&patient_id=<?php echo e($record['id']); ?>" class="btn btn-sm btn-outline-primary">Ver ficha</a>
                                    <a href="index.php?route=clinical/note&patient_id=<?php echo e($record['id']); ?>" class="btn btn-sm btn-outline-secondary">Nueva nota</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
