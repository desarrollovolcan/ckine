<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Registrar profesional</h4>
        <small class="text-muted">Agrega kinesiólogos y especialistas a la clínica.</small>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=professionals/store">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="name" class="form-control" placeholder="Ej: Paula Fuentes" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">RUT</label>
                    <input type="text" name="rut" class="form-control" placeholder="12.345.678-9" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Registro profesional</label>
                    <input type="text" name="license_number" class="form-control" placeholder="KINE-2024-001" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Especialidad</label>
                    <input type="text" name="specialty" class="form-control" placeholder="Kinesiología deportiva" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Correo</label>
                    <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-control" placeholder="+56 9 1234 5678" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <option value="Activo">Activo</option>
                        <option value="En pausa">En pausa</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Modalidad</label>
                    <select name="modality" class="form-select" required>
                        <option value="" selected disabled>Selecciona</option>
                        <option value="Presencial">Presencial</option>
                        <option value="Mixta">Mixta</option>
                        <option value="Telemedicina">Telemedicina</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Box asignado</label>
                    <select name="box" class="form-select">
                        <option value="">Por definir</option>
                        <option value="Box 1">Box 1</option>
                        <option value="Box 2">Box 2</option>
                        <option value="Box 3">Box 3</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Horario habitual</label>
                    <input type="text" name="schedule" class="form-control" placeholder="Lun a Vie 08:00 - 16:00" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Notas</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Disponibilidad, horarios, etc."></textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="index.php?route=professionals" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar profesional</button>
            </div>
        </form>
    </div>
</div>
