<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Editar profesional</h4>
        <small class="text-muted">ID profesional: <?php echo e($professionalId ?: 'Sin ID'); ?></small>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=professionals/update&id=<?php echo e($professionalId); ?>">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e($professional['name'] ?? ''); ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">RUT</label>
                    <input type="text" name="rut" class="form-control" value="<?php echo e($professional['rut'] ?? ''); ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Registro profesional</label>
                    <input type="text" name="license_number" class="form-control" value="<?php echo e($professional['license_number'] ?? ''); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Especialidad</label>
                    <input type="text" name="specialty" class="form-control" value="<?php echo e($professional['specialty'] ?? ''); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Correo</label>
                    <input type="email" name="email" class="form-control" value="<?php echo e($professional['email'] ?? ''); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo e($professional['phone'] ?? ''); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <option value="Activo" <?php echo ($professional['status'] ?? '') === 'Activo' ? 'selected' : ''; ?>>Activo</option>
                        <option value="En pausa" <?php echo ($professional['status'] ?? '') === 'En pausa' ? 'selected' : ''; ?>>En pausa</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Modalidad</label>
                    <select name="modality" class="form-select" required>
                        <option value="Presencial" <?php echo ($professional['modality'] ?? '') === 'Presencial' ? 'selected' : ''; ?>>Presencial</option>
                        <option value="Mixta" <?php echo ($professional['modality'] ?? '') === 'Mixta' ? 'selected' : ''; ?>>Mixta</option>
                        <option value="Telemedicina" <?php echo ($professional['modality'] ?? '') === 'Telemedicina' ? 'selected' : ''; ?>>Telemedicina</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Box asignado</label>
                    <select name="box" class="form-select">
                        <option value="" <?php echo ($professional['box'] ?? '') === '' ? 'selected' : ''; ?>>Por definir</option>
                        <option value="Box 1" <?php echo ($professional['box'] ?? '') === 'Box 1' ? 'selected' : ''; ?>>Box 1</option>
                        <option value="Box 2" <?php echo ($professional['box'] ?? '') === 'Box 2' ? 'selected' : ''; ?>>Box 2</option>
                        <option value="Box 3" <?php echo ($professional['box'] ?? '') === 'Box 3' ? 'selected' : ''; ?>>Box 3</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Horario habitual</label>
                    <input type="text" name="schedule" class="form-control" value="<?php echo e($professional['schedule'] ?? ''); ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Notas</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Disponibilidad, horarios, etc."><?php echo e($professional['notes'] ?? ''); ?></textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="index.php?route=professionals" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
