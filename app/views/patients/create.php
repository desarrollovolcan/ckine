<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Crear paciente</h4>
        <small class="text-muted">Completa los datos básicos para registrar un nuevo paciente.</small>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=patients/store">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="name" class="form-control" placeholder="Ej: María López" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">RUT</label>
                    <input type="text" name="rut" class="form-control" placeholder="12.345.678-9">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha nacimiento</label>
                    <input type="date" name="birthdate" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Correo</label>
                    <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-control" placeholder="+56 9 1234 5678">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="address" class="form-control" placeholder="Calle, comuna, ciudad">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Ocupación</label>
                    <input type="text" name="occupation" class="form-control" placeholder="Ej: Docente, estudiante">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <option value="Nuevo">Nuevo</option>
                        <option value="Activo">Activo</option>
                        <option value="En seguimiento">En seguimiento</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Seguro/Previsión</label>
                    <input type="text" name="insurance" class="form-control" placeholder="Isapre, Fonasa, particular">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Profesional derivante</label>
                    <input type="text" name="referring_physician" class="form-control" placeholder="Nombre del médico o profesional">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contacto de emergencia</label>
                    <input type="text" name="emergency_contact_name" class="form-control" placeholder="Nombre y relación">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Teléfono emergencia</label>
                    <input type="text" name="emergency_contact_phone" class="form-control" placeholder="+56 9 1234 5678">
                </div>
                <div class="col-12">
                    <label class="form-label">Motivo de consulta</label>
                    <textarea name="reason_for_visit" class="form-control" rows="2" placeholder="Ej: Dolor lumbar, rehabilitación post cirugía"></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Diagnóstico/objetivo terapéutico</label>
                    <textarea name="diagnosis" class="form-control" rows="2" placeholder="Diagnóstico clínico o foco de tratamiento"></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Alergias/precauciones</label>
                    <textarea name="allergies" class="form-control" rows="2" placeholder="Medicamentos, materiales o condiciones relevantes"></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Observaciones</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Notas generales del paciente"></textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="index.php?route=patients" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar paciente</button>
            </div>
        </form>
    </div>
</div>
