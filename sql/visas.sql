-- visas.sql
CREATE TABLE IF NOT EXISTS `visas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `country` VARCHAR(100) NOT NULL,
  `visa_type` VARCHAR(100) DEFAULT NULL,
  `first_name` VARCHAR(120) NOT NULL,
  `last_name` VARCHAR(120) DEFAULT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `nationality` VARCHAR(80) DEFAULT NULL,
  `travel_date` DATE DEFAULT NULL,
  `has_passport` ENUM('yes','no','unknown') DEFAULT 'unknown',
  `message` TEXT DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
