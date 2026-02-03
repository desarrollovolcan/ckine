<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Paciente</h5>
                <p class="text-muted mb-1">ID</p>
                <h6><?php echo e($patientId ?: 'No disponible'); ?></h6>
                <p class="text-muted mb-1 mt-3">Nombre</p>
                <h6><?php echo e($patient['name'] ?? 'Sin nombre'); ?></h6>
                <p class="text-muted mb-1 mt-3">RUT</p>
                <h6><?php echo e($patient['rut'] ?? 'No informado'); ?></h6>
                <div class="mt-3">
                    <span class="badge bg-info"><?php echo e($patient['status'] ?? 'Sin estado'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Notas clínicas</h4>
                <a href="index.php?route=clinical/note&patient_id=<?php echo e($patientId); ?>" class="btn btn-primary">Nueva nota</a>
            </div>
            <div class="card-body">
                <?php if (!empty($notes)): ?>
                    <?php foreach ($notes as $note): ?>
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="fw-semibold"><?php echo e($note['session_label'] ?: 'Sesión'); ?></span>
                                <small class="text-muted"><?php echo e(format_date($note['note_date'])); ?></small>
                            </div>
                            <?php if (!empty($note['professional_name'])): ?>
                                <small class="text-muted d-block mb-2"><?php echo e($note['professional_name']); ?></small>
                            <?php endif; ?>
                            <p class="mb-0 text-muted"><?php echo e($note['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-muted text-center py-4">Aún no hay notas clínicas registradas.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
