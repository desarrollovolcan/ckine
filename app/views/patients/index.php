<?php use App\Core\CSRF; ?>
<div class="d-flex justify-content-between mb-3">
    <h4>Pacientes</h4>
    <a class="btn btn-primary" href="<?php echo $baseUrl; ?>patients/create">Nuevo paciente</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>RUT</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($patients as $patient): ?>
            <tr>
                <td><?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($patient['rut'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($patient['email'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($patient['phone'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                <td class="d-flex gap-2">
                    <a class="btn btn-sm btn-info" href="<?php echo $baseUrl; ?>patients/<?php echo $patient['id']; ?>/edit">Editar</a>
                    <a class="btn btn-sm btn-secondary" href="<?php echo $baseUrl; ?>records/<?php echo $patient['id']; ?>">Ficha</a>
                    <form method="post" action="<?php echo $baseUrl; ?>patients/<?php echo $patient['id']; ?>/delete" onsubmit="return confirm('¿Eliminar paciente?')">
                        <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
                        <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
