<?php $professional = $professional ?? []; ?>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Usuario</label>
        <select name="user_id" class="form-select" required>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo $user['id']; ?>" <?php echo ($user['id'] == ($professional['user_id'] ?? 0)) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['user_id'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['user_id']); ?></small>
        <?php endif; ?>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Título</label>
        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($professional['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Registro/License</label>
        <input type="text" name="license_number" class="form-control" value="<?php echo htmlspecialchars($professional['license_number'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Teléfono</label>
        <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($professional['phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($professional['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <?php if (!empty($errors['email'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['email']); ?></small>
        <?php endif; ?>
    </div>
</div>
