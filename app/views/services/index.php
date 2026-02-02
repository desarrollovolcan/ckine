<?php use App\Core\CSRF; ?>
<div class="d-flex justify-content-between mb-3">
    <h4>Servicios</h4>
    <a class="btn btn-primary" href="/services/create">Nuevo servicio</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Duración</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($services as $service): ?>
            <tr>
                <td><?php echo htmlspecialchars($service['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($service['duration_minutes'], ENT_QUOTES, 'UTF-8'); ?> min</td>
                <td><?php echo $service['price'] !== null ? '$' . number_format($service['price'], 0, ',', '.') : '-'; ?></td>
                <td class="d-flex gap-2">
                    <a class="btn btn-sm btn-info" href="/services/<?php echo $service['id']; ?>/edit">Editar</a>
                    <form method="post" action="/services/<?php echo $service['id']; ?>/delete" onsubmit="return confirm('¿Eliminar servicio?')">
                        <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
                        <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
