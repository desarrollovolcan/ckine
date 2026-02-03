<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Ficha del paciente</h5>
                <p class="mb-1 text-muted">ID</p>
                <h6><?php echo e($patientId ?: 'No disponible'); ?></h6>
                <p class="mb-1 text-muted mt-3">Nombre</p>
                <h6><?php echo e($patient['name'] ?? 'Sin nombre'); ?></h6>
                <p class="mb-1 text-muted mt-3">Contacto</p>
                <div><?php echo e($patient['email'] ?? 'Sin correo'); ?></div>
                <div class="text-muted"><?php echo e($patient['phone'] ?? 'Sin teléfono'); ?></div>
                <div class="mt-3">
                    <span class="badge bg-success"><?php echo e($patient['status'] ?? 'Sin estado'); ?></span>
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
                    <li class="list-group-item">RUT: <?php echo e($patient['rut'] ?? 'No informado'); ?></li>
                    <li class="list-group-item">Fecha de nacimiento: <?php echo e($patient['birthdate'] ? format_date($patient['birthdate']) : 'No informada'); ?></li>
                    <li class="list-group-item">Dirección: <?php echo e($patient['address'] ?? 'No informada'); ?></li>
                    <li class="list-group-item">Ocupación: <?php echo e($patient['occupation'] ?? 'No informada'); ?></li>
                    <li class="list-group-item">Seguro/Previsión: <?php echo e($patient['insurance'] ?? 'No informada'); ?></li>
                    <li class="list-group-item">Profesional derivante: <?php echo e($patient['referring_physician'] ?? 'No informado'); ?></li>
                    <li class="list-group-item">Contacto de emergencia: <?php echo e($patient['emergency_contact_name'] ?? 'No informado'); ?></li>
                    <li class="list-group-item">Teléfono emergencia: <?php echo e($patient['emergency_contact_phone'] ?? 'No informado'); ?></li>
                    <li class="list-group-item">Motivo de consulta: <?php echo e($patient['reason_for_visit'] ?? 'No informado'); ?></li>
                    <li class="list-group-item">Diagnóstico/objetivo terapéutico: <?php echo e($patient['diagnosis'] ?? 'No informado'); ?></li>
                    <li class="list-group-item">Alergias/precauciones: <?php echo e($patient['allergies'] ?? 'No informado'); ?></li>
                    <li class="list-group-item">Observaciones: <?php echo e($patient['notes'] ?? 'Sin observaciones'); ?></li>
                </ul>
                <div class="mt-3 d-flex gap-2 justify-content-end">
                    <a href="index.php?route=patients/edit&id=<?php echo e($patientId); ?>" class="btn btn-outline-secondary">Editar ficha</a>
                    <a href="index.php?route=clinical/show&patient_id=<?php echo e($patientId); ?>" class="btn btn-primary">Ver historial clínico</a>
                </div>
            </div>
        </div>
    </div>
</div>
