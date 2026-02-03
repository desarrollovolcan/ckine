START TRANSACTION;

SET @patients_table := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.TABLES
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'patients'
);
SET @sql := IF(
    @patients_table = 0,
    'CREATE TABLE patients (
        id INT AUTO_INCREMENT PRIMARY KEY,
        company_id INT NOT NULL,
        name VARCHAR(150) NOT NULL,
        rut VARCHAR(20) NULL,
        birthdate DATE NULL,
        email VARCHAR(150) NULL,
        phone VARCHAR(50) NULL,
        status VARCHAR(30) NOT NULL DEFAULT ''Activo'',
        notes TEXT NULL,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        deleted_at DATETIME NULL,
        INDEX idx_patients_company (company_id),
        INDEX idx_patients_status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;',
    'SELECT 1;'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @professionals_table := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.TABLES
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'professionals'
);
SET @sql := IF(
    @professionals_table = 0,
    'CREATE TABLE professionals (
        id INT AUTO_INCREMENT PRIMARY KEY,
        company_id INT NOT NULL,
        name VARCHAR(150) NOT NULL,
        specialty VARCHAR(150) NULL,
        email VARCHAR(150) NULL,
        phone VARCHAR(50) NULL,
        status VARCHAR(30) NOT NULL DEFAULT ''Activo'',
        notes TEXT NULL,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        deleted_at DATETIME NULL,
        INDEX idx_professionals_company (company_id),
        INDEX idx_professionals_status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;',
    'SELECT 1;'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @boxes_table := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.TABLES
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'boxes'
);
SET @sql := IF(
    @boxes_table = 0,
    'CREATE TABLE boxes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        company_id INT NOT NULL,
        name VARCHAR(120) NOT NULL,
        capacity VARCHAR(80) NULL,
        equipment TEXT NULL,
        status VARCHAR(30) NOT NULL DEFAULT ''Disponible'',
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        deleted_at DATETIME NULL,
        INDEX idx_boxes_company (company_id),
        INDEX idx_boxes_status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;',
    'SELECT 1;'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @appointments_table := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.TABLES
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'appointments'
);
SET @sql := IF(
    @appointments_table = 0,
    'CREATE TABLE appointments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        company_id INT NOT NULL,
        patient_id INT NOT NULL,
        professional_id INT NOT NULL,
        box_id INT NULL,
        appointment_date DATE NOT NULL,
        appointment_time TIME NOT NULL,
        status VARCHAR(30) NOT NULL DEFAULT ''Pendiente'',
        notes TEXT NULL,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        deleted_at DATETIME NULL,
        INDEX idx_appointments_company (company_id),
        INDEX idx_appointments_date (appointment_date),
        INDEX idx_appointments_patient (patient_id),
        INDEX idx_appointments_professional (professional_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;',
    'SELECT 1;'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @clinical_notes_table := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.TABLES
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'clinical_notes'
);
SET @sql := IF(
    @clinical_notes_table = 0,
    'CREATE TABLE clinical_notes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        company_id INT NOT NULL,
        patient_id INT NOT NULL,
        professional_id INT NULL,
        note_date DATE NOT NULL,
        title VARCHAR(150) NOT NULL,
        description TEXT NULL,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        deleted_at DATETIME NULL,
        INDEX idx_clinical_notes_company (company_id),
        INDEX idx_clinical_notes_patient (patient_id),
        INDEX idx_clinical_notes_date (note_date)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;',
    'SELECT 1;'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @audit_logs_table := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.TABLES
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'audit_logs'
);
SET @sql := IF(
    @audit_logs_table = 0,
    'CREATE TABLE audit_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        company_id INT NULL,
        user_id INT NOT NULL,
        action VARCHAR(50) NOT NULL,
        entity VARCHAR(100) NOT NULL,
        entity_id INT NULL,
        created_at DATETIME NOT NULL,
        INDEX idx_audit_logs_company (company_id),
        INDEX idx_audit_logs_user (user_id),
        INDEX idx_audit_logs_entity (entity)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;',
    'SELECT 1;'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

COMMIT;
