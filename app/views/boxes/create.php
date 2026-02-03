<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Crear box o sala</h4>
        <small class="text-muted">Define el espacio y su equipamiento.</small>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=boxes/store">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Nombre del box</label>
                    <input type="text" name="name" class="form-control" placeholder="Box 4">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Capacidad</label>
                    <input type="text" name="capacity" class="form-control" placeholder="2 pacientes">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <option value="Disponible">Disponible</option>
                        <option value="En mantenimiento">En mantenimiento</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Equipamiento</label>
                    <textarea name="equipment" class="form-control" rows="3" placeholder="Camilla, electroestimulación, pesas..."></textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="index.php?route=boxes" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar box</button>
            </div>
        </form>
    </div>
</div>
