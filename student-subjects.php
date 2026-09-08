<?php

require_once 'common.php';

$cls = [
    9 => [
        'sub'=>'nbse_subjects_nine',
        'session' => 'nbse_session',
        'id' => 'f13',
        'form' => 'nbse_form13'
    ],
    10 => [
        'sub'=>'nbse_subjects',
        'session' => 'nbse_course_session',
        'id' => 'f16',
        'form' => 'nbse_form16'
    ]
];
$cl910 = [];
foreach($cls as $clId => $cl){
    $session = "substring(f.nbse_session,1,4)";
    if($clId==10){
        $session = "case when f.nbse_course_session=2014 then f.nbse_course_session else substring(f.nbse_session,1,4) end";
    }
    $cl910[] = "insert into student_subjects (app_id,subject_id)
select concat('{$cl['id']}',f.nbse_app_id),s.id as subject_id
FROM ".DB_NAME.".`{$cl['form']}` f
INNER JOIN subjects s on $session=s.session_id
where s.subject_code in ('en','ma','sc','ss') and s.class_level_id=$clId and f.nbse_appId_Disable = 'Enable' and length(f.nbse_session)=9
union all
select concat('{$cl['id']}',f.nbse_app_id),s.id as subject_id
FROM ".DB_NAME.".`{$cl['form']}` f
INNER JOIN subjects s on $session=s.session_id and f.nbse_secondLanguage=s.subject_code
where s.class_level_id=$clId and f.nbse_appId_Disable = 'Enable' and length(f.nbse_session)=9
union all
select concat('{$cl['id']}',f.nbse_app_id),s.id as subject_id
FROM ".DB_NAME.".`{$cl['form']}` f
INNER JOIN subjects s on $session=s.session_id and f.nbse_sixSubject=s.subject_code
where s.class_level_id=$clId and f.nbse_appId_Disable = 'Enable' and length(f.nbse_session)=9";
}
$cl910 = implode(";<br><br>", $cl910);

$cl11 = [];
foreach(CL11 as $streamId => $cl){
    foreach($cl['subjects'] as $subject){
        $pos = isset($subject['pos']) ? $subject['pos'] : 'null';
        $cl11[] = "select concat('f42{$streamId}',f.nbse_app_id) as app_id,s.id as subject_id,$pos as pos 
from ".DB_NAME.".`{$cl['ft']}` f join subjects s on f.{$subject['col']}=s.subject_code and substring(f.nbse_session,1,4)=s.session_id 
where f.nbse_appId_Disable='Enable' and length(f.nbse_session)=9 and s.stream_id='{$streamId}' and s.class_level_id=11";
    }
}
$cl11 = implode("<br>union all<br>", $cl11);
$cl11 = "insert into student_subjects (app_id,subject_id,pos)
$cl11";

$cl12 = [];
foreach(CL12 as $streamId => $cl){
    foreach($cl['subjects'] as $subject){
        $pos = isset($subject['pos']) ? $subject['pos'] : 'null';
        $cl12[] = "select concat('f46{$streamId}',f.nbse_app_id) as app_id,s.id as subject_id,$pos as pos 
from ".DB_NAME.".`{$cl['ft']}` f join subjects s on f.{$subject['col']}=s.subject_code and substring(f.nbse_session,1,4)=s.session_id 
where f.nbse_appId_Disable='Enable' and length(f.nbse_session)=9 and s.stream_id='{$streamId}' and s.class_level_id=12";
    }
}
$cl12 = implode("<br>union all<br>", $cl12);
$cl12 = "insert into student_subjects (app_id,subject_id,pos)
$cl12";

$query = "$cl910;

$cl11;

$cl12;";

return $query;