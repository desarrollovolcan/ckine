<?php use App\Core\CSRF; ?>
<div class="d-flex justify-content-between mb-3">
    <h4>Usuarios</h4>
    <a class="btn btn-primary" href="<?php echo $baseUrl; ?>users/create">Nuevo usuario</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($user['role_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo $user['is_active'] ? 'Activo' : 'Inactivo'; ?></td>
                <td class="d-flex gap-2">
                    <a class="btn btn-sm btn-info" href="<?php echo $baseUrl; ?>users/<?php echo $user['id']; ?>/edit">Editar</a>
                    <form method="post" action="<?php echo $baseUrl; ?>users/<?php echo $user['id']; ?>/delete" onsubmit="return confirm('¿Eliminar usuario?')">
                        <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
                        <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
