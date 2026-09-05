<?php

require_once 'common.php';

$ids = "
set @cl8id = 100000000000;
set @cl9id = 200000000000;
set @cl10id = 300000000000;
set @cl11id = 400000000000;
set @cl12id = 500000000000;
set @arts = 10000000000;
set @commerce = 20000000000;
set @science = 30000000000;
set @board = 1000000000;
set @comp = 2000000000;
set @imp = 3000000000;
set @cc = 4000000000;
";

$insert = "insert into student_exams (id,app_id,exam_id,roll_no,session_id,student_category_id,wa,ph,ee,result,overall_total,percentage,center_id)";

$cl10Results = [
  'board' => [
    'table'=>'nbse_ten_results',
    'centre_col'=>'f.nbse_centre_code',
    'cat_col'=>'f.nbse_student_category',
    'idcode'=>'board'
  ],
  'compartment' => [
    'table'=>'nbse_compartment',
    'centre_col'=>'f.nbse_compartment_centre',
    'cat_col'=>'f.nbse_student_category_compart',
    'idcode'=>'comp',
  ],
  'compartment_compartment' => [
    'table'=>'nbse_compartment_board_ten',
    'centre_col'=>'r.nbse_centre_id',
    'cat_col'=>'r.nbse_student_category',
    'idcode'=>'cc',
  ],
  'enhancement' => [
    'table'=>'nbse_improvement_ten',
    'centre_col'=>'r.nbse_centre_id',
    'cat_col'=>'r.nbse_student_category',
    'idcode'=>'imp',
  ],
];
$cl10q = [];
foreach($cl10Results as $examType => $exam){
  $cl10q[] = "SELECT @cl10id+@{$exam['idcode']}+nbse_result_id as id,
  CONCAT('f16', f.nbse_app_id) AS app_id,
  (select id from exams where session_id=substring(f.nbse_session,1,4) and exam_type_id='{$examType}' and class_level_id=10 limit 1) as exam_id,
  f.nbse_hslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  {$exam['cat_col']} as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  null as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage,
  (select centers.id from centers join center_exam on centers.id=center_exam.center_id join exams on center_exam.exam_id=exams.id where {$exam['centre_col']}=centers.center_code and substring(f.nbse_session,1,4)=exams.session_id and centers.class_level_id=10 and exam_type_id='{$examType}' limit 1) as center_id
FROM ".DB_NAME.".nbse_form16 f JOIN ".DB_NAME.".{$exam['table']} r ON f.nbse_app_id = r.nbse_app_id
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'";
}
$cl10q = implode("<br>UNION ALL<br>", $cl10q);

$cl11 = CL11;
$cl11q = [];
foreach($cl11 as $streamCode => $stream){
  $cl11q[] = "SELECT @cl11id+@{$stream['idcode']}+@board+id as id,
  CONCAT('f42{$streamCode}', f.nbse_app_id) AS app_id,
  (select id from exams where session_id=substring(f.nbse_session,1,4) and exam_type_id='board' and class_level_id=11 limit 1) as exam_id,
  null AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  null as student_category_id,
  null as wa,
  null as ph,
  null as ee,
  r.nbse_result AS result,
  null as overall_total,
  null as percentage,
  null AS centre_id
FROM ".DB_NAME.".{$stream['ft']} f JOIN ".DB_NAME.".{$stream['rt']} r ON f.nbse_app_id = r.nbse_app_id
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable'";
}
$cl11q = implode("<br>UNION ALL<br>", $cl11q);

$cl12 = CL12;
$cl12q = [];
$cl12Results = [
  'board' => [
    'centre_col'=>'f.nbse_centre_code',
    'cat_col'=>'f.nbse_student_category',
    'idcode'=>'board'
  ],
  'compartment' => [
    'centre_col'=>'r.nbse_centre_id',
    'cat_col'=>'r.nbse_student_category',
    'idcode'=>'comp',
  ],
  'compartment_compartment' => [
    'centre_col'=>'r.nbse_centre_id',
    'cat_col'=>'r.nbse_student_category',
    'idcode'=>'cc',
  ],
  'enhancement' => [
    'centre_col'=>'r.nbse_centre_id',
    'cat_col'=>'r.nbse_student_category',
    'idcode'=>'imp',
  ],
];
foreach($cl12 as $streamCode => $stream){
  foreach($cl12Results as $examType => $exam){
    $cl12q[] = "SELECT @cl12id+@{$stream['idcode']}+@{$exam['idcode']}+nbse_result_id as id,
  CONCAT('f46{$streamCode}', f.nbse_app_id) AS app_id,
  (select id from exams where session_id=substring(f.nbse_session,1,4) and exam_type_id='{$examType}' and class_level_id=12 limit 1) as exam_id,
  f.nbse_hsslc_roll AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  {$exam['cat_col']} as student_category_id,
  r.nbse_work_art as wa,
  r.nbse_physical_health as ph,
  r.nbse_ee as ee,
  r.nbse_results AS result,
  nbse_overall_total as overall_total,
  nbse_percentage as percentage,
  (select centers.id from centers join center_exam on centers.id=center_exam.center_id join exams on center_exam.exam_id=exams.id where {$exam['centre_col']}=centers.center_code and substring(f.nbse_session,1,4)=exams.session_id and centers.class_level_id=12 and exam_type_id='{$examType}' limit 1) as center_id
FROM ".DB_NAME.".{$stream['ft']} f JOIN ".DB_NAME.".".$stream['exams'][$exam['idcode']]['table']." r ON f.nbse_app_id = r.nbse_app_id
WHERE length(f.nbse_session)=9 and f.nbse_session>='2016-2017' and f.nbse_appId_Disable='Enable'";
  }
}
$cl12q = implode("<br>UNION ALL<br>", $cl12q);

$results = "$insert
SELECT @cl8id+nbse_result_id as id,
  CONCAT('f8', f.nbse_app_id) AS app_id,
  (select id from exams where session_id=substring(f.nbse_session,1,4) and exam_type_id='board' and class_level_id=8 limit 1) as exam_id,
  null AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  null as student_category_id,
  null as wa,
  null as ph,
  null as ee,
  r.nbse_result AS result,
  null as overall_total,
  null as percentage,
  null as center_id
FROM ".DB_NAME.".nbse_form8 f JOIN ".DB_NAME.".nbse_result_eight r ON f.nbse_app_id = r.nbse_app_id
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable';

$insert
SELECT @cl9id+id as id,
  CONCAT('f13', f.nbse_app_id) AS app_id,
  (select id from exams where session_id=substring(f.nbse_session,1,4) and exam_type_id='board' and class_level_id=9 limit 1) as exam_id,
  null AS roll_no,
  SUBSTRING(f.nbse_session, 1, 4) AS session_id,
  null as student_category_id,
  null as wa,
  null as ph,
  null as ee,
  r.nbse_result AS result,
  null as overall_total,
  null as percentage,
  null as center_id
FROM ".DB_NAME.".nbse_form13 f JOIN ".DB_NAME.".nbse_result_nine r ON f.nbse_app_id = r.nbse_app_id
WHERE length(f.nbse_session)=9 and f.nbse_appId_Disable='Enable';

$insert
$cl10q;

$insert
$cl11q;

$insert
$cl12q;

update student_exams e join student_sessions s on e.app_id=s.app_id set e.student_session_id=s.id;";

return $ids."<br>".$results;