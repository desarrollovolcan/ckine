<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Pacientes</h4>
        <a href="<?php echo app_path('/pacientes/nuevo'); ?>" class="btn btn-primary btn-sm">Nuevo paciente</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>RUT</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td><?php echo e($patient['first_name'] . ' ' . $patient['last_name']); ?></td>
                            <td><?php echo e($patient['rut']); ?></td>
                            <td><?php echo e($patient['phone']); ?></td>
                            <td><?php echo e($patient['email']); ?></td>
                            <td class="text-end">
                                <a href="<?php echo app_path('/pacientes/ver'); ?>?id=<?php echo (int)$patient['id']; ?>" class="btn btn-sm btn-outline-secondary">Ver</a>
                                <a href="<?php echo app_path('/pacientes/editar'); ?>?id=<?php echo (int)$patient['id']; ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form method="post" action="<?php echo app_path('/pacientes/eliminar'); ?>" class="d-inline" onsubmit="return confirm('¿Eliminar paciente?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo (int)$patient['id']; ?>">
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
