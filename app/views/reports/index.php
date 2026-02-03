<div class="row g-3">
    <?php foreach ($reports as $report): ?>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo e($report['title']); ?></h5>
                    <p class="text-muted flex-grow-1"><?php echo e($report['description']); ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted"><?php echo e($report['updated']); ?></small>
                        <button class="btn btn-outline-primary btn-sm">Ver reporte</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
