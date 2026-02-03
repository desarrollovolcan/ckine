<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Registrar nota clínica</h4>
        <small class="text-muted">Paciente: <?php echo e($patient['name'] ?? 'No disponible'); ?></small>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=clinical/note/store">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="patient_id" value="<?php echo e($patient['id']); ?>">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="note_date" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Profesional</label>
                    <select name="professional_id" class="form-select">
                        <option value="">Sin asignar</option>
                        <?php foreach ($professionals as $professional): ?>
                            <option value="<?php echo e($professional['id']); ?>"><?php echo e($professional['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Título</label>
                    <input type="text" name="title" class="form-control" placeholder="Sesión 03" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Detalle de la evolución del paciente"></textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="index.php?route=clinical/show&patient_id=<?php echo e($patient['id']); ?>" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar nota</button>
            </div>
        </form>
    </div>
</div>
