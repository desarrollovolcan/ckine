<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Servicios</h4>
        <a href="/servicios/nuevo" class="btn btn-primary btn-sm">Nuevo servicio</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Duración</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td><?php echo e($service['name']); ?></td>
                            <td><?php echo (int)$service['duration_minutes']; ?> min</td>
                            <td><?php echo $service['price'] !== null ? e(format_currency((float)$service['price'])) : 'Sin costo'; ?></td>
                            <td><?php echo $service['active'] ? 'Activo' : 'Inactivo'; ?></td>
                            <td class="text-end">
                                <a href="/servicios/editar?id=<?php echo (int)$service['id']; ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form method="post" action="/servicios/eliminar" class="d-inline" onsubmit="return confirm('¿Eliminar servicio?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo (int)$service['id']; ?>">
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
