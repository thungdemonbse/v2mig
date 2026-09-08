<?php

$cols = [
    "'EN'" => 'nbse_eng',
    "'MA'" => 'nbse_maths',
    "'SC'" => 'nbse_science',
    "'SS'" => 'nbse_ss',
    "f.nbse_secondLanguage" => 'nbse_second',
    "f.nbse_sixSubject" => 'nbse_sixth'
];
$tables = [
    'nbse_ten_results'=>'@board',
    'nbse_compartment'=>'@comp',
    'nbse_improvement_ten'=>'@imp',
    'nbse_compartment_board_ten'=>'@cc'
];
$cl10 = [];
foreach($tables as $table=>$counter){
    foreach($cols as $subCode => $col){
        $appeared = "'1'";
        $join = '';
        $mathsPaper = 'null';
        if($subCode=="'MA'"){
            $colName = "r.maths_paper";
            if($counter=='@board'){
                $colName = "f.nbse_maths_paper";
            }
            $mathsPaper = "(select p.id from papers p join subjects s on p.subject_id=s.id where {$colName}=p.name and s.class_level_id=10 and substring(f.nbse_session,1,4)=s.session_id)";
        }
        if($counter=='@imp'){
            $temp = str_replace('sixth','six',$col);
            $appeared = "r.{$temp}_imp";
        }
        if($counter=='@cc'){
            $appeared = "r.{$col}_opted";
        }
        if($counter=='@comp'){
            $appeared = "(r1.{$col}_total<0 or r1.{$col}_total<0 is null)";
            $join = "join ".DB_NAME.".nbse_ten_results r1 on f.nbse_app_id=r1.nbse_app_id";
        }
        $six = $subCode=='f.nbse_sixSubject' ? "and nullif(f.nbse_sixSubject,'') is not null" : '';
        $cl10[] = "
    select @cl10id+{$counter}+r.nbse_result_id as student_exam_id,{$subCode} as subject_code,r.{$col}_int as internal,r.{$col}_ext as external,r.{$col}_total as total,r.{$col}_grade as abs_grade,
    r.{$col}_relative_grade as rel_grade,case when f.nbse_course_session=2014 then f.nbse_course_session else substring(f.nbse_session,1,4) end as course_session,$appeared as appeared,$mathsPaper as paper
    from ".DB_NAME.".$table r join ".DB_NAME.".nbse_form16 f on r.nbse_app_id=f.nbse_app_id $join
    where f.nbse_appId_Disable='Enable' and length(f.nbse_session)=9 $six";
    }
}
$cl10 = implode("
    union all", $cl10);

$cl10 = "insert into student_marks (student_exam_id,subject_id,internal,external,total,abs_grade,rel_grade,appeared,paper_id)
select t.student_exam_id,s.id,t.internal,t.external,t.total,t.abs_grade,t.rel_grade,appeared,paper from ($cl10
) as t join subjects s on t.subject_code=s.subject_code and t.course_session=s.session_id and s.class_level_id=10";

$cl12 = [];
foreach(CL12 as $streamCode=>$stream){
    foreach($stream['exams'] as $examCode=>$exam){
        $join = '';
        if($examCode=='comp'){
            $join = "join ".DB_NAME.".{$stream['exams']['board']['table']} r1 on f.nbse_app_id=r1.nbse_app_id";
        }
        foreach($stream['subjects'] as $subject){
            $appeared = "1";
            if(in_array($examCode,['imp','cc'])){
                $appeared = "r.{$subject['col']}_{$exam['suffix']}";
            }
            
            if($examCode=='comp'){
                $appeared = "(r1.{$subject['total']}<0 or r1.{$subject['total']} is null)";
            }

            $additional = '';
            if($subject['col']=='nbse_additional_subject'){
                $additional = "and nullif(f.nbse_additional_subject,'') is not null";
            }
            $cl12[] = "
    select @cl12id+@{$stream['idcode']}+@$examCode+r.nbse_result_id as student_exam_id,s.id as subject_id,r.{$subject['internal']} as internal,r.{$subject['external']} as external,r.{$subject['total']} as total,$appeared as appeared
    from ".DB_NAME.".{$stream['ft']} f join ".DB_NAME.".{$exam['table']} r on f.nbse_app_id=r.nbse_app_id join ".PORTAL_DB.".subjects s on f.{$subject['col']}=s.subject_code and case when f.nbse_course_session=2014 then f.nbse_course_session else substring(f.nbse_session,1,4) end=s.session_id and s.stream_id='$streamCode' and s.class_level_id=12 $join
    where f.nbse_appId_Disable='Enable' and length(f.nbse_session)=9 and f.nbse_session>='2016-2017' $additional";
        }
    }
}
$cl12 = implode("
    union all", $cl12);
$cl12 = "insert into student_marks (student_exam_id,subject_id,internal,external,total,appeared)
select t.student_exam_id,t.subject_id,internal,external,total,appeared from($cl12
) as t";

$query = "$cl10;<br><br>$cl12;";

return $query;