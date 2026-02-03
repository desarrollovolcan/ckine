SET @company_id = (SELECT id FROM companies WHERE name = 'GoCreative' LIMIT 1);

INSERT INTO clients (company_id, name, rut, email, billing_email, phone, address, giro, commune, contact, portal_token, portal_password, notes, status, created_at, updated_at)
SELECT @company_id, 'Clínica Vitalis', '76.123.456-7', 'contacto@vitalis.cl', 'cobranza@vitalis.cl', '+56 2 2345 6789',
       'Av. Salud 1234', 'Servicios de salud', 'Providencia', 'Marcela Soto', 'cli_vitalis_2025', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga',
       'Cliente corporativo de salud', 'activo', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM clients WHERE company_id = @company_id AND email = 'contacto@vitalis.cl'
);

INSERT INTO clients (company_id, name, rut, email, billing_email, phone, address, giro, commune, contact, portal_token, portal_password, notes, status, created_at, updated_at)
SELECT @company_id, 'KineFlow SpA', '77.234.567-8', 'hola@kineflow.cl', 'pagos@kineflow.cl', '+56 2 2987 6543',
       'Los Leones 2200', 'Rehabilitación', 'Las Condes', 'Jorge Díaz', 'cli_kineflow_2025', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga',
       'Cliente con foco en empresas', 'activo', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM clients WHERE company_id = @company_id AND email = 'hola@kineflow.cl'
);

INSERT INTO clients (company_id, name, rut, email, billing_email, phone, address, giro, commune, contact, portal_token, portal_password, notes, status, created_at, updated_at)
SELECT @company_id, 'Centro Movimiento', '78.345.678-9', 'contacto@movimiento.cl', 'facturacion@movimiento.cl', '+56 2 2654 1122',
       'Calle Deportes 451', 'Kinesiología', 'Ñuñoa', 'Carla Rojas', 'cli_movimiento_2025', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga',
       'Centro aliado para derivaciones', 'activo', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM clients WHERE company_id = @company_id AND email = 'contacto@movimiento.cl'
);

INSERT INTO clients (company_id, name, rut, email, billing_email, phone, address, giro, commune, contact, portal_token, portal_password, notes, status, created_at, updated_at)
SELECT @company_id, 'Energía Plus', '79.456.789-0', 'clientes@energiaplus.cl', 'pagos@energiaplus.cl', '+56 2 2788 9900',
       'Av. Vitacura 5600', 'Bienestar corporativo', 'Vitacura', 'Ignacio Fuentes', 'cli_energiaplus_2025', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga',
       'Programa de bienestar interno', 'activo', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM clients WHERE company_id = @company_id AND email = 'clientes@energiaplus.cl'
);

INSERT INTO clients (company_id, name, rut, email, billing_email, phone, address, giro, commune, contact, portal_token, portal_password, notes, status, created_at, updated_at)
SELECT @company_id, 'Rehab360', '80.567.890-1', 'info@rehab360.cl', 'cobranza@rehab360.cl', '+56 2 2233 4455',
       'Av. Independencia 1010', 'Rehabilitación deportiva', 'Independencia', 'Pilar Mena', 'cli_rehab360_2025', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga',
       'Convenio con gimnasios', 'activo', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM clients WHERE company_id = @company_id AND email = 'info@rehab360.cl'
);

INSERT INTO clients (company_id, name, rut, email, billing_email, phone, address, giro, commune, contact, portal_token, portal_password, notes, status, created_at, updated_at)
SELECT @company_id, 'Salud Contigo', '81.678.901-2', 'contacto@saludcontigo.cl', 'facturas@saludcontigo.cl', '+56 2 2777 6677',
       'Matucana 350', 'Atención primaria', 'Santiago', 'Fernanda Silva', 'cli_saludcontigo_2025', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga',
       'Derivaciones de atención primaria', 'activo', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM clients WHERE company_id = @company_id AND email = 'contacto@saludcontigo.cl'
);

INSERT INTO professionals (company_id, name, rut, license_number, specialty, email, phone, status, modality, box, schedule, notes, created_at, updated_at)
SELECT @company_id, 'Camila Torres', '14.567.890-1', 'KIN-1034', 'Kinesiología deportiva', 'camila.torres@clinicacreative.cl',
       '+56 9 5555 1001', 'Activo', 'Presencial', 'Box 1', 'Lun-Vie 08:00-16:00', 'Especialista en rehabilitación deportiva', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM professionals WHERE company_id = @company_id AND email = 'camila.torres@clinicacreative.cl'
);

