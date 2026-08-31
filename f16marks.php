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
$queries = [];
foreach($tables as $table=>$counter){
    foreach($cols as $subCode => $col){
        $appeared = "'1'";
        $join = '';
        // $paperSelect='p.id as paper_id';
        // $paperJoin = "left join `nbse`.subject_papers p on r.maths_paper=p.name and p.subject_code={$subCode} and p.class_level_id=10 and f.nbse_course_session=substring(p.session,1,4)";
        // if($counter=='@board'){
        //     $paperJoin = "left join `nbse`.subject_papers p on f.nbse_maths_paper=p.name and p.subject_code={$subCode} and p.class_level_id=10 and f.nbse_course_session=substring(p.session,1,4)";
        // }
        $mathsPaper = 'null';
        if($subCode=="'MA'"){
            $mathsPaper = "r.maths_paper";
            if($counter=='@board'){
                $mathsPaper = "f.nbse_maths_paper";
            }
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
            $join = "join `nbse`.nbse_ten_results r1 on f.nbse_app_id=r1.nbse_app_id";
        }
        $six = $subCode=='f.nbse_sixSubject' ? "and nullif(f.nbse_sixSubject,'') is not null" : '';
        $queries[] = "select @cl10id+{$counter}+r.nbse_result_id as student_exam_id,{$subCode} as subject_code,r.{$col}_int as internal,r.{$col}_ext as external,r.{$col}_total as total,r.{$col}_grade as abs_grade,r.{$col}_relative_grade as rel_grade,f.nbse_course_session as course_session,$appeared as appeared,$mathsPaper as paper<br>from `nbse`.$table r join `nbse`.nbse_form16 f on r.nbse_app_id=f.nbse_app_id $join <br>where f.nbse_appId_Disable='Enable' and length(f.nbse_session)=9 $six";
    }
}
$query = implode("<br>union all<br>", $queries);
?>
<button id="copyBtn" style="position:fixed;top:10px;right:10px;padding:8px 16px;cursor:pointer;">Copy all text</button>
<div id="content"><?php echo $query; ?></div>
<script>
document.getElementById('copyBtn').addEventListener('click', function () {
    var text = document.getElementById('content').innerText;
    navigator.clipboard.writeText(text).then(function () {
        var btn = document.getElementById('copyBtn');
        var original = btn.textContent;
        btn.textContent = 'Copied!';
        setTimeout(function () { btn.textContent = original; }, 1500);
    });
});
</script>