<?php

require_once 'common.php';

$results = "insert into student_exams (id,app_id,centre_id,exam_type_id,roll_no,session_id,student_category_id,wa,ph,ee,result,overall_total,percentage)
SELECT @cl8id+nbse_result_id as id,
  CONCAT('f8', f.nbse_app_id) AS app_id,
  null AS centre_id,
  'board' AS exam_type_id,
  null AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  null as student_category_id,
  null as wa,
  null as ph,
  null as ee,
  r.nbse_result AS result,
  null as overall_total,
  null as percentage
FROM {DB_NAME}.nbse_form8 f JOIN {DB_NAME}.nbse_result_eight r ON f.nbse_app_id = r.nbse_app_id
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl9id+id as id,
  CONCAT('f13', f.nbse_app_id) AS app_id,
  null AS centre_id,
  'board' AS exam_type_id,
  null AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  null as student_category_id,
  null as wa,
  null as ph,
  null as ee,
  r.nbse_result AS result,
  null as overall_total,
  null as percentage
FROM {DB_NAME}.nbse_form13 f JOIN {DB_NAME}.nbse_result_nine r ON f.nbse_app_id = r.nbse_app_id
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl10id+@board+nbse_result_id as id,
  CONCAT('f16', f.nbse_app_id) AS app_id,
  c.id AS centre_id,
  'board' AS exam_type_id,
  f.nbse_hslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  f.nbse_student_category as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  null as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage
FROM {DB_NAME}.nbse_form16 f JOIN {DB_NAME}.nbse_ten_results r ON f.nbse_app_id = r.nbse_app_id
left join centres c on f.nbse_centre_code=c.centre_code and substring(f.nbse_session,1,4)=c.session_id and c.class_level_id=10
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl10id+@comp+nbse_result_id as id,
  CONCAT('f16', f.nbse_app_id) AS app_id,
  c.id AS centre_id,
  'compartment' AS exam_type_id,
  f.nbse_hslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  f.nbse_student_category_compart as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  null as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage
FROM {DB_NAME}.nbse_form16 f JOIN {DB_NAME}.nbse_compartment r ON f.nbse_app_id = r.nbse_app_id
left join centres c on f.nbse_compartment_centre=c.centre_code and substring(f.nbse_session,1,4)=c.session_id and c.class_level_id=10
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl10id+@cc+nbse_result_id as id,
  CONCAT('f16', f.nbse_app_id) AS app_id,
  c.id AS centre_id,
  'compartment_compartment' AS exam_type_id,
  f.nbse_hslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  r.nbse_student_category as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  null as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage
FROM {DB_NAME}.nbse_form16 f JOIN {DB_NAME}.nbse_compartment_board_ten r ON f.nbse_app_id = r.nbse_app_id
left join centres c on r.nbse_centre_id=c.centre_code and substring(f.nbse_session,1,4)=c.session_id and c.class_level_id=10
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl10id+@imp+nbse_result_id as id,
  CONCAT('f16', f.nbse_app_id) AS app_id,
  c.id AS centre_id,
  'improvement' AS exam_type_id,
  f.nbse_hslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  r.nbse_student_category as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  null as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage
FROM {DB_NAME}.nbse_form16 f JOIN {DB_NAME}.nbse_improvement_ten r ON f.nbse_app_id = r.nbse_app_id
left join centres c on r.nbse_centre_id=c.centre_code and substring(f.nbse_session,1,4)=c.session_id and c.class_level_id=10
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl11id+@arts+@board+id as id,
  CONCAT('f42a', f.nbse_app_id) AS app_id,
  null AS centre_id,
  'board' AS exam_type_id,
  null AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  null as student_category_id,
  null as wa,
  null as ph,
  null as ee,
  r.nbse_result AS result,
  null as overall_total,
  null as percentage
FROM {DB_NAME}.nbse_form42arts f JOIN {DB_NAME}.nbse_11arts_result r ON f.nbse_app_id = r.nbse_app_id
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl11id+@commerce+@board+id as id,
  CONCAT('f42c', f.nbse_app_id) AS app_id,
  null AS centre_id,
  'board' AS exam_type_id,
  null AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  null as student_category_id,
  null as wa,
  null as ph,
  null as ee,
  r.nbse_result AS result,
  null as overall_total,
  null as percentage
