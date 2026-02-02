<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error del servidor</title>
</head>
<body>
<h2>Ocurrió un error</h2>
<p><?php echo htmlspecialchars($errorMessage ?? 'Error inesperado', ENT_QUOTES, 'UTF-8'); ?></p>
</body>
</html>
