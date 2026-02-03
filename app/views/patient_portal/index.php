<div class="row g-3">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Portal de agendamiento</h4>
                <small class="text-muted">Configura el acceso público y la disponibilidad.</small>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    El portal está <strong>activo</strong> para recibir solicitudes de pacientes.
                </div>
                <div class="mb-3">
                    <label class="form-label">URL pública</label>
                    <div class="input-group">
                        <input type="text" class="form-control" value="https://clinic.example.com/portal" readonly>
                        <button class="btn btn-outline-secondary" type="button">Copiar</button>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mensaje de bienvenida</label>
                    <textarea class="form-control" rows="3">Agenda tu hora en línea. Recibirás confirmación por correo.</textarea>
                </div>
                <button type="button" class="btn btn-primary">Guardar configuración</button>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Indicadores</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Solicitudes pendientes</span>
                        <span class="fw-semibold">5</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Solicitudes aprobadas</span>
                        <span class="fw-semibold">18</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Última solicitud</span>
                        <span class="fw-semibold">Hace 2 horas</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