FROM {DB_NAME}.nbse_form42commerce f JOIN {DB_NAME}.nbse_11commerce_result r ON f.nbse_app_id = r.nbse_app_id
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl11id+@science+@board+id as id,
  CONCAT('f42s', f.nbse_app_id) AS app_id,
  null AS centre_id,
  'board' AS exam_type_id,
  null AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  null as student_category_id,
  null as wa,
  null as ph,
  null as ee,
  r.nbse_result AS result,
  null as overall_total,
  null as percentage
FROM {DB_NAME}.nbse_form42science f JOIN {DB_NAME}.nbse_11science_result r ON f.nbse_app_id = r.nbse_app_id
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl12id+@arts+@board+nbse_result_id as id,
  CONCAT('f46a', f.nbse_app_id) AS app_id,
  c.id AS centre_id,
  'board' AS exam_type_id,
  f.nbse_hsslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  f.nbse_student_category as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  r.nbse_ee as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage
FROM {DB_NAME}.nbse_form46arts f JOIN {DB_NAME}.nbse_12arts_results r ON f.nbse_app_id = r.nbse_app_id
left join centres c on f.nbse_centre_code=c.centre_code and substring(f.nbse_session,1,4)=c.session_id and c.class_level_id=12
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl12id+@commerce+@board+nbse_result_id as id,
  CONCAT('f46c', f.nbse_app_id) AS app_id,
  c.id AS centre_id,
  'board' AS exam_type_id,
  f.nbse_hsslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  f.nbse_student_category as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  r.nbse_ee as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage
FROM {DB_NAME}.nbse_form46commerce f JOIN {DB_NAME}.nbse_12commerce_results r ON f.nbse_app_id = r.nbse_app_id
left join centres c on f.nbse_centre_code=c.centre_code and substring(f.nbse_session,1,4)=c.session_id and c.class_level_id=12
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl12id+@science+@board+nbse_result_id as id,
  CONCAT('f46s', f.nbse_app_id) AS app_id,
  c.id AS centre_id,
  'board' AS exam_type_id,
  f.nbse_hsslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  f.nbse_student_category as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  r.nbse_ee as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage
FROM {DB_NAME}.nbse_form46science f JOIN {DB_NAME}.nbse_12science_results r ON f.nbse_app_id = r.nbse_app_id
left join centres c on f.nbse_centre_code=c.centre_code and substring(f.nbse_session,1,4)=c.session_id and c.class_level_id=12
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl12id+@arts+@comp+nbse_result_id as id,
  CONCAT('f46a', f.nbse_app_id) AS app_id,
  c.id AS centre_id,
  'compartment' AS exam_type_id,
  f.nbse_hsslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  r.nbse_student_category as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  r.nbse_ee as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage
FROM {DB_NAME}.nbse_form46arts f JOIN {DB_NAME}.nbse_compartment12_arts r ON f.nbse_app_id = r.nbse_app_id
left join centres c on r.nbse_centre_id=c.centre_code and substring(f.nbse_session,1,4)=c.session_id and c.class_level_id=12
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl12id+@commerce+@comp+nbse_result_id as id,
  CONCAT('f46c', f.nbse_app_id) AS app_id,
  c.id AS centre_id,
  'compartment' AS exam_type_id,
  f.nbse_hsslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  r.nbse_student_category as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  r.nbse_ee as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage
FROM {DB_NAME}.nbse_form46commerce f JOIN {DB_NAME}.nbse_compartment12_commerce r ON f.nbse_app_id = r.nbse_app_id
left join centres c on r.nbse_centre_id=c.centre_code and substring(f.nbse_session,1,4)=c.session_id and c.class_level_id=12
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl12id+@science+@comp+nbse_result_id as id,
  CONCAT('f46s', f.nbse_app_id) AS app_id,
  c.id AS centre_id,
  'compartment' AS exam_type_id,
  f.nbse_hsslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  r.nbse_student_category as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  r.nbse_ee as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage
