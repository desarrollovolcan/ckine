<?php include __DIR__ . '/../../../partials/html.php'; ?>

<head>
    <?php $title = $title ?? 'Ingreso'; include __DIR__ . '/../../../partials/title-meta.php'; ?>
    <?php include __DIR__ . '/../../../partials/head-css.php'; ?>
</head>

<body class="bg-body-secondary">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-xl-5 col-lg-6">
                <?php
                $flashMessages = consume_flash();
                $flashClassMap = [
                    'success' => 'success',
                    'error' => 'danger',
                    'warning' => 'warning',
                    'info' => 'info',
                ];
                ?>
                <?php foreach ($flashMessages as $type => $messages): ?>
                    <?php $alertClass = $flashClassMap[$type] ?? 'info'; ?>
                    <?php foreach ((array)$messages as $message): ?>
                        <div class="alert alert-<?php echo e($alertClass); ?> alert-dismissible fade show mt-4" role="alert">
                            <?php echo e($message); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>

                <?php
                $viewPath = __DIR__ . '/../' . $view . '.php';
                if (file_exists($viewPath)) {
                    include $viewPath;
                } else {
                    echo '<div class="alert alert-danger">Vista no encontrada.</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../../../partials/footer-scripts.php'; ?>
</body>

</html>
