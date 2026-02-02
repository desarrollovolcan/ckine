<?php use App\Core\CSRF; ?>
<h4 class="mb-3">Editar box</h4>
<form method="post" action="/boxes/<?php echo $box['id']; ?>/update">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
    <?php include __DIR__ . '/form.php'; ?>
    <button class="btn btn-primary" type="submit">Actualizar</button>
    <a class="btn btn-light" href="/boxes">Cancelar</a>
</form>
