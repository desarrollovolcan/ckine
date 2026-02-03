<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Editar paciente</h4>
        <small class="text-muted">ID paciente: <?php echo e($patientId ?: 'Sin ID'); ?></small>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=patients/update&id=<?php echo e($patientId); ?>">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="name" class="form-control" value="María López">
                </div>
                <div class="col-md-3">
                    <label class="form-label">RUT</label>
                    <input type="text" name="rut" class="form-control" value="12.345.678-9">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <option selected>Activo</option>
                        <option>En seguimiento</option>
                        <option>Alta</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Observaciones clínicas</label>
                    <textarea name="notes" class="form-control" rows="3">Paciente en seguimiento por lesión de rodilla.</textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="index.php?route=patients" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
