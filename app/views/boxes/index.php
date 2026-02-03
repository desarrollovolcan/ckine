<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Box clínicos</h4>
        <a href="<?php echo app_path('/box/nuevo'); ?>" class="btn btn-primary btn-sm">Nuevo box</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($boxes as $box): ?>
                        <tr>
                            <td><?php echo e($box['name']); ?></td>
                            <td><?php echo e($box['description']); ?></td>
                            <td><?php echo e($box['status']); ?></td>
                            <td class="text-end">
                                <a href="<?php echo app_path('/box/editar'); ?>?id=<?php echo (int)$box['id']; ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form method="post" action="<?php echo app_path('/box/eliminar'); ?>" class="d-inline" onsubmit="return confirm('¿Eliminar box?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo (int)$box['id']; ?>">
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
