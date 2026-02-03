START TRANSACTION;

SET @patients_table := (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'patients'
);
SET @sql := IF(@patients_table = 0, '
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    rut VARCHAR(50) NULL,
    birthdate DATE NULL,
    email VARCHAR(150) NULL,
    phone VARCHAR(50) NULL,
    status VARCHAR(50) NOT NULL DEFAULT ''Nuevo'',
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);', 'SELECT 1;');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @clinical_notes_table := (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'clinical_notes'
);
SET @sql := IF(@clinical_notes_table = 0, '
CREATE TABLE clinical_notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    patient_id INT NOT NULL,
    note_date DATE NOT NULL,
    session_label VARCHAR(100) NULL,
    description TEXT NOT NULL,
    created_by INT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);', 'SELECT 1;');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

COMMIT;
