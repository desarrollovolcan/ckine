<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Paciente</h5>
                <p class="text-muted mb-1">ID</p>
                <h6><?php echo e($patient['id'] ?? 'No disponible'); ?></h6>
                <p class="text-muted mb-1 mt-3">Nombre</p>
                <h6><?php echo e($patient['name'] ?? ''); ?></h6>
                <p class="text-muted mb-1 mt-3">Diagnóstico</p>
                <h6><?php echo e($patient['notes'] ?? 'Sin diagnóstico registrado'); ?></h6>
                <div class="mt-3">
                    <span class="badge bg-info"><?php echo e($patient['status'] ?? ''); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Notas clínicas</h4>
                <a href="index.php?route=clinical/note&patient_id=<?php echo e($patient['id']); ?>" class="btn btn-primary">Nueva nota</a>
            </div>
            <div class="card-body">
                <?php if (empty($notes)): ?>
                    <div class="text-muted">Sin notas clínicas registradas.</div>
                <?php else: ?>
                    <?php foreach ($notes as $note): ?>
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="fw-semibold"><?php echo e($note['title']); ?></span>
                                <small class="text-muted"><?php echo e(format_date($note['note_date'] ?? null)); ?></small>
                            </div>
                            <p class="mb-0 text-muted"><?php echo e($note['description'] ?? ''); ?></p>
                            <?php if (!empty($note['professional_name'])): ?>
                                <div class="small text-muted mt-2">Profesional: <?php echo e($note['professional_name']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
