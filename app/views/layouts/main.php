<?php
$app = require __DIR__ . '/../../../config/app.php';
$baseUrl = rtrim($app['base_url'], '/') . '/';
$title = $title ?? $app['name'];
$subtitle = $subtitle ?? $title;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php $title = $title ?? $app['name']; include __DIR__ . '/../../../partials/title-meta.php'; ?>
    <base href="<?php echo htmlspecialchars($baseUrl, ENT_QUOTES, 'UTF-8'); ?>">
    <?php include __DIR__ . '/../../../partials/head-css.php'; ?>
</head>
<body>
<div class="wrapper">
    <?php include __DIR__ . '/../../../partials/sidenav.php'; ?>
    <?php include __DIR__ . '/../../../partials/topbar.php'; ?>
    <div class="page-content">
        <div class="page-container">
            <?php include __DIR__ . '/../../../partials/page-title.php'; ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php include $viewPath; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include __DIR__ . '/../../../partials/footer.php'; ?>
    </div>
</div>
<?php include __DIR__ . '/../../../partials/footer-scripts.php'; ?>
</body>
</html>
