<?php use App\Core\CSRF; ?>
<h4 class="mb-3">Editar paciente</h4>
<form method="post" action="<?php echo $baseUrl; ?>patients/<?php echo $patient['id']; ?>/update">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
    <?php include __DIR__ . '/form.php'; ?>
    <button class="btn btn-primary" type="submit">Actualizar</button>
    <a class="btn btn-light" href="<?php echo $baseUrl; ?>patients">Cancelar</a>
</form>
