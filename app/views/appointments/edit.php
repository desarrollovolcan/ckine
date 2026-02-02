<?php use App\Core\CSRF; ?>
<h4 class="mb-3">Editar cita</h4>
<form method="post" action="/appointments/<?php echo $appointment['id']; ?>/update">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
    <?php include __DIR__ . '/form.php'; ?>
    <button class="btn btn-primary" type="submit">Actualizar</button>
    <a class="btn btn-light" href="/appointments">Cancelar</a>
</form>
