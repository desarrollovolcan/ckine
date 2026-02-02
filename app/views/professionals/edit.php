<?php use App\Core\CSRF; ?>
<h4 class="mb-3">Editar profesional</h4>
<form method="post" action="/professionals/<?php echo $professional['id']; ?>/update">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
    <?php include __DIR__ . '/form.php'; ?>
    <button class="btn btn-primary" type="submit">Actualizar</button>
    <a class="btn btn-light" href="/professionals">Cancelar</a>
</form>
<hr>
<h5>Horarios</h5>
<form method="post" action="/professionals/<?php echo $professional['id']; ?>/schedules">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
    <div class="row">
        <div class="col-md-3 mb-3">
            <label class="form-label">Día</label>
            <select name="weekday" class="form-select">
                <?php foreach ([0 => 'Domingo',1=>'Lunes',2=>'Martes',3=>'Miércoles',4=>'Jueves',5=>'Viernes',6=>'Sábado'] as $value => $label): ?>
                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Inicio</label>
            <input type="time" name="start_time" class="form-control" required>
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Fin</label>
            <input type="time" name="end_time" class="form-control" required>
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Duración (min)</label>
            <input type="number" name="duration_minutes" class="form-control" value="60" required>
        </div>
    </div>
    <button class="btn btn-secondary" type="submit">Agregar horario</button>
</form>
<table class="table table-sm mt-3">
    <thead>
        <tr>
            <th>Día</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Duración</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($schedules as $schedule): ?>
            <tr>
                <td><?php echo ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'][$schedule['weekday']]; ?></td>
                <td><?php echo htmlspecialchars($schedule['start_time'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($schedule['end_time'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($schedule['duration_minutes'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <form method="post" action="/professionals/<?php echo $professional['id']; ?>/schedules/<?php echo $schedule['id']; ?>/delete" onsubmit="return confirm('¿Eliminar horario?')">
                        <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
                        <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
