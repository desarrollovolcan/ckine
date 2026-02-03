<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo app_path('/reportes'); ?>" class="row g-3">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="col-md-4">
                <label class="form-label">Tipo de reporte</label>
                <select class="form-select" name="type">
                    <option value="agenda">Agenda diaria/semanal</option>
                    <option value="no_show" <?php echo ($report['type'] ?? '') === 'no_show' ? 'selected' : ''; ?>>No-show</option>
                    <option value="ocupacion" <?php echo ($report['type'] ?? '') === 'ocupacion' ? 'selected' : ''; ?>>Ocupación de box</option>
                    <option value="nuevos" <?php echo ($report['type'] ?? '') === 'nuevos' ? 'selected' : ''; ?>>Pacientes nuevos</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Desde</label>
                <input type="date" class="form-control" name="start_date" value="<?php echo e($report['start'] ?? date('Y-m-d')); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Hasta</label>
                <input type="date" class="form-control" name="end_date" value="<?php echo e($report['end'] ?? date('Y-m-d')); ?>">
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Generar</button>
            </div>
        </form>

        <?php if (!empty($report)): ?>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <?php if ($report['type'] === 'agenda'): ?>
                                <th>Fecha</th>
                                <th>Paciente</th>
                                <th>Profesional</th>
                                <th>Box</th>
                                <th>Estado</th>
                            <?php elseif ($report['type'] === 'no_show'): ?>
                                <th>Fecha</th>
                                <th>Total</th>
                            <?php elseif ($report['type'] === 'ocupacion'): ?>
                                <th>Box</th>
                                <th>Total</th>
                            <?php else: ?>
                                <th>Fecha</th>
                                <th>Total</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($report['data'] as $row): ?>
                            <tr>
                                <?php if ($report['type'] === 'agenda'): ?>
                                    <td><?php echo e(date('d/m/Y H:i', strtotime($row['start_at']))); ?></td>
                                    <td><?php echo e($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                    <td><?php echo e($row['prof_name'] . ' ' . $row['prof_last']); ?></td>
                                    <td><?php echo e($row['box_name']); ?></td>
                                    <td><?php echo e($row['status']); ?></td>
                                <?php elseif ($report['type'] === 'no_show'): ?>
                                    <td><?php echo e($row['fecha']); ?></td>
                                    <td><?php echo (int)$row['total']; ?></td>
                                <?php elseif ($report['type'] === 'ocupacion'): ?>
                                    <td><?php echo e($row['name']); ?></td>
                                    <td><?php echo (int)$row['total']; ?></td>
                                <?php else: ?>
                                    <td><?php echo e($row['fecha']); ?></td>
                                    <td><?php echo (int)$row['total']; ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
