<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Agenda</h4>
        <a href="/agenda/nueva" class="btn btn-primary btn-sm">Nueva cita</a>
    </div>
    <div class="card-body">
        <form method="get" class="row g-2 mb-3">
            <div class="col-md-2">
                <input type="date" class="form-control" name="date" value="<?php echo e($filters['date']); ?>">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="status">
                    <option value="">Estado</option>
                    <?php $statuses = ['pendiente', 'confirmada', 'atendida', 'no_asistio', 'cancelada']; ?>
                    <?php foreach ($statuses as $status): ?>
                        <option value="<?php echo e($status); ?>" <?php echo $filters['status'] === $status ? 'selected' : ''; ?>><?php echo e($status); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="professional_id">
                    <option value="">Profesional</option>
                    <?php foreach ($professionals as $professional): ?>
                        <option value="<?php echo (int)$professional['id']; ?>" <?php echo (string)$filters['professional_id'] === (string)$professional['id'] ? 'selected' : ''; ?>>
                            <?php echo e($professional['first_name'] . ' ' . $professional['last_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="box_id">
                    <option value="">Box</option>
                    <?php foreach ($boxes as $box): ?>
                        <option value="<?php echo (int)$box['id']; ?>" <?php echo (string)$filters['box_id'] === (string)$box['id'] ? 'selected' : ''; ?>><?php echo e($box['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="patient_id">
                    <option value="">Paciente</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?php echo (int)$patient['id']; ?>" <?php echo (string)$filters['patient_id'] === (string)$patient['id'] ? 'selected' : ''; ?>>
                            <?php echo e($patient['first_name'] . ' ' . $patient['last_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12">
                <button class="btn btn-outline-primary" type="submit">Filtrar</button>
                <a href="/agenda" class="btn btn-light">Limpiar</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Paciente</th>
                        <th>Profesional</th>
                        <th>Box</th>
                        <th>Servicio</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?php echo e(date('d/m/Y H:i', strtotime($appointment['start_at']))); ?></td>
                            <td><?php echo e($appointment['first_name'] . ' ' . $appointment['last_name']); ?></td>
                            <td><?php echo e($appointment['prof_name'] . ' ' . $appointment['prof_last']); ?></td>
                            <td><?php echo e($appointment['box_name']); ?></td>
                            <td><?php echo e($appointment['service_name']); ?></td>
                            <td><?php echo e($appointment['status']); ?></td>
                            <td class="text-end">
                                <a href="/agenda/editar?id=<?php echo (int)$appointment['id']; ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form method="post" action="/agenda/estado" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo (int)$appointment['id']; ?>">
                                    <input type="hidden" name="status" value="confirmada">
                                    <button class="btn btn-sm btn-outline-success" type="submit">Confirmar</button>
                                </form>
                                <form method="post" action="/agenda/eliminar" class="d-inline" onsubmit="return confirm('¿Eliminar cita?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo (int)$appointment['id']; ?>">
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
