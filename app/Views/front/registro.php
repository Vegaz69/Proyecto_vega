<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registro de Usuario</title>
</head>
<body>
    <h1>Registro de Usuario</h1>
    <form action="<?= base_url('usuarios/guardar'); ?>" method="post">
        <input type="text" name="nombre" placeholder="Nombre completo" required>
        <input type="text" name="dni" placeholder="DNI" required>
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>