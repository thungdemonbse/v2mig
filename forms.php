<?php

require_once 'common.php';

$studentCategory = "case when f.nbse_repeaters='Yes' then 'Repeater' when f.nbse_migration_student='Yes' then 'Migration' else 'Regular' end as reg_category_id";
$studentStatus="case when f.nbse_form_statusG='Approved' then 'approved' else 'submitted' end as reg_status_id";

$forms = "insert into student_sessions (primary_id,session_id,reg_no,school_code,class_level_id,stream_id,is_repeater,is_migration,financial_literacy,app_id,reg_category_id,reg_status_id,created_at,
    updated_at)
select tmp.primary_id,
  tmp.session_id,
  tmp.reg_no,
  tmp.school_code,
  tmp.class_level_id,
  tmp.stream_id,
  tmp.is_repeater,
  tmp.is_migration,
  tmp.financial_literacy,
  tmp.app_id,
  tmp.reg_category_id,
    tmp.reg_status_id,
  tmp.created_at,
  tmp.updated_at from (
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      8 as class_level_id,
      null as stream_id,
      (nbse_repeaters <=> 'Yes') AS is_repeater,
      (nbse_migration_student <=> 'Yes') AS is_migration,
      null as financial_literacy,
      concat('f8',f.nbse_app_id) as app_id,
      $studentCategory,
      $studentStatus,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM ".DB_NAME.".`nbse_form8` f JOIN ".DB_NAME.".nbse_asc_9_10 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN ".DB_NAME.".nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
  union all
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      9 as class_level_id,
      null as stream_id,
      (nbse_repeaters <=> 'Yes') AS is_repeater,
      (nbse_migration_student <=> 'Yes') AS is_migration,
      nbse_fin_literacy as financial_literacy,
      concat('f13',f.nbse_app_id) as app_id,
      $studentCategory,
      $studentStatus,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM ".DB_NAME.".`nbse_form13` f JOIN ".DB_NAME.".nbse_asc_9_10 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN ".DB_NAME.".nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
  union all
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      10 as class_level_id,
      null as stream_id,
      (nbse_repeaters <=> 'Yes') AS is_repeater,
      (nbse_migration_student <=> 'Yes') AS is_migration,
      nbse_fin_literacy as financial_literacy,
      concat('f16',f.nbse_app_id) as app_id,
      $studentCategory,
      $studentStatus,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM ".DB_NAME.".`nbse_form16` f JOIN ".DB_NAME.".nbse_asc_9_10 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN ".DB_NAME.".nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
  union all
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      11 as class_level_id,
      'A' as stream_id,
      (nbse_repeaters <=> 'Yes') AS is_repeater,
      (nbse_migration_student <=> 'Yes') AS is_migration,
      null as financial_literacy,
      concat('f42a',f.nbse_app_id) as app_id,
      $studentCategory,
      $studentStatus,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM ".DB_NAME.".`nbse_form42arts` f JOIN ".DB_NAME.".nbse_asc_11_12 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN ".DB_NAME.".nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
  union all
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      11 as class_level_id,
      'C' as stream_id,
      (nbse_repeaters <=> 'Yes') AS is_repeater,
      (nbse_migration_student <=> 'Yes') AS is_migration,
      null as financial_literacy,
      concat('f42c',f.nbse_app_id) as app_id,
      $studentCategory,
      $studentStatus,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM ".DB_NAME.".`nbse_form42commerce` f JOIN ".DB_NAME.".nbse_asc_11_12 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN ".DB_NAME.".nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
  union all
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      11 as class_level_id,
      'S' as stream_id,
      (nbse_repeaters <=> 'Yes') AS is_repeater,
      (nbse_migration_student <=> 'Yes') AS is_migration,
      null as financial_literacy,
      concat('f42s',f.nbse_app_id) as app_id,
      $studentCategory,
      $studentStatus,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM ".DB_NAME.".`nbse_form42science` f JOIN ".DB_NAME.".nbse_asc_11_12 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN ".DB_NAME.".nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
  union all
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      12 as class_level_id,
      'A' as stream_id,
      (nbse_repeaters <=> 'Yes') AS is_repeater,
      (nbse_migration_student <=> 'Yes') AS is_migration,
      null as financial_literacy,
      concat('f46a',f.nbse_app_id) as app_id,
      $studentCategory,
      $studentStatus,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM ".DB_NAME.".`nbse_form46arts` f JOIN ".DB_NAME.".nbse_asc_11_12 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN ".DB_NAME.".nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
  union all
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      12 as class_level_id,
      'C' as stream_id,
      (nbse_repeaters <=> 'Yes') AS is_repeater,
      (nbse_migration_student <=> 'Yes') AS is_migration,
      null as financial_literacy,
      concat('f46c',f.nbse_app_id) as app_id,
      $studentCategory,
      $studentStatus,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM ".DB_NAME.".`nbse_form46commerce` f JOIN ".DB_NAME.".nbse_asc_11_12 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN ".DB_NAME.".nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
  union all
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      12 as class_level_id,
      'S' as stream_id,
      (nbse_repeaters <=> 'Yes') AS is_repeater,
      (nbse_migration_student <=> 'Yes') AS is_migration,
      null as financial_literacy,
      concat('f46s',f.nbse_app_id) as app_id,
      $studentCategory,
      $studentStatus,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM ".DB_NAME.".`nbse_form46science` f JOIN ".DB_NAME.".nbse_asc_11_12 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN ".DB_NAME.".nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
) as tmp
where tmp.session_id regexp '^[0-9]{4}$' and nullif(tmp.primary_id,'') is not null;

ALTER TABLE student_sessions ADD INDEX idx_school_session (school_code, session_id);
ALTER TABLE school_sessions ADD INDEX idx_school_session (school_code, session_id);
update student_sessions ss join school_sessions s on ss.school_code=s.school_code and ss.session_id=s.session_id set ss.school_id=s.id;
ALTER TABLE `student_sessions` DROP INDEX `idx_school_session`;
ALTER TABLE `school_sessions` DROP INDEX `idx_school_session`;

update student_sessions ss join students s on ss.primary_id=s.primary_id set ss.student_id=s.id;";

return $forms;