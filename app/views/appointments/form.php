<?php $appointment = $appointment ?? []; ?>
<?php if (!empty($errors['conflict'])): ?>
    <div class="alert alert-danger"><?php echo implode(', ', $errors['conflict']); ?></div>
<?php endif; ?>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Paciente</label>
        <select name="patient_id" class="form-select" required>
            <?php foreach ($patients as $patient): ?>
                <option value="<?php echo $patient['id']; ?>" <?php echo ($patient['id'] == ($appointment['patient_id'] ?? 0)) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['patient_id'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['patient_id']); ?></small>
        <?php endif; ?>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Profesional</label>
        <select name="professional_id" class="form-select" required>
            <?php foreach ($professionals as $professional): ?>
                <option value="<?php echo $professional['id']; ?>" <?php echo ($professional['id'] == ($appointment['professional_id'] ?? 0)) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($professional['user_name'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['professional_id'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['professional_id']); ?></small>
        <?php endif; ?>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Box</label>
        <select name="box_id" class="form-select" required>
            <?php foreach ($boxes as $box): ?>
                <option value="<?php echo $box['id']; ?>" <?php echo ($box['id'] == ($appointment['box_id'] ?? 0)) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($box['name'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['box_id'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['box_id']); ?></small>
        <?php endif; ?>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Servicio</label>
        <select name="service_id" class="form-select" required>
            <?php foreach ($services as $service): ?>
                <option value="<?php echo $service['id']; ?>" <?php echo ($service['id'] == ($appointment['service_id'] ?? 0)) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($service['name'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['service_id'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['service_id']); ?></small>
        <?php endif; ?>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Estado</label>
        <select name="status" class="form-select">
            <?php $status = $appointment['status'] ?? 'pendiente'; ?>
            <?php foreach (['pendiente','confirmada','atendida','no_asistio','cancelada'] as $option): ?>
                <option value="<?php echo $option; ?>" <?php echo $status === $option ? 'selected' : ''; ?>><?php echo ucfirst(str_replace('_', ' ', $option)); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php\n    $startValue = !empty($appointment['start_time']) ? str_replace(' ', 'T', substr($appointment['start_time'], 0, 16)) : '';\n    $endValue = !empty($appointment['end_time']) ? str_replace(' ', 'T', substr($appointment['end_time'], 0, 16)) : '';\n    ?>\n    <div class="col-md-6 mb-3">
        <label class="form-label">Inicio</label>
        <input type="datetime-local" name="start_time" class="form-control" value="<?php echo htmlspecialchars($startValue, ENT_QUOTES, 'UTF-8'); ?>" required>
        <?php if (!empty($errors['start_time'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['start_time']); ?></small>
        <?php endif; ?>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Término</label>
        <input type="datetime-local" name="end_time" class="form-control" value="<?php echo htmlspecialchars($endValue, ENT_QUOTES, 'UTF-8'); ?>" required>
        <?php if (!empty($errors['end_time'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['end_time']); ?></small>
        <?php endif; ?>
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">Notas</label>
        <textarea name="notes" class="form-control" rows="3"><?php echo htmlspecialchars($appointment['notes'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">Motivo cancelación</label>
        <input type="text" name="cancel_reason" class="form-control" value="<?php echo htmlspecialchars($appointment['cancel_reason'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    </div>
</div>
