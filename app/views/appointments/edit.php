<?php $appointment = $appointment ?? []; ?>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Editar cita</h4>
        <small class="text-muted">Actualiza la información de la cita.</small>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=appointments/update&id=<?php echo e($appointment['id'] ?? 0); ?>">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Paciente</label>
                    <select name="patient_id" class="form-select" required>
                        <option value="">Selecciona un paciente</option>
                        <?php foreach ($patients as $patient): ?>
                            <option value="<?php echo e($patient['id']); ?>" <?php echo ((int)$patient['id'] === (int)($appointment['patient_id'] ?? 0)) ? 'selected' : ''; ?>>
                                <?php echo e($patient['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Profesional</label>
                    <select name="professional_id" class="form-select" required>
                        <option value="">Selecciona un profesional</option>
                        <?php foreach ($professionals as $professional): ?>
                            <option value="<?php echo e($professional['id']); ?>" <?php echo ((int)$professional['id'] === (int)($appointment['professional_id'] ?? 0)) ? 'selected' : ''; ?>>
                                <?php echo e($professional['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="date" class="form-control" value="<?php echo e($appointment['appointment_date'] ?? ''); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Hora</label>
                    <input type="time" name="time" class="form-control" value="<?php echo e($appointment['appointment_time'] ?? ''); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Box</label>
                    <select name="box_id" class="form-select">
                        <option value="">Sin asignar</option>
                        <?php foreach ($boxes as $box): ?>
                            <option value="<?php echo e($box['id']); ?>" <?php echo ((int)$box['id'] === (int)($appointment['box_id'] ?? 0)) ? 'selected' : ''; ?>>
                                <?php echo e($box['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Estado</label>
                    <?php $currentStatus = $appointment['status'] ?? 'Pendiente'; ?>
                    <select name="status" class="form-select">
                        <option value="Pendiente" <?php echo $currentStatus === 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                        <option value="Confirmada" <?php echo $currentStatus === 'Confirmada' ? 'selected' : ''; ?>>Confirmada</option>
                        <option value="En espera" <?php echo $currentStatus === 'En espera' ? 'selected' : ''; ?>>En espera</option>
                        <option value="Cancelada" <?php echo $currentStatus === 'Cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Motivo / Observaciones</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Descripción breve de la cita"><?php echo e($appointment['notes'] ?? ''); ?></textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="index.php?route=appointments" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar cita</button>
            </div>
        </form>
    </div>
</div>
