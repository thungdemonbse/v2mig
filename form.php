<?php

require_once 'common.php';

$forms = "insert into student_sessions (primary_id,session_id,reg_no,school_code,class_level_id,stream_id,is_repeater,is_migration,financial_literacy,app_id,created_at,
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
  tmp.created_at,
  tmp.updated_at from (
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      8 as class_level_id,
      null as stream_id,
      (nbse_repeaters = 'Yes') AS is_repeater,
      (nbse_migration_student = 'Yes') AS is_migration,
      null as financial_literacy,
      concat('f8',f.nbse_app_id) as app_id,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM {DB_NAME}.`nbse_form8` f JOIN {DB_NAME}.nbse_asc_9_10 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN {DB_NAME}.nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
  union all
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      9 as class_level_id,
      null as stream_id,
      (nbse_repeaters = 'Yes') AS is_repeater,
      (nbse_migration_student = 'Yes') AS is_migration,
      nbse_fin_literacy as financial_literacy,
      concat('f13',f.nbse_app_id) as app_id,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM {DB_NAME}.`nbse_form13` f JOIN {DB_NAME}.nbse_asc_9_10 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN {DB_NAME}.nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
  union all
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      10 as class_level_id,
      null as stream_id,
      (nbse_repeaters = 'Yes') AS is_repeater,
      (nbse_migration_student = 'Yes') AS is_migration,
      nbse_fin_literacy as financial_literacy,
      concat('f16',f.nbse_app_id) as app_id,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM {DB_NAME}.`nbse_form16` f JOIN {DB_NAME}.nbse_asc_9_10 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN {DB_NAME}.nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
  union all
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      11 as class_level_id,
      'A' as stream_id,
      (nbse_repeaters = 'Yes') AS is_repeater,
      (nbse_migration_student = 'Yes') AS is_migration,
      null as financial_literacy,
      concat('f42a',f.nbse_app_id) as app_id,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM {DB_NAME}.`nbse_form42arts` f JOIN {DB_NAME}.nbse_asc_11_12 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN {DB_NAME}.nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
  union all
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      11 as class_level_id,
      'C' as stream_id,
      (nbse_repeaters = 'Yes') AS is_repeater,
      (nbse_migration_student = 'Yes') AS is_migration,
      null as financial_literacy,
      concat('f42c',f.nbse_app_id) as app_id,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM {DB_NAME}.`nbse_form42commerce` f JOIN {DB_NAME}.nbse_asc_11_12 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN {DB_NAME}.nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
  union all
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      11 as class_level_id,
      'S' as stream_id,
      (nbse_repeaters = 'Yes') AS is_repeater,
      (nbse_migration_student = 'Yes') AS is_migration,
      null as financial_literacy,
      concat('f42s',f.nbse_app_id) as app_id,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM {DB_NAME}.`nbse_form42science` f JOIN {DB_NAME}.nbse_asc_11_12 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN {DB_NAME}.nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
  union all
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      12 as class_level_id,
      'A' as stream_id,
      (nbse_repeaters = 'Yes') AS is_repeater,
      (nbse_migration_student = 'Yes') AS is_migration,
      null as financial_literacy,
      concat('f46a',f.nbse_app_id) as app_id,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM {DB_NAME}.`nbse_form46arts` f JOIN {DB_NAME}.nbse_asc_11_12 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN {DB_NAME}.nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
  union all
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      12 as class_level_id,
      'C' as stream_id,
      (nbse_repeaters = 'Yes') AS is_repeater,
      (nbse_migration_student = 'Yes') AS is_migration,
      null as financial_literacy,
      concat('f46c',f.nbse_app_id) as app_id,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM {DB_NAME}.`nbse_form46commerce` f JOIN {DB_NAME}.nbse_asc_11_12 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN {DB_NAME}.nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
  union all
  SELECT
      p.nbse_primary_id as primary_id,
      substring(f.nbse_session,1,4) as session_id,
      f.nbse_reg_no as reg_no,
      f.nbse_school_code as school_code,
      12 as class_level_id,
      'S' as stream_id,
      (nbse_repeaters = 'Yes') AS is_repeater,
      (nbse_migration_student = 'Yes') AS is_migration,
      null as financial_literacy,
      concat('f46s',f.nbse_app_id) as app_id,
      f.created_date as created_at,
      f.updated_date as updated_at
  FROM {DB_NAME}.`nbse_form46science` f JOIN {DB_NAME}.nbse_asc_11_12 a ON f.nbse_reg_no = a.nbse_reg_no 
  JOIN {DB_NAME}.nbse_form13primary p ON a.nbse_primary_id = p.nbse_primary_id
  WHERE f.nbse_appId_Disable='Enable'
) as tmp
where tmp.session_id regexp '^[0-9]{4}$' and nullif(tmp.primary_id,'') is not null;";

return $forms;