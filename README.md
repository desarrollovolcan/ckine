# Sistema Centro Kinésico (PHP MVC)

## Requisitos
- PHP 8+
- MySQL 8+
- Apache/Nginx apuntando a `/public`

## Configuración de base de datos
Variables de entorno disponibles:
- `DB_HOST` (default: 127.0.0.1)
- `DB_PORT` (default: 3306)
- `DB_NAME` (default: ckine)
- `DB_USER` (default: root)
- `DB_PASS` (default: vacío)

Opcional:
- `APP_BASE_URL` (default: `/`)
- `APP_TIMEZONE` (default: `America/Santiago`)
- `PUBLIC_PORTAL_ENABLED` (default: true)

## Ejecutar migraciones
1. Crear la base de datos manualmente (si no existe).
2. Ejecutar el runner de migraciones:

```bash
php public/migrate.php
```

El esquema completo se encuentra en `/database/schema.sql`.

## Estructura MVC
```
/public
  index.php
  migrate.php
/app
  /controllers
  /models
  /views
  /core
  /middlewares
/config
/database
/storage
```

## Credenciales iniciales
- Usuario: `admin@local`
- Contraseña: `Admin123!`

Al primer login se solicita cambio de contraseña.

## Módulos disponibles
- Autenticación
- Usuarios / Roles / Permisos
- Pacientes
- Profesionales
- Box
- Servicios
- Agenda / Citas
- Portal público de agendamiento (`/portal`)
- Ficha clínica
- Reportes
- Auditoría
