<div class="row g-3">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Detalle del box</h5>
                <p class="text-muted mb-1">ID</p>
                <h6><?php echo e($boxId ?: 'No disponible'); ?></h6>
                <p class="text-muted mb-1 mt-3">Nombre</p>
                <h6>Box 1</h6>
                <p class="text-muted mb-1 mt-3">Capacidad</p>
                <h6>2 pacientes</h6>
                <div class="mt-3">
                    <span class="badge bg-success">Disponible</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Equipamiento</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Camilla hidráulica</li>
                    <li class="list-group-item">Electroestimulación</li>
                    <li class="list-group-item">Set de compresas frías/calientes</li>
                </ul>
                <div class="mt-3 d-flex gap-2 justify-content-end">
                    <a href="index.php?route=boxes/edit&id=<?php echo e($boxId); ?>" class="btn btn-outline-secondary">Editar</a>
                    <a href="index.php?route=appointments/calendar" class="btn btn-primary">Ver agenda</a>
                </div>
            </div>
        </div>
    </div>
</div>
