<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="card-title mb-0">Listado de profesionales</h4>
            <small class="text-muted">Equipo clínico y disponibilidad.</small>
        </div>
        <a href="index.php?route=professionals/create" class="btn btn-primary">Nuevo profesional</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Especialidad</th>
                        <th>Contacto</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professionals as $professional): ?>
                        <tr>
                            <td><?php echo e($professional['id']); ?></td>
                            <td><?php echo e($professional['name']); ?></td>
                            <td><?php echo e($professional['specialty']); ?></td>
                            <td>
                                <div><?php echo e($professional['email']); ?></div>
                                <small class="text-muted"><?php echo e($professional['phone']); ?></small>
                            </td>
                            <td><span class="badge bg-light text-dark"><?php echo e($professional['status']); ?></span></td>
                            <td class="text-end">
                                <a href="index.php?route=professionals/show&id=<?php echo e($professional['id']); ?>" class="btn btn-sm btn-outline-primary">Ver</a>
                                <a href="index.php?route=professionals/edit&id=<?php echo e($professional['id']); ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
                                <form method="post" action="index.php?route=professionals/delete" class="d-inline" onsubmit="return confirm('¿Eliminar este profesional?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo e($professional['id']); ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
