<div class="row g-3">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Detalle del box</h5>
                <p class="text-muted mb-1">ID</p>
                <h6><?php echo e($box['id'] ?? 'No disponible'); ?></h6>
                <p class="text-muted mb-1 mt-3">Nombre</p>
                <h6><?php echo e($box['name'] ?? ''); ?></h6>
                <p class="text-muted mb-1 mt-3">Capacidad</p>
                <h6><?php echo e($box['capacity'] ?? ''); ?></h6>
                <div class="mt-3">
                    <span class="badge bg-success"><?php echo e($box['status'] ?? ''); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Equipamiento</h5>
                <div class="border rounded p-3 text-muted">
                    <?php echo nl2br(e($box['equipment'] ?? 'Sin equipamiento registrado.')); ?>
                </div>
                <div class="mt-3 d-flex gap-2 justify-content-end">
                    <a href="index.php?route=boxes/edit&id=<?php echo e($box['id']); ?>" class="btn btn-outline-secondary">Editar</a>
                    <a href="index.php?route=appointments/calendar" class="btn btn-primary">Ver agenda</a>
                </div>
            </div>
        </div>
    </div>
</div>
