<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Fichas clínicas</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>RUT</th>
                        <th>Email</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td><?php echo e($patient['first_name'] . ' ' . $patient['last_name']); ?></td>
                            <td><?php echo e($patient['rut']); ?></td>
                            <td><?php echo e($patient['email']); ?></td>
                            <td class="text-end">
                                <a href="<?php echo app_path('/fichas/ver'); ?>?id=<?php echo (int)$patient['id']; ?>" class="btn btn-sm btn-outline-primary">Ver ficha</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