INSERT INTO professionals (company_id, name, rut, license_number, specialty, email, phone, status, modality, box, schedule, notes, created_at, updated_at)
SELECT @company_id, 'Diego Marín', '16.234.567-8', 'KIN-1140', 'Rehabilitación traumatológica', 'diego.marin@clinicacreative.cl',
       '+56 9 5555 1002', 'Activo', 'Presencial', 'Box 2', 'Lun-Vie 09:00-17:30', 'Enfoque en lesiones de rodilla', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM professionals WHERE company_id = @company_id AND email = 'diego.marin@clinicacreative.cl'
);

INSERT INTO professionals (company_id, name, rut, license_number, specialty, email, phone, status, modality, box, schedule, notes, created_at, updated_at)
SELECT @company_id, 'Valentina Rivas', '17.890.123-4', 'KIN-1208', 'Kinesiología respiratoria', 'valentina.rivas@clinicacreative.cl',
       '+56 9 5555 1003', 'Activo', 'Mixta', 'Box 3', 'Lun-Jue 10:00-18:00', 'Atención domiciliaria disponible', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM professionals WHERE company_id = @company_id AND email = 'valentina.rivas@clinicacreative.cl'
);

INSERT INTO professionals (company_id, name, rut, license_number, specialty, email, phone, status, modality, box, schedule, notes, created_at, updated_at)
SELECT @company_id, 'Matías Herrera', '18.901.234-5', 'KIN-1312', 'Rehabilitación neurológica', 'matias.herrera@clinicacreative.cl',
       '+56 9 5555 1004', 'Activo', 'Presencial', 'Box 4', 'Mar-Vie 08:30-15:30', 'Experto en terapia funcional', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM professionals WHERE company_id = @company_id AND email = 'matias.herrera@clinicacreative.cl'
);

INSERT INTO professionals (company_id, name, rut, license_number, specialty, email, phone, status, modality, box, schedule, notes, created_at, updated_at)
SELECT @company_id, 'Antonia Vidal', '19.012.345-6', 'KIN-1425', 'Kinesiología geriátrica', 'antonia.vidal@clinicacreative.cl',
       '+56 9 5555 1005', 'Activo', 'Mixta', 'Box 5', 'Lun-Vie 11:00-19:00', 'Planificación de planes integrales', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM professionals WHERE company_id = @company_id AND email = 'antonia.vidal@clinicacreative.cl'
);

INSERT INTO professionals (company_id, name, rut, license_number, specialty, email, phone, status, modality, box, schedule, notes, created_at, updated_at)
SELECT @company_id, 'Ricardo Álvarez', '20.123.456-7', 'KIN-1507', 'Kinesiología laboral', 'ricardo.alvarez@clinicacreative.cl',
       '+56 9 5555 1006', 'Activo', 'Presencial', 'Box 6', 'Lun-Vie 07:30-15:00', 'Programas de reintegro laboral', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM professionals WHERE company_id = @company_id AND email = 'ricardo.alvarez@clinicacreative.cl'
);

INSERT INTO patients (company_id, name, rut, birthdate, email, phone, address, occupation, status, insurance, referring_physician, emergency_contact_name, emergency_contact_phone, reason_for_visit, diagnosis, allergies, notes, portal_password, created_at, updated_at)
SELECT @company_id, 'Sofía Ramírez', '13.456.789-0', '1992-05-18', 'sofia.ramirez@email.cl', '+56 9 6000 1001',
       'Av. Providencia 1345', 'Diseñadora', 'Activo', 'Isapre Colmena', 'Dr. Pablo Soto', 'María Ramírez', '+56 9 7111 2200',
       'Dolor lumbar crónico', 'Lumbalgia mecánica', 'Ninguna', 'Plan de fortalecimiento progresivo',
       '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM patients WHERE company_id = @company_id AND email = 'sofia.ramirez@email.cl'
);

INSERT INTO patients (company_id, name, rut, birthdate, email, phone, address, occupation, status, insurance, referring_physician, emergency_contact_name, emergency_contact_phone, reason_for_visit, diagnosis, allergies, notes, portal_password, created_at, updated_at)
SELECT @company_id, 'Javier López', '15.234.567-1', '1987-11-04', 'javier.lopez@email.cl', '+56 9 6000 1002',
       'Los Dominicos 2211', 'Ingeniero', 'Activo', 'Fonasa', 'Dra. Alejandra Paredes', 'Cristina López', '+56 9 7111 2201',
       'Recuperación post esguince', 'Esguince tobillo grado II', 'Ibuprofeno', 'Sesiones de equilibrio y fuerza',
       '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM patients WHERE company_id = @company_id AND email = 'javier.lopez@email.cl'
);

