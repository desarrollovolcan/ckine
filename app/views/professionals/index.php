<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Profesionales</h4>
        <a href="/profesionales/nuevo" class="btn btn-primary btn-sm">Nuevo profesional</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Especialidad</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professionals as $professional): ?>
                        <tr>
                            <td><?php echo e($professional['first_name'] . ' ' . $professional['last_name']); ?></td>
                            <td><?php echo e($professional['specialty']); ?></td>
                            <td><?php echo e($professional['email']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $professional['active'] ? 'success' : 'secondary'; ?>-subtle text-<?php echo $professional['active'] ? 'success' : 'secondary'; ?>">
                                    <?php echo $professional['active'] ? 'Activo' : 'Inactivo'; ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="/profesionales/editar?id=<?php echo (int)$professional['id']; ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <a href="/profesionales/horarios?id=<?php echo (int)$professional['id']; ?>" class="btn btn-sm btn-outline-secondary">Horarios</a>
                                <form method="post" action="/profesionales/eliminar" class="d-inline" onsubmit="return confirm('¿Eliminar profesional?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo (int)$professional['id']; ?>">
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
