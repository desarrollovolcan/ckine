<div class="row g-3">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Calendario semanal</h4>
                <a href="index.php?route=appointments/create" class="btn btn-primary">Nueva cita</a>
            </div>
            <div class="card-body">
                <?php if (empty($calendarDays)): ?>
                    <div class="alert alert-info mb-0">No hay citas programadas para esta semana.</div>
                <?php else: ?>
                    <div class="mt-3">
                        <?php foreach ($calendarDays as $day): ?>
                            <?php $count = count($day['appointments']); ?>
                            <div class="d-flex align-items-center justify-content-between border rounded p-3 mb-2">
                                <div>
                                    <div class="fw-semibold"><?php echo e(format_date($day['date'])); ?></div>
                                    <small class="text-muted">
                                        <?php if ($count > 0): ?>
                                            <?php
                                            $first = $day['appointments'][0]['appointment_time'] ?? '';
                                            $last = $day['appointments'][$count - 1]['appointment_time'] ?? '';
                                            ?>
                                            <?php echo e($first); ?> - <?php echo e($last); ?>
                                        <?php else: ?>
                                            Sin horarios
                                        <?php endif; ?>
                                    </small>
                                </div>
                                <span class="badge <?php echo $count > 0 ? 'bg-success' : 'bg-light text-dark'; ?>">
                                    <?php echo e($count); ?> cita<?php echo $count === 1 ? '' : 's'; ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Resumen del día</h4>
            </div>
            <div class="card-body">
                <p class="text-muted">Citas programadas para hoy.</p>
                <?php if (empty($todayAppointments)): ?>
                    <p class="text-muted mb-0">No hay citas para hoy.</p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($todayAppointments as $appointment): ?>
                            <li class="list-group-item">
                                <?php echo e($appointment['appointment_time'] ?? ''); ?>
                                - <?php echo e($appointment['patient_name'] ?? ''); ?>
                                (<?php echo e($appointment['box_name'] ?? 'Sin box'); ?>)
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
