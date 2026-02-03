<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo $appointment ? '/agenda/actualizar' : '/agenda'; ?>">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <?php if ($appointment): ?>
                <input type="hidden" name="id" value="<?php echo (int)$appointment['id']; ?>">
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Paciente</label>
                    <select class="form-select" name="patient_id" required>
                        <?php foreach ($patients as $patient): ?>
                            <option value="<?php echo (int)$patient['id']; ?>" <?php echo ($appointment['patient_id'] ?? '') == $patient['id'] ? 'selected' : ''; ?>>
                                <?php echo e($patient['first_name'] . ' ' . $patient['last_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Profesional</label>
                    <select class="form-select" name="professional_id" required>
                        <?php foreach ($professionals as $professional): ?>
                            <option value="<?php echo (int)$professional['id']; ?>" <?php echo ($appointment['professional_id'] ?? '') == $professional['id'] ? 'selected' : ''; ?>>
                                <?php echo e($professional['first_name'] . ' ' . $professional['last_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Box</label>
                    <select class="form-select" name="box_id" required>
                        <?php foreach ($boxes as $box): ?>
                            <option value="<?php echo (int)$box['id']; ?>" <?php echo ($appointment['box_id'] ?? '') == $box['id'] ? 'selected' : ''; ?>>
                                <?php echo e($box['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Servicio</label>
                    <select class="form-select" name="service_id" required>
                        <?php foreach ($services as $service): ?>
                            <option value="<?php echo (int)$service['id']; ?>" <?php echo ($appointment['service_id'] ?? '') == $service['id'] ? 'selected' : ''; ?>>
                                <?php echo e($service['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Fecha</label>
                    <input type="date" class="form-control" name="date" value="<?php echo e($appointment ? date('Y-m-d', strtotime($appointment['start_at'])) : ''); ?>" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Hora</label>
                    <input type="time" class="form-control" name="start_time" value="<?php echo e($appointment ? date('H:i', strtotime($appointment['start_at'])) : ''); ?>" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Duración (min)</label>
                    <input type="number" class="form-control" name="duration_minutes" value="<?php echo e($appointment ? (int)((strtotime($appointment['end_at']) - strtotime($appointment['start_at'])) / 60) : 60); ?>" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Estado</label>
                    <select class="form-select" name="status">
                        <?php $statuses = ['pendiente', 'confirmada', 'atendida', 'no_asistio', 'cancelada']; ?>
                        <?php foreach ($statuses as $status): ?>
                            <option value="<?php echo e($status); ?>" <?php echo ($appointment['status'] ?? 'pendiente') === $status ? 'selected' : ''; ?>><?php echo e($status); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Notas</label>
                    <textarea class="form-control" name="notes" rows="3"><?php echo e($appointment['notes'] ?? ''); ?></textarea>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <a href="/agenda" class="btn btn-light">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
