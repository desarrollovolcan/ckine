<h4 class="mb-3">Ficha clínica</h4>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Paciente</th>
            <th>RUT</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($patients as $patient): ?>
            <tr>
                <td><?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($patient['rut'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a class="btn btn-sm btn-info" href="<?php echo $baseUrl; ?>records/<?php echo $patient['id']; ?>">Ver ficha</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
