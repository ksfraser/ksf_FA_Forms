<?php
// Forms DB Functions
function get_forms():?object{global$db;return$db->query("SELECT*FROM ".TB_PREF."ksf_forms WHERE status='Active' ORDER BY name");}
function create_form(string$name,string$title,array$fields):int{global$db;$db->query("INSERT INTO ".TB_PREF."ksf_forms(name,title,fields,created_by)VALUES(".$db->escape($name).",".$db->escape($title).",".$db->escape(json_encode($fields)).",".user_id().")");return$db->insert_id;}
function save_submission(int$form_id,array$data):int{global$db;$db->query("INSERT INTO ".TB_PREF."ksf_forms_submissions(form_id,data,ip_address)VALUES(".$form_id.",".$db->escape(json_encode($data)).",".$db->escape($_SERVER['REMOTE_ADDR'].")");return$db->insert_id;}