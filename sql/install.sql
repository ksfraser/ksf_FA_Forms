-- Forms module database schema for FrontAccounting

CREATE TABLE IF NOT EXISTS `fa_forms` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `fields` JSON,
    `cf7_shortcode` VARCHAR(100) DEFAULT NULL,
    `status` ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    `created_by` INT(11) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `fa_form_submissions` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `form_id` INT(11) NOT NULL,
    `data` JSON,
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `submitted_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `form_id` (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `fa_modules` (`name`, `version`, `enabled`, `installed`) VALUES ('Forms', '1.0.0', 1, NOW()) ON DUPLICATE KEY UPDATE `version` = '1.0.0';