FROM {DB_NAME}.nbse_form46science f JOIN {DB_NAME}.nbse_compartment12_science r ON f.nbse_app_id = r.nbse_app_id
left join centres c on r.nbse_centre_id=c.centre_code and substring(f.nbse_session,1,4)=c.session_id and c.class_level_id=12
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl12id+@arts+@cc+nbse_result_id as id,
  CONCAT('f46a', f.nbse_app_id) AS app_id,
  c.id AS centre_id,
  'compartment_compartment' AS exam_type_id,
  f.nbse_hsslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  r.nbse_student_category as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  r.nbse_ee as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage
FROM {DB_NAME}.nbse_form46arts f JOIN {DB_NAME}.nbse_compartmentboard12_arts r ON f.nbse_app_id = r.nbse_app_id
left join centres c on r.nbse_centre_id=c.centre_code and substring(f.nbse_session,1,4)=c.session_id and c.class_level_id=12
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl12id+@commerce+@cc+nbse_result_id as id,
  CONCAT('f46c', f.nbse_app_id) AS app_id,
  c.id AS centre_id,
  'compartment_compartment' AS exam_type_id,
  f.nbse_hsslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  r.nbse_student_category as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  r.nbse_ee as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage
FROM {DB_NAME}.nbse_form46commerce f JOIN {DB_NAME}.nbse_compartmentboard12_commerce r ON f.nbse_app_id = r.nbse_app_id
left join centres c on r.nbse_centre_id=c.centre_code and substring(f.nbse_session,1,4)=c.session_id and c.class_level_id=12
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl12id+@science+@cc+nbse_result_id as id,
  CONCAT('f46s', f.nbse_app_id) AS app_id,
  c.id AS centre_id,
  'compartment_compartment' AS exam_type_id,
  f.nbse_hsslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  r.nbse_student_category as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  r.nbse_ee as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage
FROM {DB_NAME}.nbse_form46science f JOIN {DB_NAME}.nbse_compartmentboard12_science r ON f.nbse_app_id = r.nbse_app_id
left join centres c on r.nbse_centre_id=c.centre_code and substring(f.nbse_session,1,4)=c.session_id and c.class_level_id=12
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl12id+@arts+@imp+nbse_result_id as id,
  CONCAT('f46a', f.nbse_app_id) AS app_id,
  c.id AS centre_id,
  'improvement' AS exam_type_id,
  f.nbse_hsslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  r.nbse_student_category as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  r.nbse_ee as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage
FROM {DB_NAME}.nbse_form46arts f JOIN {DB_NAME}.nbse_improvement12_arts r ON f.nbse_app_id = r.nbse_app_id
left join centres c on r.nbse_centre_id=c.centre_code and substring(f.nbse_session,1,4)=c.session_id and c.class_level_id=12
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl12id+@commerce+@imp+nbse_result_id as id,
  CONCAT('f46c', f.nbse_app_id) AS app_id,
  c.id AS centre_id,
  'improvement' AS exam_type_id,
  f.nbse_hsslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  r.nbse_student_category as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  r.nbse_ee as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage
FROM {DB_NAME}.nbse_form46commerce f JOIN {DB_NAME}.nbse_improvement12_commerce r ON f.nbse_app_id = r.nbse_app_id
left join centres c on r.nbse_centre_id=c.centre_code and substring(f.nbse_session,1,4)=c.session_id and c.class_level_id=12
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'
union all
SELECT @cl12id+@science+@imp+nbse_result_id as id,
  CONCAT('f46s', f.nbse_app_id) AS app_id,
  c.id AS centre_id,
  'improvement' AS exam_type_id,
  f.nbse_hsslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  r.nbse_student_category as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  r.nbse_ee as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage
FROM {DB_NAME}.nbse_form46science f JOIN {DB_NAME}.nbse_improvement12_science r ON f.nbse_app_id = r.nbse_app_id
left join centres c on r.nbse_centre_id=c.centre_code and substring(f.nbse_session,1,4)=c.session_id and c.class_level_id=12
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable';";