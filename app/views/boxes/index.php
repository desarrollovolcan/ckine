<?php use App\Core\CSRF; ?>
<div class="d-flex justify-content-between mb-3">
    <h4>Box</h4>
    <a class="btn btn-primary" href="<?php echo $baseUrl; ?>boxes/create">Nuevo box</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($boxes as $box): ?>
            <tr>
                <td><?php echo htmlspecialchars($box['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($box['description'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo $box['is_active'] ? 'Activo' : 'Inactivo'; ?></td>
                <td class="d-flex gap-2">
                    <a class="btn btn-sm btn-info" href="<?php echo $baseUrl; ?>boxes/<?php echo $box['id']; ?>/edit">Editar</a>
                    <form method="post" action="<?php echo $baseUrl; ?>boxes/<?php echo $box['id']; ?>/delete" onsubmit="return confirm('¿Eliminar box?')">
                        <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
                        <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
