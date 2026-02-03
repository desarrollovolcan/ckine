<div class="row g-3">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo e($patient['first_name'] . ' ' . $patient['last_name']); ?></h4>
                <p class="text-muted mb-1">RUT: <?php echo e($patient['rut']); ?></p>
                <p class="text-muted mb-1">Teléfono: <?php echo e($patient['phone']); ?></p>
                <p class="text-muted">Email: <?php echo e($patient['email']); ?></p>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Adjuntos</h6>
            </div>
            <div class="card-body">
                <?php if (empty($attachments)): ?>
                    <p class="text-muted">Sin adjuntos.</p>
                <?php else: ?>
                    <ul class="list-group">
                        <?php foreach ($attachments as $attachment): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo e($attachment['file_name']); ?>
                                <a href="/<?php echo e($attachment['file_path']); ?>" target="_blank" class="btn btn-sm btn-outline-secondary">Ver</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <form method="post" action="/fichas/adjunto" enctype="multipart/form-data" class="mt-3">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="patient_id" value="<?php echo (int)$patient['id']; ?>">
                    <div class="mb-2">
                        <input type="file" class="form-control" name="attachment" required>
                    </div>
                    <button class="btn btn-outline-primary btn-sm" type="submit">Subir adjunto</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Evaluación inicial</h5>
            </div>
            <div class="card-body">
                <?php if ($evaluation): ?>
                    <p class="mb-1"><strong>Motivo:</strong> <?php echo e($evaluation['reason']); ?></p>
                    <p class="mb-1"><strong>Antecedentes:</strong> <?php echo e($evaluation['history']); ?></p>
                    <p class="mb-1"><strong>Diagnóstico:</strong> <?php echo e($evaluation['diagnosis']); ?></p>
                    <p class="mb-1"><strong>Objetivos:</strong> <?php echo e($evaluation['objectives']); ?></p>
                    <p class="mb-0"><strong>Plan:</strong> <?php echo e($evaluation['plan']); ?></p>
                <?php else: ?>
                    <p class="text-muted">No hay evaluación registrada.</p>
                <?php endif; ?>
                <hr>
                <form method="post" action="/fichas/evaluacion">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="patient_id" value="<?php echo (int)$patient['id']; ?>">
                    <div class="row g-2">
                        <div class="col-12">
                            <label class="form-label">Motivo consulta</label>
                            <textarea class="form-control" name="reason" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Antecedentes</label>
                            <textarea class="form-control" name="history" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Diagnóstico funcional</label>
                            <textarea class="form-control" name="diagnosis" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Objetivos</label>
                            <textarea class="form-control" name="objectives" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Plan de tratamiento</label>
                            <textarea class="form-control" name="plan" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Guardar evaluación</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Evoluciones</h5>
            </div>
            <div class="card-body">
                <?php if (empty($evolutions)): ?>
                    <p class="text-muted">Sin evoluciones registradas.</p>
                <?php else: ?>
                    <?php foreach ($evolutions as $evolution): ?>
                        <div class="border rounded p-3 mb-2">
                            <p class="mb-1"><strong>Fecha:</strong> <?php echo e(date('d/m/Y H:i', strtotime($evolution['created_at']))); ?></p>
                            <p class="mb-1"><strong>Notas:</strong> <?php echo e($evolution['notes']); ?></p>
                            <p class="mb-1"><strong>Procedimientos:</strong> <?php echo e($evolution['procedures']); ?></p>
                            <p class="mb-0"><strong>Ejercicios:</strong> <?php echo e($evolution['exercises']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <hr>
                <form method="post" action="/fichas/evolucion">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="patient_id" value="<?php echo (int)$patient['id']; ?>">
                    <div class="row g-2">
                        <div class="col-12">
                            <label class="form-label">Notas</label>
                            <textarea class="form-control" name="notes" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Procedimientos</label>
                            <textarea class="form-control" name="procedures" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Ejercicios indicados</label>
                            <textarea class="form-control" name="exercises" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Agregar evolución</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
