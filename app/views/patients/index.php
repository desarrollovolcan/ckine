<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="card-title mb-0">Listado de pacientes</h4>
            <small class="text-muted">Gestión general de pacientes y estado clínico.</small>
        </div>
        <a href="index.php?route=patients/create" class="btn btn-primary">Nuevo paciente</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Paciente</th>
                        <th>RUT</th>
                        <th>Fecha nacimiento</th>
                        <th>Contacto</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($patients)): ?>
                        <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td><?php echo e($patient['id']); ?></td>
                                <td><?php echo e($patient['name']); ?></td>
                                <td><?php echo e($patient['rut']); ?></td>
                                <td><?php echo e(format_date($patient['birthdate'])); ?></td>
                                <td>
                                    <div><?php echo e($patient['phone']); ?></div>
                                    <small class="text-muted"><?php echo e($patient['email']); ?></small>
                                </td>
                                <td><span class="badge bg-light text-dark"><?php echo e($patient['status']); ?></span></td>
                                <td class="text-end">
                                    <a href="index.php?route=patients/show&id=<?php echo e($patient['id']); ?>" class="btn btn-sm btn-outline-primary">Ver</a>
                                    <a href="index.php?route=patients/edit&id=<?php echo e($patient['id']); ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
                                    <form method="post" action="index.php?route=patients/delete" class="d-inline" onsubmit="return confirm('¿Eliminar este paciente?');">
                                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="id" value="<?php echo e($patient['id']); ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay pacientes registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
