<?php $patient = $patient ?? []; ?>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Nombres</label>
        <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($patient['first_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <?php if (!empty($errors['first_name'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['first_name']); ?></small>
        <?php endif; ?>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Apellidos</label>
        <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($patient['last_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <?php if (!empty($errors['last_name'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['last_name']); ?></small>
        <?php endif; ?>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">RUT</label>
        <input type="text" name="rut" class="form-control" value="<?php echo htmlspecialchars($patient['rut'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <?php if (!empty($errors['rut'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['rut']); ?></small>
        <?php endif; ?>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Fecha nacimiento</label>
        <input type="date" name="birth_date" class="form-control" value="<?php echo htmlspecialchars($patient['birth_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Teléfono</label>
        <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($patient['phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($patient['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <?php if (!empty($errors['email'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['email']); ?></small>
        <?php endif; ?>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Dirección</label>
        <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($patient['address'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Previsión</label>
        <select name="insurance" class="form-select">
            <?php $insurance = $patient['insurance'] ?? 'Particular'; ?>
            <?php foreach (['Fonasa','Isapre','Particular'] as $option): ?>
                <option value="<?php echo $option; ?>" <?php echo $insurance === $option ? 'selected' : ''; ?>><?php echo $option; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Contacto emergencia</label>
        <input type="text" name="emergency_contact" class="form-control" value="<?php echo htmlspecialchars($patient['emergency_contact'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">Observaciones</label>
        <textarea name="notes" class="form-control" rows="3"><?php echo htmlspecialchars($patient['notes'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div>
</div>
