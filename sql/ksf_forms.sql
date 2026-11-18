-- Forms module database schema for FrontAccounting
-- Table: 0_ksf_forms

ALTER TABLE IF EXISTS `fa_forms` RENAME TO `0_ksf_forms`;

CREATE TABLE IF NOT EXISTS `0_ksf_forms` (
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
