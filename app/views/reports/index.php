<h4 class="mb-3">Reportes diarios</h4>
<form class="row g-2 mb-3" method="get" action="<?php echo $baseUrl; ?>reports">
    <div class="col-md-4">
        <input type="date" name="date" class="form-control" value="<?php echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
    <div class="col-md-2">
        <button class="btn btn-secondary" type="submit">Actualizar</button>
    </div>
</form>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>No-show</h6>
                <p class="display-6"><?php echo $noShows; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Pacientes nuevos</h6>
                <p class="display-6"><?php echo $newPatients; ?></p>
            </div>
        </div>
    </div>
</div>
<h5 class="mt-4">Agenda del día</h5>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Hora</th>
            <th>Paciente</th>
            <th>Profesional</th>
            <th>Box</th>
            <th>Servicio</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($daily as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['start_time'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($item['first_name'] . ' ' . $item['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($item['professional_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($item['box_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($item['service_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($item['status'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<h5 class="mt-4">Ocupación de box</h5>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Box</th>
            <th>Citas</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($occupancy as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($item['total'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
