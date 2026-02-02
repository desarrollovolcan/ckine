<?php $service = $service ?? []; ?>
<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($service['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
    <?php if (!empty($errors['name'])): ?>
        <small class="text-danger"><?php echo implode(', ', $errors['name']); ?></small>
    <?php endif; ?>
</div>
<div class="mb-3">
    <label class="form-label">Duración (min)</label>
    <input type="number" name="duration_minutes" class="form-control" value="<?php echo htmlspecialchars($service['duration_minutes'] ?? 60, ENT_QUOTES, 'UTF-8'); ?>" required>
</div>
<div class="mb-3">
    <label class="form-label">Precio</label>
    <input type="number" step="0.01" name="price" class="form-control" value="<?php echo htmlspecialchars($service['price'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
</div>
<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($service['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
</div>
