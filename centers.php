<?php
require_once 'common.php';

$streams = require 'streams.php';

$center = "insert into centers (id,name,center_code,session_id,school_session_id,class_level_id,created_at,updated_at)
SELECT
    1000000+c.centre_code_id as id,
    ifnull(c.`nbse_centre_name`,c.`nbse_centre_code`) as name,
    c.`nbse_centre_code` as center_code,
    substring(c.nbse_session,1,4) as session_id,
    s.id as school_id,
    10 as class_level_id,
    c.nbse_created_date as created_at,
    c.nbse_updated_date as updated_at
FROM ".DB_NAME.".nbse_centrecode c left join school_sessions s on c.nbse_school_code=s.school_code and substring(c.nbse_session,1,4)=s.session_id
WHERE nbse_session is not null
union all
SELECT
    1100000+c.centre_code_id as id,
    c.nbse_compart_centre_name as name,
    c.`nbse_centre_code` as center_code,
    substring(c.nbse_session,1,4) as session_id,
    s.id as school_id,
    10 as class_level_id,
    c.nbse_created_date as created_at,
    c.nbse_updated_date as updated_at
FROM ".DB_NAME.".nbse_centrecode c left join school_sessions s on c.nbse_school_code=s.school_code and substring(c.nbse_session,1,4)=s.session_id
WHERE nbse_session is not null and nullif(c.nbse_compart_centre_name,'') is not null
union all
SELECT
    2000000+c.centre_code_id as id,
    ifnull(c.`nbse_centre_name`,c.`nbse_centre_code`) as name,
    c.`nbse_centre_code` as center_code,
    substring(c.nbse_session,1,4) as session_id,
    s.id as school_id,
    12 as class_level_id,
    c.nbse_created_date as created_at,
    c.nbse_updated_date as updated_at
FROM ".DB_NAME.".nbse_centre_twelve c left join school_sessions s on c.nbse_school_code=s.school_code and substring(c.nbse_session,1,4)=s.session_id
WHERE nbse_session is not null
union all
SELECT
    2100000+c.centre_code_id as id,
    c.nbse_compart_centre_name as name,
    c.`nbse_centre_code` as center_code,
    substring(c.nbse_session,1,4) as session_id,
    s.id as school_id,
    12 as class_level_id,
    c.nbse_created_date as created_at,
    c.nbse_updated_date as updated_at
FROM ".DB_NAME.".nbse_centre_twelve c left join school_sessions s on c.nbse_school_code=s.school_code and substring(c.nbse_session,1,4)=s.session_id
WHERE nbse_session is not null and nullif(c.nbse_compart_centre_name,'') is not null;";

$centerExam = "insert into center_exam (center_id,exam_id)
select c.id as center_id,e.id as exam_id from centers c join exams e on c.session_id=e.exam_session_id and c.class_level_id=e.class_level_id
where e.exam_type_id in ('board','compartment_compartment') and c.id like '_0%'
UNION ALL
select 
    (case when c.nbse_compart_centre_name is null then 1000000 else 1100000 end) + c.centre_code_id as center_id,
    (select id from ".PORTAL_DB.".exams where class_level_id=10 and exam_type_id='compartment' and session_id=substring(f.nbse_session,1,4) limit 1) as exam_id
from ".DB_NAME.".nbse_compartment r join ".DB_NAME.".nbse_form16 f ON r.nbse_app_id = f.nbse_app_id
join ".DB_NAME.".nbse_centrecode c ON f.nbse_compartment_centre = c.nbse_centre_code AND case when f.nbse_session='2020-2021' then '2021-2022' else f.nbse_session end = c.nbse_session
where nullif(f.nbse_session, '') is not null
group by c.nbse_centre_code,c.nbse_session
UNION ALL
select 
    (case when c.nbse_compart_centre_name is null then 1000000 else 1100000 end) + c.centre_code_id as center_id,
    (select id from ".PORTAL_DB.".exams where class_level_id=10 and exam_type_id='enhancement' and session_id=substring(f.nbse_session,1,4) limit 1) as exam_id
from ".DB_NAME.".nbse_improvement_ten r join ".DB_NAME.".nbse_form16 f ON r.nbse_app_id = f.nbse_app_id
join ".DB_NAME.".nbse_centrecode c ON r.nbse_centre_id = c.nbse_centre_code and r.nbse_session = c.nbse_session
where nullif(f.nbse_session, '') is not null
group by c.nbse_centre_code,c.nbse_session";

$queries = [];
foreach($streams as $stream){
    $queries[] = "SELECT 
    (case when c.nbse_compart_centre_name is null then 2000000 else 2100000 end) + c.centre_code_id as center_id,
    (select id from ".PORTAL_DB.".exams where class_level_id=12 and exam_type_id='compartment' and session_id=substring(f.nbse_session,1,4) limit 1) as exam_id
FROM ".DB_NAME.".{$stream['exams']['comp']['table']} r JOIN ".DB_NAME.".{$stream['ft']} f ON r.nbse_app_id = f.nbse_app_id
JOIN ".DB_NAME.".nbse_centre_twelve c ON cast(r.nbse_centre_id as char character set latin1) = c.nbse_centre_code AND f.nbse_session = c.nbse_session
WHERE NULLIF(f.nbse_session, '') IS NOT NULL
GROUP BY c.nbse_centre_code,c.nbse_session
UNION
SELECT 
    (case when c.nbse_compart_centre_name is null then 2000000 else 2100000 end) + c.centre_code_id as center_id,
    (select id from ".PORTAL_DB.".exams where class_level_id=12 and exam_type_id='enhancement' and session_id=substring(f.nbse_session,1,4) limit 1) as exam_id
FROM ".DB_NAME.".{$stream['exams']['imp']['table']} r JOIN ".DB_NAME.".{$stream['ft']} f ON r.nbse_app_id = f.nbse_app_id
JOIN ".DB_NAME.".nbse_centre_twelve c ON cast(r.nbse_centre_id as char character set latin1) = c.nbse_centre_code AND r.nbse_session = c.nbse_session
WHERE NULLIF(f.nbse_session, '') IS NOT NULL
GROUP BY c.nbse_centre_code,c.nbse_session";
}
$centerExam = $centerExam . "<br>union all<br>" . implode("<br>union<br>", $queries).";";

$query = "$center<br><br>$centerExam";

return $query;