INSERT INTO patients (company_id, name, rut, birthdate, email, phone, address, occupation, status, insurance, referring_physician, emergency_contact_name, emergency_contact_phone, reason_for_visit, diagnosis, allergies, notes, portal_password, created_at, updated_at)
SELECT @company_id, 'Valeria Pérez', '16.789.012-3', '1995-02-22', 'valeria.perez@email.cl', '+56 9 6000 1003',
       'San Pío X 901', 'Periodista', 'Activo', 'Isapre Banmédica', 'Dr. Tomás Ibarra', 'Nicolás Pérez', '+56 9 7111 2202',
       'Rehabilitación cervical', 'Cervicalgia postural', 'Ninguna', 'Ejercicios de movilidad diaria',
       '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM patients WHERE company_id = @company_id AND email = 'valeria.perez@email.cl'
);

INSERT INTO patients (company_id, name, rut, birthdate, email, phone, address, occupation, status, insurance, referring_physician, emergency_contact_name, emergency_contact_phone, reason_for_visit, diagnosis, allergies, notes, portal_password, created_at, updated_at)
SELECT @company_id, 'Pedro Muñoz', '17.345.678-4', '1979-08-30', 'pedro.munoz@email.cl', '+56 9 6000 1004',
       'Tobalaba 445', 'Contador', 'Activo', 'Fonasa', 'Dra. Elisa Torres', 'Carolina Muñoz', '+56 9 7111 2203',
       'Dolor hombro derecho', 'Tendinopatía supraespinosa', 'Ninguna', 'Plan de movilidad y analgesia',
       '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM patients WHERE company_id = @company_id AND email = 'pedro.munoz@email.cl'
);

INSERT INTO patients (company_id, name, rut, birthdate, email, phone, address, occupation, status, insurance, referring_physician, emergency_contact_name, emergency_contact_phone, reason_for_visit, diagnosis, allergies, notes, portal_password, created_at, updated_at)
SELECT @company_id, 'Camila Salas', '18.901.234-5', '1999-06-15', 'camila.salas@email.cl', '+56 9 6000 1005',
       'Av. Macul 123', 'Estudiante', 'Activo', 'Isapre Cruz Blanca', 'Dr. Felipe Herrera', 'José Salas', '+56 9 7111 2204',
       'Rehabilitación rodilla', 'Condromalacia rotuliana', 'Paracetamol', 'Fortalecimiento cuádriceps',
       '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM patients WHERE company_id = @company_id AND email = 'camila.salas@email.cl'
);

INSERT INTO patients (company_id, name, rut, birthdate, email, phone, address, occupation, status, insurance, referring_physician, emergency_contact_name, emergency_contact_phone, reason_for_visit, diagnosis, allergies, notes, portal_password, created_at, updated_at)
SELECT @company_id, 'Ignacio Reyes', '19.567.890-6', '1983-03-09', 'ignacio.reyes@email.cl', '+56 9 6000 1006',
       'Av. Apoquindo 7733', 'Supervisor', 'Activo', 'Fonasa', 'Dra. Camila Vega', 'Patricia Reyes', '+56 9 7111 2205',
       'Reintegro laboral', 'Lumbociática', 'Ninguna', 'Plan de ergonomía y fortalecimiento',
       '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM patients WHERE company_id = @company_id AND email = 'ignacio.reyes@email.cl'
);

INSERT INTO appointments (company_id, patient_id, professional_id, box_id, appointment_date, appointment_time, status, notes, created_at, updated_at)
SELECT
    @company_id,
    (SELECT id FROM patients WHERE company_id = @company_id AND email = 'sofia.ramirez@email.cl' LIMIT 1),
    (SELECT id FROM professionals WHERE company_id = @company_id AND email = 'camila.torres@clinicacreative.cl' LIMIT 1),
    NULL,
    DATE_ADD(CURDATE(), INTERVAL 1 DAY),
    '09:00:00',
    'Confirmada',
    'Evaluación inicial.',
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM appointments
    WHERE company_id = @company_id
      AND patient_id = (SELECT id FROM patients WHERE company_id = @company_id AND email = 'sofia.ramirez@email.cl' LIMIT 1)
      AND appointment_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY)
      AND appointment_time = '09:00:00'
);

