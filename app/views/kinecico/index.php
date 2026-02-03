<div class="row g-3">
    <?php foreach ($stats as $stat): ?>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1"><?php echo e($stat['label']); ?></p>
                            <h3 class="mb-0"><?php echo e($stat['value']); ?></h3>
                            <small class="text-muted"><?php echo e($stat['trend']); ?></small>
                        </div>
                        <span class="avatar-sm rounded-circle bg-<?php echo e($stat['tone']); ?>-subtle text-<?php echo e($stat['tone']); ?> d-flex align-items-center justify-content-center">
                            <i data-lucide="<?php echo e($stat['icon']); ?>"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row g-3 mt-1">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0">Agenda de hoy</h4>
                    <small class="text-muted">Control de sesiones y box asignado.</small>
                </div>
                <a href="index.php?route=calendar" class="btn btn-outline-primary btn-sm">Ver calendario</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th>Paciente</th>
                                <th>Profesional</th>
                                <th>Servicio</th>
                                <th>Box</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($todaySessions)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No hay sesiones agendadas para hoy.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($todaySessions as $session): ?>
                                    <tr>
                                        <td class="fw-semibold"><?php echo e($session['time']); ?></td>
                                        <td><?php echo e($session['patient']); ?></td>
                                        <td><?php echo e($session['therapist']); ?></td>
                                        <td class="text-muted"><?php echo e($session['service']); ?></td>
                                        <td><?php echo e($session['room']); ?></td>
                                        <td>
                                            <?php
                                            $badgeMap = [
                                                'confirmada' => 'success',
                                                'pendiente' => 'warning',
                                                'evaluación' => 'info',
                                                'cancelada' => 'danger',
                                            ];
                                            $badgeTone = $badgeMap[$session['status']] ?? 'secondary';
                                            ?>
                                            <span class="badge bg-<?php echo e($badgeTone); ?>-subtle text-<?php echo e($badgeTone); ?>">
                                                <?php echo e(ucfirst($session['status'])); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0">Pacientes recientes</h4>
                    <small class="text-muted">Seguimiento de planes activos.</small>
                </div>
                <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#kinecicoPacienteModal">Nuevo paciente</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Plan</th>
                                <th>Sesiones</th>
                                <th>Riesgo</th>
                                <th>Contacto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($patients)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No hay pacientes registrados.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($patients as $patient): ?>
                                    <?php
                                    $fullName = trim(($patient['first_name'] ?? '') . ' ' . ($patient['last_name'] ?? ''));
                                    $plan = $patient['plan'] ?: 'Sin plan registrado';
                                    $sessions = $patient['total_sessions'] ? $patient['total_sessions'] . ' sesiones' : 'Sin sesiones';
                                    $statusMap = [
                                        'confirmada' => ['label' => 'Controlada', 'tone' => 'success'],
                                        'pendiente' => ['label' => 'Pendiente', 'tone' => 'warning'],
                                        'cancelada' => ['label' => 'Cancelada', 'tone' => 'danger'],
                                    ];
                                    $statusInfo = $statusMap[$patient['last_status'] ?? ''] ?? ['label' => 'Sin agenda', 'tone' => 'secondary'];
                                    ?>
                                    <tr>
                                        <td class="fw-semibold"><?php echo e($fullName ?: 'Sin nombre'); ?></td>
                                        <td><?php echo e($plan); ?></td>
                                        <td><?php echo e($sessions); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo e($statusInfo['tone']); ?>-subtle text-<?php echo e($statusInfo['tone']); ?>">
                                                <?php echo e($statusInfo['label']); ?>
                                            </span>
                                        </td>
                                        <td class="text-muted"><?php echo e($patient['phone'] ?? ''); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title mb-0">Planes terapéuticos en seguimiento</h4>
                <small class="text-muted">Control de avances y próximas acciones.</small>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <?php if (empty($treatmentPlans)): ?>
                        <div class="col-12">
                            <div class="text-center text-muted py-4 border rounded">No hay planes terapéuticos registrados.</div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($treatmentPlans as $plan): ?>
                            <div class="col-lg-4">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="mb-1"><?php echo e($plan['plan'] ?: 'Plan terapéutico'); ?></h6>
                                    <p class="text-muted mb-2">Paciente: <?php echo e(trim($plan['first_name'] . ' ' . $plan['last_name'])); ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Registrado <?php echo e(date('d/m/Y', strtotime($plan['created_at']))); ?></small>
                                        <span class="badge bg-primary-subtle text-primary">En seguimiento</span>
                                    </div>
                                    <p class="mt-2 mb-0 text-muted">Objetivos: <?php echo e($plan['objectives'] ?: 'Sin objetivos'); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Registrar sesión</h4>
                <small class="text-muted">Agregar sesión a la agenda de hoy.</small>
            </div>
            <div class="card-body">
                <form method="post" action="index.php?route=kinecico/store-session" class="row g-3">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <div class="col-12">
                        <label class="form-label">Paciente</label>
                        <select class="form-select" name="patient_id" required>
                            <option value="">Selecciona paciente</option>
                            <?php foreach ($patientsList as $patient): ?>
                                <option value="<?php echo e($patient['id']); ?>">
                                    <?php echo e(trim($patient['first_name'] . ' ' . $patient['last_name'])); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Profesional</label>
                        <select class="form-select" name="professional_id" required>
                            <option value="">Selecciona profesional</option>
                            <?php foreach ($professionalsList as $professional): ?>
                                <option value="<?php echo e($professional['id']); ?>">
                                    <?php echo e(trim($professional['first_name'] . ' ' . $professional['last_name'])); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Fecha</label>
                        <input type="date" class="form-control" name="date" value="<?php echo e($todayDate); ?>" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Hora</label>
                        <input type="time" class="form-control" name="time" value="09:00" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Box</label>
                        <select class="form-select" name="box_id" required>
                            <option value="">Selecciona box</option>
                            <?php foreach ($boxesList as $box): ?>
                                <option value="<?php echo e($box['id']); ?>"><?php echo e($box['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Estado</label>
                        <select class="form-select" name="status">
                            <option value="pendiente">Pendiente</option>
                            <option value="confirmada">Confirmada</option>
                            <option value="evaluación">Evaluación</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Servicio</label>
                        <select class="form-select" name="service_id" required>
                            <option value="">Selecciona servicio</option>
                            <?php foreach ($servicesList as $service): ?>
                                <option value="<?php echo e($service['id']); ?>">
                                    <?php echo e($service['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notas clínicas</label>
                        <textarea class="form-control" rows="2" name="notes" placeholder="Ej: dolor de rodilla, foco en fortalecimiento."></textarea>
                    </div>
                    <div class="col-12 d-grid">
                        <button class="btn btn-primary" type="submit">Guardar sesión</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title mb-0">Resumen de pagos</h4>
                <small class="text-muted">Estado de cobros recientes.</small>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <?php if (empty($payments)): ?>
                        <div class="list-group-item px-0 text-muted text-center">No hay pagos recientes.</div>
                    <?php else: ?>
                        <?php foreach ($payments as $payment): ?>
                            <?php $paymentTone = ($payment['status'] ?? '') === 'pagado' ? 'success' : 'warning'; ?>
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-1"><?php echo e(trim(($payment['first_name'] ?? '') . ' ' . ($payment['last_name'] ?? '')) ?: 'Sin paciente'); ?></h6>
                                        <p class="mb-0 text-muted"><?php echo e($payment['service_name'] ?? 'Servicio no especificado'); ?></p>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-1 fw-semibold"><?php echo e(format_currency((float)$payment['amount'])); ?></p>
                                        <span class="badge bg-<?php echo e($paymentTone); ?>-subtle text-<?php echo e($paymentTone); ?>">
                                            <?php echo e(ucfirst($payment['status'] ?? 'pendiente')); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <form method="post" action="index.php?route=kinecico/store-payment" class="mt-3">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <div class="row g-2">
                        <div class="col-12">
                            <label class="form-label">Paciente</label>
                            <select class="form-select" name="payment_patient">
                                <option value="">Selecciona paciente</option>
                                <?php foreach ($patientsList as $patient): ?>
                                    <option value="<?php echo e($patient['id']); ?>">
                                        <?php echo e(trim($patient['first_name'] . ' ' . $patient['last_name'])); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Servicio</label>
                            <select class="form-select" name="service_id">
                                <option value="">Selecciona servicio</option>
                                <?php foreach ($servicesList as $service): ?>
                                    <option value="<?php echo e($service['id']); ?>">
                                        <?php echo e($service['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Monto</label>
                            <input type="text" class="form-control" name="amount" placeholder="$60.000">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Método</label>
                            <select class="form-select" name="method">
                                <option>Transferencia</option>
                                <option>Tarjeta</option>
                                <option>Efectivo</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="payment_status">
                                <option value="pagado">Pagado</option>
                                <option value="pendiente">Pendiente</option>
                            </select>
                        </div>
                        <div class="col-12 d-grid">
                            <button class="btn btn-outline-primary" type="submit">Registrar pago</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title mb-0">Equipo clínico</h4>
                <small class="text-muted">Turnos del día.</small>
            </div>
            <div class="card-body">
                <?php if (empty($staff)): ?>
                    <p class="text-muted mb-3">No hay profesionales registrados.</p>
                <?php else: ?>
                    <?php foreach ($staff as $member): ?>
                        <?php
                        $memberName = trim($member['first_name'] . ' ' . $member['last_name']);
                        $shift = ($member['start_time'] && $member['end_time'])
                            ? $member['start_time'] . ' - ' . $member['end_time']
                            : 'Sin turno';
                        ?>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-1"><?php echo e($memberName); ?></h6>
                                <p class="mb-0 text-muted"><?php echo e($member['specialty'] ?: 'Profesional'); ?></p>
                            </div>
                            <span class="badge bg-light text-dark border"><?php echo e($shift); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <form method="post" action="index.php?route=kinecico/store-plan" class="mt-3">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <div class="row g-2">
                        <div class="col-12">
                            <label class="form-label">Paciente</label>
                            <select class="form-select" name="patient_id" required>
                                <option value="">Selecciona paciente</option>
                                <?php foreach ($patientsList as $patient): ?>
                                    <option value="<?php echo e($patient['id']); ?>">
                                        <?php echo e(trim($patient['first_name'] . ' ' . $patient['last_name'])); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Motivo</label>
                            <textarea class="form-control" rows="2" name="reason" placeholder="Ej: dolor lumbar crónico."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Diagnóstico</label>
                            <input type="text" class="form-control" name="diagnosis" placeholder="Ej: lumbalgia mecánica.">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Objetivos</label>
                            <input type="text" class="form-control" name="objectives" placeholder="Ej: mejorar movilidad y fortalecer core.">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Plan terapéutico</label>
                            <textarea class="form-control" rows="3" name="plan" required></textarea>
                        </div>
                        <div class="col-12 d-grid">
                            <button class="btn btn-soft-primary" type="submit">Actualizar plan terapéutico</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="kinecicoPacienteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar nuevo paciente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="index.php?route=kinecico/store-patient">
                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" class="form-control" name="name" value="">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">RUT</label>
                            <input type="text" class="form-control" name="rut" value="">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="phone" value="">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Motivo de consulta</label>
                            <textarea class="form-control" rows="3" name="reason"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar paciente</button>
                </div>
            </form>
        </div>
    </div>
</div>
