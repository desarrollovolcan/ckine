<?php use App\Core\CSRF; ?>
<div class="d-flex justify-content-between mb-3">
    <h4>Roles</h4>
    <a class="btn btn-primary" href="<?php echo $baseUrl; ?>roles/create">Nuevo rol</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($roles as $role): ?>
            <tr>
                <td><?php echo htmlspecialchars($role['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($role['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td class="d-flex gap-2">
                    <a class="btn btn-sm btn-info" href="<?php echo $baseUrl; ?>roles/<?php echo $role['id']; ?>/edit">Editar</a>
                    <form method="post" action="<?php echo $baseUrl; ?>roles/<?php echo $role['id']; ?>/delete" onsubmit="return confirm('¿Eliminar rol?')">
                        <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
                        <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
