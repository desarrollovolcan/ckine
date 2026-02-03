<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Roles</h4>
        <a href="/roles/nuevo" class="btn btn-primary btn-sm">Nuevo rol</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles as $role): ?>
                        <tr>
                            <td><?php echo e($role['name']); ?></td>
                            <td><?php echo e($role['description']); ?></td>
                            <td class="text-end">
                                <a href="/roles/editar?id=<?php echo (int)$role['id']; ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form method="post" action="/roles/eliminar" class="d-inline" onsubmit="return confirm('¿Eliminar rol?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo (int)$role['id']; ?>">
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
