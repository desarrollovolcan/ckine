<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="card-title mb-0">Horarios de <?php echo e($professional['first_name'] . ' ' . $professional['last_name']); ?></h4>
            <small class="text-muted">Disponibilidad semanal del profesional.</small>
        </div>
        <a href="/profesionales" class="btn btn-light btn-sm">Volver</a>
    </div>
    <div class="card-body">
        <form method="post" action="/profesionales/horarios" class="row g-2 align-items-end">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="professional_id" value="<?php echo (int)$professional['id']; ?>">
            <div class="col-md-3">
                <label class="form-label">Día</label>
                <select class="form-select" name="day_of_week">
                    <option value="1">Lunes</option>
                    <option value="2">Martes</option>
                    <option value="3">Miércoles</option>
                    <option value="4">Jueves</option>
                    <option value="5">Viernes</option>
                    <option value="6">Sábado</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Inicio</label>
                <input type="time" class="form-control" name="start_time" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Fin</label>
                <input type="time" class="form-control" name="end_time" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Slot (min)</label>
                <input type="number" class="form-control" name="slot_minutes" value="60" required>
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary" type="submit">Agregar</button>
            </div>
        </form>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Día</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Slot</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($schedules)): ?>
                        <tr>
                            <td colspan="4" class="text-muted text-center">Sin horarios.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($schedules as $schedule): ?>
                            <tr>
                                <td><?php echo e(['','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'][$schedule['day_of_week']] ?? ''); ?></td>
                                <td><?php echo e($schedule['start_time']); ?></td>
                                <td><?php echo e($schedule['end_time']); ?></td>
                                <td><?php echo (int)$schedule['slot_minutes']; ?> min</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
