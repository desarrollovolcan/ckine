<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Registro de auditoría</h4>
        <small class="text-muted">Seguimiento de acciones relevantes en el sistema.</small>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Acción</th>
                        <th>Módulo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($entries)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">Sin registros de auditoría.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($entries as $entry): ?>
                            <tr>
                                <td><?php echo e($entry['date']); ?></td>
                                <td><?php echo e($entry['user_name'] ?? ''); ?></td>
                                <td><?php echo e($entry['action']); ?></td>
                                <td><?php echo e($entry['entity']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
