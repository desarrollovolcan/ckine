<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Auditoría</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Acción</th>
                        <th>Entidad</th>
                        <th>ID entidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?php echo e($log['created_at']); ?></td>
                            <td><?php echo e((string)$log['user_id']); ?></td>
                            <td><?php echo e($log['action']); ?></td>
                            <td><?php echo e($log['entity']); ?></td>
                            <td><?php echo e((string)$log['entity_id']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
