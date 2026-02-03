<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo $patient ? '/pacientes/actualizar' : '/pacientes'; ?>">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <?php if ($patient): ?>
                <input type="hidden" name="id" value="<?php echo (int)$patient['id']; ?>">
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="first_name" value="<?php echo e($patient['first_name'] ?? ''); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Apellido</label>
                    <input type="text" class="form-control" name="last_name" value="<?php echo e($patient['last_name'] ?? ''); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">RUT</label>
                    <input type="text" class="form-control" name="rut" value="<?php echo e($patient['rut'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha nacimiento</label>
                    <input type="date" class="form-control" name="birth_date" value="<?php echo e($patient['birth_date'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Teléfono</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo e($patient['phone'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo e($patient['email'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Dirección</label>
                    <input type="text" class="form-control" name="address" value="<?php echo e($patient['address'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Previsión</label>
                    <select class="form-select" name="insurance">
                        <?php $insurance = $patient['insurance'] ?? ''; ?>
                        <option value="">Selecciona</option>
                        <option value="Fonasa" <?php echo $insurance === 'Fonasa' ? 'selected' : ''; ?>>Fonasa</option>
                        <option value="Isapre" <?php echo $insurance === 'Isapre' ? 'selected' : ''; ?>>Isapre</option>
                        <option value="Particular" <?php echo $insurance === 'Particular' ? 'selected' : ''; ?>>Particular</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Contacto emergencia</label>
                    <input type="text" class="form-control" name="emergency_contact_name" value="<?php echo e($patient['emergency_contact_name'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Teléfono emergencia</label>
                    <input type="text" class="form-control" name="emergency_contact_phone" value="<?php echo e($patient['emergency_contact_phone'] ?? ''); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Observaciones</label>
                    <textarea class="form-control" name="notes" rows="3"><?php echo e($patient['notes'] ?? ''); ?></textarea>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <a href="<?php echo app_path('/pacientes'); ?>" class="btn btn-light">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
