<div class="card">
    <div class="card-body">
        <h4 class="card-title">Agendamiento en línea</h4>
        <p class="text-muted">Completa el formulario para solicitar una sesión.</p>
        <form method="post" action="/portal" class="row g-3">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="first_name" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Apellido</label>
                <input type="text" class="form-control" name="last_name" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">RUT</label>
                <input type="text" class="form-control" name="rut">
            </div>
            <div class="col-md-4">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="col-md-4">
                <label class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="phone">
            </div>
            <div class="col-md-4">
                <label class="form-label">Profesional</label>
                <select class="form-select" name="professional_id" required>
                    <?php foreach ($professionals as $professional): ?>
                        <option value="<?php echo (int)$professional['id']; ?>"><?php echo e($professional['first_name'] . ' ' . $professional['last_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Box</label>
                <select class="form-select" name="box_id" required>
                    <?php foreach ($boxes as $box): ?>
                        <option value="<?php echo (int)$box['id']; ?>"><?php echo e($box['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Servicio</label>
                <select class="form-select" name="service_id" required>
                    <?php foreach ($services as $service): ?>
                        <option value="<?php echo (int)$service['id']; ?>"><?php echo e($service['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Fecha</label>
                <input type="date" class="form-control" name="date" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Hora</label>
                <input type="time" class="form-control" name="start_time" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Duración (min)</label>
                <input type="number" class="form-control" name="duration_minutes" value="60" required>
            </div>
            <div class="col-12">
                <label class="form-label">Notas</label>
                <textarea class="form-control" name="notes" rows="3"></textarea>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Enviar solicitud</button>
            </div>
        </form>
    </div>
</div>
