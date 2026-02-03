INSERT INTO roles (name, description, created_at, updated_at) VALUES
('Admin', 'Administrador del sistema', NOW(), NOW()),
('Recepción', 'Equipo de recepción', NOW(), NOW()),
('Kinesiólogo', 'Profesionales clínicos', NOW(), NOW());

INSERT INTO permissions (`key`, label) VALUES
('dashboard', 'Dashboard'),
('usuarios', 'Gestión usuarios'),
('roles', 'Gestión roles'),
('pacientes', 'Gestión pacientes'),
('profesionales', 'Gestión profesionales'),
('box', 'Gestión box'),
('servicios', 'Gestión servicios'),
('agenda', 'Gestión agenda'),
('fichas', 'Fichas clínicas'),
('reportes', 'Reportes'),
('auditoria', 'Auditoría');

INSERT INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM roles r
CROSS JOIN permissions p
WHERE r.name = 'Admin';

INSERT INTO users (name, email, password_hash, role_id, must_change_password, created_at, updated_at)
SELECT 'Administrador', 'admin@local', '$2y$12$o9WMh3cnJ91EqgFgtDYVmORJ/be5yKq6sU1ShqjJwO5zDRs58t23.', r.id, 1, NOW(), NOW()
FROM roles r WHERE r.name = 'Admin';

INSERT INTO portal_settings (is_enabled, created_at, updated_at) VALUES (1, NOW(), NOW());
