<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="card-title mb-0">Box y salas disponibles</h4>
            <small class="text-muted">Control de espacios físicos y equipamiento.</small>
        </div>
        <a href="index.php?route=boxes/create" class="btn btn-primary">Nuevo box</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Capacidad</th>
                        <th>Equipamiento</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($boxes as $box): ?>
                        <tr>
                            <td><?php echo e($box['id']); ?></td>
                            <td><?php echo e($box['name']); ?></td>
                            <td><?php echo e($box['capacity']); ?></td>
                            <td><?php echo e($box['equipment']); ?></td>
                            <td><span class="badge bg-light text-dark"><?php echo e($box['status']); ?></span></td>
                            <td class="text-end">
                                <a href="index.php?route=boxes/show&id=<?php echo e($box['id']); ?>" class="btn btn-sm btn-outline-primary">Ver</a>
                                <a href="index.php?route=boxes/edit&id=<?php echo e($box['id']); ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
