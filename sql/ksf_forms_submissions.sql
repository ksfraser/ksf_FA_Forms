-- Forms module database schema for FrontAccounting
-- Table: 0_ksf_forms_submissions

ALTER TABLE IF EXISTS `fa_form_submissions` RENAME TO `0_ksf_forms_submissions`;

CREATE TABLE IF NOT EXISTS `0_ksf_forms_submissions` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `form_id` INT(11) NOT NULL,
    `data` JSON,
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `submitted_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `form_id` (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
