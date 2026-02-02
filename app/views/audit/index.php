<h4 class="mb-3">Auditoría</h4>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Acción</th>
            <th>Entidad</th>
            <th>ID</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($logs as $log): ?>
            <tr>
                <td><?php echo htmlspecialchars($log['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($log['user_name'] ?? 'Sistema', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($log['action'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($log['entity'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars((string) $log['entity_id'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
