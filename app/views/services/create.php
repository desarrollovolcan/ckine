<?php use App\Core\CSRF; ?>
<h4 class="mb-3">Nuevo servicio</h4>
<form method="post" action="/services">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
    <?php include __DIR__ . '/form.php'; ?>
    <button class="btn btn-primary" type="submit">Guardar</button>
    <a class="btn btn-light" href="/services">Cancelar</a>
</form>
