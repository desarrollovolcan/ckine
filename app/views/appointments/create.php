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
                    <select name="patient_id" class="form-select" required>
                        <option value="">Selecciona paciente</option>
                        <?php foreach ($patients as $patient): ?>
                            <option value="<?php echo e($patient['id']); ?>"><?php echo e($patient['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Profesional</label>
                    <select name="professional_id" class="form-select" required>
                        <option value="">Selecciona profesional</option>
                        <?php foreach ($professionals as $professional): ?>
                            <option value="<?php echo e($professional['id']); ?>"><?php echo e($professional['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="appointment_date" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Hora</label>
                    <input type="time" name="appointment_time" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Box</label>
                    <select name="box_id" class="form-select">
                        <option value="">Sin asignar</option>
                        <?php foreach ($boxes as $box): ?>
                            <option value="<?php echo e($box['id']); ?>"><?php echo e($box['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <?php foreach (['Pendiente', 'Confirmada', 'En espera', 'Cancelada'] as $status): ?>
                            <option value="<?php echo e($status); ?>"><?php echo e($status); ?></option>
                        <?php endforeach; ?>
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
