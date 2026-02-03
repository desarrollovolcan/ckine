<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Editar paciente</h4>
        <small class="text-muted">ID paciente: <?php echo e($patientId ?: 'Sin ID'); ?></small>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=patients/update&id=<?php echo e($patientId); ?>">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e($patient['name'] ?? ''); ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">RUT</label>
                    <input type="text" name="rut" class="form-control" value="<?php echo e($patient['rut'] ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha nacimiento</label>
                    <input type="date" name="birthdate" class="form-control" value="<?php echo e($patient['birthdate'] ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <?php
                        $currentStatus = $patient['status'] ?? '';
                        $statuses = ['Nuevo', 'Activo', 'En seguimiento', 'Alta'];
                        ?>
                        <?php foreach ($statuses as $status): ?>
                            <option value="<?php echo e($status); ?>" <?php echo $currentStatus === $status ? 'selected' : ''; ?>>
                                <?php echo e($status); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Correo</label>
                    <input type="email" name="email" class="form-control" value="<?php echo e($patient['email'] ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo e($patient['phone'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="address" class="form-control" value="<?php echo e($patient['address'] ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Ocupación</label>
                    <input type="text" name="occupation" class="form-control" value="<?php echo e($patient['occupation'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Seguro/Previsión</label>
                    <input type="text" name="insurance" class="form-control" value="<?php echo e($patient['insurance'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Profesional derivante</label>
                    <input type="text" name="referring_physician" class="form-control" value="<?php echo e($patient['referring_physician'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contacto de emergencia</label>
                    <input type="text" name="emergency_contact_name" class="form-control" value="<?php echo e($patient['emergency_contact_name'] ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Teléfono emergencia</label>
                    <input type="text" name="emergency_contact_phone" class="form-control" value="<?php echo e($patient['emergency_contact_phone'] ?? ''); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Motivo de consulta</label>
                    <textarea name="reason_for_visit" class="form-control" rows="2"><?php echo e($patient['reason_for_visit'] ?? ''); ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Diagnóstico/objetivo terapéutico</label>
                    <textarea name="diagnosis" class="form-control" rows="2"><?php echo e($patient['diagnosis'] ?? ''); ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Alergias/precauciones</label>
                    <textarea name="allergies" class="form-control" rows="2"><?php echo e($patient['allergies'] ?? ''); ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Observaciones clínicas</label>
                    <textarea name="notes" class="form-control" rows="3"><?php echo e($patient['notes'] ?? ''); ?></textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="index.php?route=patients" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
