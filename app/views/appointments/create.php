<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Agendar nueva cita</h4>
        <small class="text-muted">Coordina fecha, profesional y box asignado.</small>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=appointments/store">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Paciente</label>
                    <input type="text" name="patient" class="form-control" placeholder="Buscar paciente">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Profesional</label>
                    <input type="text" name="professional" class="form-control" placeholder="Asignar profesional">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Hora</label>
                    <input type="time" name="time" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Box</label>
                    <select name="box" class="form-select">
                        <option value="Box 1">Box 1</option>
                        <option value="Box 2">Box 2</option>
                        <option value="Sala funcional">Sala funcional</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Motivo / Observaciones</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Descripción breve de la cita"></textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="index.php?route=appointments" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar cita</button>
            </div>
        </form>
    </div>
</div>
