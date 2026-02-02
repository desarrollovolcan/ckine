<?php use App\Core\CSRF; ?>
<h4 class="mb-3">Nuevo box</h4>
<form method="post" action="<?php echo $baseUrl; ?>boxes">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
    <?php include __DIR__ . '/form.php'; ?>
    <button class="btn btn-primary" type="submit">Guardar</button>
    <a class="btn btn-light" href="<?php echo $baseUrl; ?>boxes">Cancelar</a>
</form>
