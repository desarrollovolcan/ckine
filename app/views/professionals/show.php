<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Perfil profesional</h5>
                <p class="text-muted mb-1">ID</p>
                <h6><?php echo e($professionalId ?: 'No disponible'); ?></h6>
                <p class="text-muted mb-1 mt-3">Nombre</p>
                <h6><?php echo e($professional['name'] ?? ''); ?></h6>
                <p class="text-muted mb-1 mt-3">Especialidad</p>
                <h6><?php echo e($professional['specialty'] ?? ''); ?></h6>
                <p class="text-muted mb-1 mt-3">RUT</p>
                <h6><?php echo e($professional['rut'] ?? ''); ?></h6>
                <p class="text-muted mb-1 mt-3">Registro profesional</p>
                <h6><?php echo e($professional['license_number'] ?? ''); ?></h6>
                <div class="mt-3">
                    <span class="badge bg-success"><?php echo e($professional['status'] ?? ''); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Agenda y disponibilidad</h5>
                <p class="text-muted">Horario habitual: <?php echo e(($professional['schedule'] ?? '') !== '' ? $professional['schedule'] : 'Por definir'); ?>.</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Modalidad: <?php echo e($professional['modality'] ?? ''); ?></li>
                    <li class="list-group-item">Box asignado: <?php echo e(($professional['box'] ?? '') !== '' ? $professional['box'] : 'Por definir'); ?></li>
                    <li class="list-group-item">Correo: <?php echo e($professional['email'] ?? ''); ?></li>
                    <li class="list-group-item">Teléfono: <?php echo e($professional['phone'] ?? ''); ?></li>
                    <li class="list-group-item">Próxima cita: 12/05/2024 - 09:00</li>
                    <li class="list-group-item">Sesiones de la semana: 18</li>
                </ul>
                <div class="mt-3 d-flex gap-2 justify-content-end">
                    <a href="index.php?route=professionals/edit&id=<?php echo e($professionalId); ?>" class="btn btn-outline-secondary">Editar</a>
                    <a href="index.php?route=appointments" class="btn btn-primary">Ver citas</a>
                </div>
            </div>
        </div>
    </div>
</div>
