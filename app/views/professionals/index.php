<?php use App\Core\CSRF; ?>
<div class="d-flex justify-content-between mb-3">
    <h4>Profesionales</h4>
    <a class="btn btn-primary" href="/professionals/create">Nuevo profesional</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Título</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($professionals as $professional): ?>
            <tr>
                <td><?php echo htmlspecialchars($professional['user_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($professional['title'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($professional['email'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td class="d-flex gap-2">
                    <a class="btn btn-sm btn-info" href="/professionals/<?php echo $professional['id']; ?>/edit">Editar</a>
                    <form method="post" action="/professionals/<?php echo $professional['id']; ?>/delete" onsubmit="return confirm('¿Eliminar profesional?')">
                        <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
                        <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
