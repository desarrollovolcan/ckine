<?php $box = $box ?? []; ?>
<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($box['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
    <?php if (!empty($errors['name'])): ?>
        <small class="text-danger"><?php echo implode(', ', $errors['name']); ?></small>
    <?php endif; ?>
</div>
<div class="mb-3">
    <label class="form-label">Descripción</label>
    <input type="text" name="description" class="form-control" value="<?php echo htmlspecialchars($box['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
</div>
<div class="mb-3 form-check">
    <input type="checkbox" name="is_active" class="form-check-input" id="isActiveBox" <?php echo !empty($box['is_active']) ? 'checked' : ''; ?>>
    <label class="form-check-label" for="isActiveBox">Activo</label>
</div>
