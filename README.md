# Centro Kinésico (PHP MVC + MySQL)

Sistema web para gestión de un centro kinésico en Chile. Incluye portal de agendamiento, control de citas, ficha clínica, usuarios/roles, reportes y auditoría.

## Requisitos
- PHP 8+
- MySQL 8+
- Apache/Nginx apuntando a `/public`

## Instalación
1. Clona el repositorio.
2. Crea la base de datos e importa `database/schema.sql`.
3. Configura credenciales en `config/db.php` y `config/app.php`.
4. Ejecuta migraciones:

```bash
php public/migrate.php
```

5. Carga datos iniciales:

```bash
mysql -u root -p kinecico < database/seed.sql
```

## Credenciales iniciales
- **Usuario:** admin@local
- **Contraseña:** Admin123!

> Al iniciar sesión se solicitará cambio de contraseña.

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
  /migrations
  schema.sql
```

## Módulos principales
- Auth + cambio de contraseña.
- Usuarios, roles y permisos (RBAC básico).
- Pacientes y ficha clínica (evaluación + evoluciones + adjuntos).
- Profesionales, box y servicios.
- Agenda con control de choques y estados.
- Portal público de agendamiento.
- Reportes básicos y auditoría.

## Migraciones
Los scripts de migración viven en `/database/migrations` y se registran en `schema_migrations`. El runner `public/migrate.php` aplica automáticamente las migraciones pendientes.
