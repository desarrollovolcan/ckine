<?php use App\Core\CSRF; ?>
<div class="d-flex justify-content-between mb-3">
    <h4>Agenda</h4>
    <a class="btn btn-primary" href="/appointments/create">Nueva cita</a>
</div>
<form class="row g-2 mb-3" method="get" action="/appointments">
    <div class="col-md-3">
        <input type="date" name="date" class="form-control" value="<?php echo htmlspecialchars($filters['date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    </div>
    <div class="col-md-3">
        <select name="professional_id" class="form-select">
            <option value="">Profesional</option>
            <?php foreach ($professionals as $professional): ?>
                <option value="<?php echo $professional['id']; ?>" <?php echo ((string) ($filters['professional_id'] ?? '') === (string) $professional['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($professional['user_name'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <select name="box_id" class="form-select">
            <option value="">Box</option>
            <?php foreach ($boxes as $box): ?>
                <option value="<?php echo $box['id']; ?>" <?php echo ((string) ($filters['box_id'] ?? '') === (string) $box['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($box['name'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2">
        <select name="status" class="form-select">
            <option value="">Estado</option>
            <?php foreach (['pendiente','confirmada','atendida','no_asistio','cancelada'] as $option): ?>
                <option value="<?php echo $option; ?>" <?php echo ($filters['status'] ?? '') === $option ? 'selected' : ''; ?>><?php echo ucfirst(str_replace('_', ' ', $option)); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-1">
        <button class="btn btn-secondary w-100" type="submit">Filtrar</button>
    </div>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Paciente</th>
            <th>Profesional</th>
            <th>Box</th>
            <th>Servicio</th>
            <th>Inicio</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($appointments as $appointment): ?>
            <tr>
                <td><?php echo htmlspecialchars($appointment['first_name'] . ' ' . $appointment['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($appointment['professional_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($appointment['box_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($appointment['service_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($appointment['start_time'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo ucfirst(str_replace('_', ' ', $appointment['status'])); ?></td>
                <td class="d-flex gap-2">
                    <a class="btn btn-sm btn-info" href="/appointments/<?php echo $appointment['id']; ?>/edit">Editar</a>
                    <form method="post" action="/appointments/<?php echo $appointment['id']; ?>/status">
                        <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
                        <input type="hidden" name="status" value="confirmada">
                        <button class="btn btn-sm btn-success" type="submit">Confirmar</button>
                    </form>
                    <form method="post" action="/appointments/<?php echo $appointment['id']; ?>/status">
                        <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
                        <input type="hidden" name="status" value="cancelada">
                        <input type="hidden" name="cancel_reason" value="Cancelada desde agenda">
                        <button class="btn btn-sm btn-warning" type="submit">Cancelar</button>
                    </form>
                    <form method="post" action="/appointments/<?php echo $appointment['id']; ?>/delete" onsubmit="return confirm('¿Eliminar cita?')">
                        <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
                        <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
