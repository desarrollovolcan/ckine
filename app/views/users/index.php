<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Usuarios</h4>
        <a href="<?php echo app_path('/usuarios/nuevo'); ?>" class="btn btn-primary btn-sm">Nuevo usuario</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo e($user['name']); ?></td>
                            <td><?php echo e($user['email']); ?></td>
                            <td><?php echo e($user['role_name'] ?? '-'); ?></td>
                            <td class="text-end">
                                <a href="<?php echo app_path('/usuarios/editar'); ?>?id=<?php echo (int)$user['id']; ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form method="post" action="<?php echo app_path('/usuarios/eliminar'); ?>" class="d-inline" onsubmit="return confirm('¿Eliminar usuario?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo (int)$user['id']; ?>">
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
