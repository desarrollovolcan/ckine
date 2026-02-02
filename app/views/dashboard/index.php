<h4 class="mb-3">Bienvenido</h4>
<p>Hola <?php echo htmlspecialchars($user['name'] ?? 'Usuario', ENT_QUOTES, 'UTF-8'); ?>, usa el menú lateral para navegar los módulos.</p>
<div class="alert alert-info">
    <strong>Tip:</strong> Puedes acceder al portal de pacientes en <code>/portal</code> si está habilitado.
</div>