INSERT INTO appointments (company_id, patient_id, professional_id, box_id, appointment_date, appointment_time, status, notes, created_at, updated_at)
SELECT
    @company_id,
    (SELECT id FROM patients WHERE company_id = @company_id AND email = 'javier.lopez@email.cl' LIMIT 1),
    (SELECT id FROM professionals WHERE company_id = @company_id AND email = 'diego.marin@clinicacreative.cl' LIMIT 1),
    NULL,
    DATE_ADD(CURDATE(), INTERVAL 2 DAY),
    '10:30:00',
    'Programada',
    'Control post lesión.',
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM appointments
    WHERE company_id = @company_id
      AND patient_id = (SELECT id FROM patients WHERE company_id = @company_id AND email = 'javier.lopez@email.cl' LIMIT 1)
      AND appointment_date = DATE_ADD(CURDATE(), INTERVAL 2 DAY)
      AND appointment_time = '10:30:00'
);

INSERT INTO appointments (company_id, patient_id, professional_id, box_id, appointment_date, appointment_time, status, notes, created_at, updated_at)
SELECT
    @company_id,
    (SELECT id FROM patients WHERE company_id = @company_id AND email = 'valeria.perez@email.cl' LIMIT 1),
    (SELECT id FROM professionals WHERE company_id = @company_id AND email = 'valentina.rivas@clinicacreative.cl' LIMIT 1),
    NULL,
    DATE_ADD(CURDATE(), INTERVAL 3 DAY),
    '12:00:00',
    'Confirmada',
    'Sesión respiratoria.',
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM appointments
    WHERE company_id = @company_id
      AND patient_id = (SELECT id FROM patients WHERE company_id = @company_id AND email = 'valeria.perez@email.cl' LIMIT 1)
      AND appointment_date = DATE_ADD(CURDATE(), INTERVAL 3 DAY)
      AND appointment_time = '12:00:00'
);

INSERT INTO appointments (company_id, patient_id, professional_id, box_id, appointment_date, appointment_time, status, notes, created_at, updated_at)
SELECT
    @company_id,
    (SELECT id FROM patients WHERE company_id = @company_id AND email = 'pedro.munoz@email.cl' LIMIT 1),
    (SELECT id FROM professionals WHERE company_id = @company_id AND email = 'matias.herrera@clinicacreative.cl' LIMIT 1),
    NULL,
    DATE_ADD(CURDATE(), INTERVAL 4 DAY),
    '15:00:00',
    'Programada',
    'Revisión de avances.',
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM appointments
    WHERE company_id = @company_id
      AND patient_id = (SELECT id FROM patients WHERE company_id = @company_id AND email = 'pedro.munoz@email.cl' LIMIT 1)
      AND appointment_date = DATE_ADD(CURDATE(), INTERVAL 4 DAY)
      AND appointment_time = '15:00:00'
);

INSERT INTO appointments (company_id, patient_id, professional_id, box_id, appointment_date, appointment_time, status, notes, created_at, updated_at)
SELECT
    @company_id,
    (SELECT id FROM patients WHERE company_id = @company_id AND email = 'camila.salas@email.cl' LIMIT 1),
    (SELECT id FROM professionals WHERE company_id = @company_id AND email = 'antonia.vidal@clinicacreative.cl' LIMIT 1),
    NULL,
    DATE_ADD(CURDATE(), INTERVAL 5 DAY),
    '11:30:00',
    'Confirmada',
    'Plan de fortalecimiento.',
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM appointments
    WHERE company_id = @company_id
      AND patient_id = (SELECT id FROM patients WHERE company_id = @company_id AND email = 'camila.salas@email.cl' LIMIT 1)
      AND appointment_date = DATE_ADD(CURDATE(), INTERVAL 5 DAY)
      AND appointment_time = '11:30:00'
);

INSERT INTO appointments (company_id, patient_id, professional_id, box_id, appointment_date, appointment_time, status, notes, created_at, updated_at)
SELECT
    @company_id,
    (SELECT id FROM patients WHERE company_id = @company_id AND email = 'ignacio.reyes@email.cl' LIMIT 1),
    (SELECT id FROM professionals WHERE company_id = @company_id AND email = 'ricardo.alvarez@clinicacreative.cl' LIMIT 1),
    NULL,
    DATE_ADD(CURDATE(), INTERVAL 6 DAY),
    '08:30:00',
    'Programada',
    'Evaluación funcional.',
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM appointments
    WHERE company_id = @company_id
      AND patient_id = (SELECT id FROM patients WHERE company_id = @company_id AND email = 'ignacio.reyes@email.cl' LIMIT 1)
      AND appointment_date = DATE_ADD(CURDATE(), INTERVAL 6 DAY)
      AND appointment_time = '08:30:00'
);
