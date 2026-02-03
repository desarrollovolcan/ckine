<div class="card">
    <div class="card-body">
        <h4 class="card-title"><?php echo e($patient['first_name'] . ' ' . $patient['last_name']); ?></h4>
        <p class="text-muted mb-1">RUT: <?php echo e($patient['rut']); ?></p>
        <p class="text-muted mb-1">Teléfono: <?php echo e($patient['phone']); ?></p>
        <p class="text-muted mb-3">Email: <?php echo e($patient['email']); ?></p>
        <a href="/fichas/ver?id=<?php echo (int)$patient['id']; ?>" class="btn btn-outline-primary">Ver ficha clínica</a>
    </div>
</div>
