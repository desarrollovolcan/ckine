<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Ficha del paciente</h5>
                <p class="mb-1 text-muted">ID</p>
                <h6><?php echo e($patient['id'] ?? 'No disponible'); ?></h6>
                <p class="mb-1 text-muted mt-3">Nombre</p>
                <h6><?php echo e($patient['name'] ?? ''); ?></h6>
                <p class="mb-1 text-muted mt-3">Contacto</p>
                <div><?php echo e($patient['email'] ?? ''); ?></div>
                <div class="text-muted"><?php echo e($patient['phone'] ?? ''); ?></div>
                <div class="mt-3">
                    <span class="badge bg-success"><?php echo e($patient['status'] ?? ''); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Resumen clínico</h5>
                <p class="text-muted">Resumen general del tratamiento y próximos hitos del paciente.</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Fecha de nacimiento: <?php echo e(format_date($patient['birthdate'] ?? null)); ?></li>
                    <li class="list-group-item">RUT: <?php echo e($patient['rut'] ?? ''); ?></li>
                    <li class="list-group-item">Observaciones: <?php echo e($patient['notes'] ?? 'Sin observaciones'); ?></li>
                </ul>
                <div class="mt-3 d-flex gap-2 justify-content-end">
                    <a href="index.php?route=patients/edit&id=<?php echo e($patient['id']); ?>" class="btn btn-outline-secondary">Editar ficha</a>
                    <a href="index.php?route=clinical/show&patient_id=<?php echo e($patient['id']); ?>" class="btn btn-primary">Ver historial clínico</a>
                </div>
            </div>
        </div>
    </div>
</div>
