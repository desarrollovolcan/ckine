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
                    <?php foreach ($entries as $entry): ?>
                        <tr>
                            <td><?php echo e($entry['date']); ?></td>
                            <td><?php echo e($entry['user']); ?></td>
                            <td><?php echo e($entry['action']); ?></td>
                            <td><?php echo e($entry['module']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
