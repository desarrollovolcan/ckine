START TRANSACTION;

SET @professionals_table := (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'professionals'
);
SET @sql := IF(@professionals_table = 0, '
CREATE TABLE professionals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    rut VARCHAR(50) NOT NULL,
    license_number VARCHAR(100) NOT NULL,
    specialty VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT ''Activo'',
    modality VARCHAR(50) NOT NULL,
    box VARCHAR(50) NULL,
    schedule VARCHAR(150) NOT NULL,
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);', 'SELECT 1;');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

COMMIT;
