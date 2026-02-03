<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Editar box</h4>
        <small class="text-muted">ID box: <?php echo e($boxId ?: 'Sin ID'); ?></small>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=boxes/update&id=<?php echo e($boxId); ?>">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Nombre del box</label>
                    <input type="text" name="name" class="form-control" value="Box 1">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Capacidad</label>
                    <input type="text" name="capacity" class="form-control" value="2 pacientes">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <option selected>Disponible</option>
                        <option>En uso</option>
                        <option>En mantenimiento</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Equipamiento</label>
                    <textarea name="equipment" class="form-control" rows="3">Camilla, electroestimulación</textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="index.php?route=boxes" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
