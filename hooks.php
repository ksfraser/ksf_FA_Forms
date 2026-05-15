<?php
/**
 * FA_Forms Module Hooks for FrontAccounting
 */

define('SS_FORMS', 118 << 8);

class hooks_fa_forms extends hooks {

    private function ensure_composer_dependencies(): void {
        $module_dir = dirname(__FILE__);
        $autoload_path = $module_dir . '/vendor/autoload.php';
        
        if (!file_exists($autoload_path)) {
            $composer_path = $module_dir . '/composer.json';
            if (file_exists($composer_path)) {
                chdir($module_dir);
                $output = [];
                $return_code = 0;
                exec('composer install --no-interaction --prefer-dist 2>&1', $output, $return_code);
                if ($return_code !== 0) {
                    error_log('KSF Module: composer install failed: ' . implode("\n", $output));
                }
            }
        }
    }
    var $module_name = 'fa_forms';

    private function ensure_composer_dependencies(): void {
        $module_dir = dirname(__FILE__);
        $autoload_path = $module_dir . '/vendor/autoload.php';
        
        if (!file_exists($autoload_path)) {
            $composer_path = $module_dir . '/composer.json';
            if (file_exists($composer_path)) {
                chdir($module_dir);
                $output = [];
                $return_code = 0;
                exec('composer install --no-interaction --prefer-dist 2>&1', $output, $return_code);
                if ($return_code !== 0) {
                    error_log('KSF Module: composer install failed: ' . implode("\n", $output));
                }
            }
        }
    }
    var $version = '1.0.0';

    private function ensure_composer_dependencies(): void {
        $module_dir = dirname(__FILE__);
        $autoload_path = $module_dir . '/vendor/autoload.php';
        
        if (!file_exists($autoload_path)) {
            $composer_path = $module_dir . '/composer.json';
            if (file_exists($composer_path)) {
                chdir($module_dir);
                $output = [];
                $return_code = 0;
                exec('composer install --no-interaction --prefer-dist 2>&1', $output, $return_code);
                if ($return_code !== 0) {
                    error_log('KSF Module: composer install failed: ' . implode("\n", $output));
                }
            }
        }
    }

    function install_options($app) {
        global $path_to_root;

        switch($app->id) {
            case 'CRM':
                $app->add_lapp_function(0, _("Form Builder"),
                    $path_to_root."/modules/".$this->module_name."/forms.php", 'SA_FORMSVIEW', MENU_ENTRY);
                $app->add_lapp_function(1, _("Submissions"),
                    $path_to_root."/modules/".$this->module_name."/submissions.php", 'SA_FORMSCREATE', MENU_ENTRY);
                break;
        }
    }

    function install_access() {
        $security_sections[SS_FORMS] = _("Form Builder");
        $security_areas['SA_FORMSVIEW'] = array(SS_FORMS | 1, _("View Forms"));
        $security_areas['SA_FORMSCREATE'] = array(SS_FORMS | 2, _("Create Forms"));
        return array($security_areas, $security_sections);
    }

    function activate_extension($company, $check_only=true) {
        $updates = array('sql/update.sql' => array($this->module_name));
        $ok = $this->update_databases($company, $updates, $check_only);
        if ($check_only || !$ok) {
            return $ok;
        }
        $this->ensure_forms_schema();
        return $ok;
    }

    private function table_exists($table) {
        $sql = "SHOW TABLES LIKE " . db_escape($table);
        $res = db_query($sql, 'Failed checking table existence');
        return db_num_rows($res) > 0;
    }

    private function ensure_forms_schema() {
        $tables = array(
            TB_PREF . "fa_forms" => "
                CREATE TABLE IF NOT EXISTS `" . TB_PREF . "fa_forms` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(100) NOT NULL,
                    `description` TEXT,
                    `form_fields` JSON,
                    `status` VARCHAR(20) DEFAULT 'Active',
                    `cf7_integration` TINYINT(1) DEFAULT 0,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    KEY `idx_status` (`status`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

            TB_PREF . "fa_form_submissions" => "
                CREATE TABLE IF NOT EXISTS `" . TB_PREF . "fa_form_submissions` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `form_id` INT(11) NOT NULL,
                    `submission_data` JSON,
                    `submitter_email` VARCHAR(100) DEFAULT NULL,
                    `submitter_name` VARCHAR(100) DEFAULT NULL,
                    `debtor_no` VARCHAR(20) DEFAULT NULL,
                    `submitted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    KEY `idx_form` (`form_id`),
                    KEY `idx_debtor` (`debtor_no`),
                    KEY `idx_submitted` (`submitted_at`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
        );

        foreach ($tables as $table_name => $sql) {
            db_query($sql, "Could not create Forms table: $table_name");
        }
    }

    function db_prevoid($trans_type, $trans_no) {
        // Handle voiding if needed
    }
}
?>
