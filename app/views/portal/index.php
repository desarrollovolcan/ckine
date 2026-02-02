<?php use App\Core\CSRF; ?>
<h4 class="mb-3">Agendar cita</h4>
<?php if (!empty($errors['conflict'])): ?>
    <div class="alert alert-danger"><?php echo implode(', ', $errors['conflict']); ?></div>
<?php endif; ?>
<form method="post" action="/portal">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
    <h5>Datos del paciente</h5>
    <?php include __DIR__ . '/../patients/form.php'; ?>
    <h5 class="mt-4">Datos de la cita</h5>
    <?php\n    $startValue = !empty($appointment['start_time']) ? str_replace(' ', 'T', substr($appointment['start_time'], 0, 16)) : '';\n    $endValue = !empty($appointment['end_time']) ? str_replace(' ', 'T', substr($appointment['end_time'], 0, 16)) : '';\n    ?>\n    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Profesional</label>
            <select name="professional_id" class="form-select" required>
                <?php foreach ($professionals as $professional): ?>
                    <option value="<?php echo $professional['id']; ?>" <?php echo ($professional['id'] == ($appointment['professional_id'] ?? 0)) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($professional['user_name'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
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
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Inicio</label>
            <input type="datetime-local" name="start_time" class="form-control" value="<?php echo htmlspecialchars($startValue, ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Término</label>
            <input type="datetime-local" name="end_time" class="form-control" value="<?php echo htmlspecialchars($endValue, ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Enviar solicitud</button>
</form>
