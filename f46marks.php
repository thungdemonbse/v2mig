<?php

$streams = [
    'a'=>[
        'idcode'=>'arts',
        'ft'=>'nbse_form46arts',
        'subjects'=>[
            ['col'=>'nbse_compulsory_one','internal'=>'nbse_compulsory1_int','external'=>'nbse_compulsory1_ext','total'=>'nbse_compulsory1_total','opt'=>'nbse_compulsory_one_opted'],
            ['col'=>'nbse_elective_one','internal'=>'nbse_elective1_int','external'=>'nbse_elective1_ext','total'=>'nbse_elective1_total','opt'=>'nbse_elective_one_opted'],
            ['col'=>'nbse_elective_two','internal'=>'nbse_elective2_int','external'=>'nbse_elective2_ext','total'=>'nbse_elective2_total','opt'=>'nbse_elective_two_opted'],
            ['col'=>'nbse_elective_three','internal'=>'nbse_elective3_int','external'=>'nbse_elective3_ext','total'=>'nbse_elective3_total','opt'=>'nbse_elective_three_opted'],
            ['col'=>'nbse_elective_four','internal'=>'nbse_elective4_int','external'=>'nbse_elective4_ext','total'=>'nbse_elective4_total','opt'=>'nbse_elective_four_opted'],
            ['col'=>'nbse_additional_subject','internal'=>'nbse_additional_int','external'=>'nbse_additional_ext','total'=>'nbse_additional_total','opt'=>'nbse_additional_subject_opted'],
        ],
        'exams'=>[
            'board' => [
                'table'=>'nbse_12arts_results'
            ],
            'comp' => [
                'table'=>'nbse_compartment12_arts'
            ],
            'imp' => [
                'table'=>'nbse_improvement12_arts','suffix'=>'imp'
            ],
            'cc' => [
                'table'=>'nbse_compartmentboard12_arts','suffix'=>'opted'
            ]
        ]
    ],
    'c'=>[
        'idcode'=>'commerce',
        'ft'=>'nbse_form46commerce',
        'subjects'=>[
            ['col'=>'nbse_compulsory_one','internal'=>'nbse_compulsory1_int','external'=>'nbse_compulsory1_ext','total'=>'nbse_compulsory1_total','opt'=>'nbse_compulsory_one_opted'],
            ['col'=>'nbse_compulsory_two','internal'=>'nbse_compulsory2_int','external'=>'nbse_compulsory2_ext','total'=>'nbse_compulsory2_total','opt'=>'nbse_compulsory_two_opted'],
            ['col'=>'nbse_compulsory_three','internal'=>'nbse_compulsory3_int','external'=>'nbse_compulsory3_ext','total'=>'nbse_compulsory3_total','opt'=>'nbse_compulsory_three_opted'],
            ['col'=>'nbse_compulsory_four','internal'=>'nbse_compulsory4_int','external'=>'nbse_compulsory4_ext','total'=>'nbse_compulsory4_total','opt'=>'nbse_compulsory_four_opted'],
            ['col'=>'nbse_elective_one','internal'=>'nbse_elective1_int','external'=>'nbse_elective1_ext','total'=>'nbse_elective1_total','opt'=>'nbse_elective_one_opted'],
            ['col'=>'nbse_additional_subject','internal'=>'nbse_additional_int','external'=>'nbse_additional_ext','total'=>'nbse_additional_total','opt'=>'nbse_additional_subject_opted'],
        ],
        'exams'=>[
            'board' => [
                'table'=>'nbse_12commerce_results'
            ],
            'comp' => [
                'table'=>'nbse_compartment12_commerce'
            ],
            'imp' => [
                'table'=>'nbse_improvement12_commerce','suffix'=>'imp'
            ],
            'cc' => [
                'table'=>'nbse_compartmentboard12_commerce','suffix'=>'opted'
            ]
        ]
    ],
    's'=>[
        'idcode'=>'science',
        'ft'=>'nbse_form46science',
        'subjects'=>[
            ['col'=>'nbse_compulsory_one','internal'=>'nbse_compulsory1_int','external'=>'nbse_compulsory1_ext','total'=>'nbse_compulsory1_total','opt'=>'nbse_compulsory_one_opted'],
            ['col'=>'nbse_compulsory_two','internal'=>'nbse_compulsory2_int','external'=>'nbse_compulsory2_ext','total'=>'nbse_compulsory2_total','opt'=>'nbse_compulsory_two_opted'],
            ['col'=>'nbse_compulsory_three','internal'=>'nbse_compulsory3_int','external'=>'nbse_compulsory3_ext','total'=>'nbse_compulsory3_total','opt'=>'nbse_compulsory_three_opted'],
            ['col'=>'nbse_elective_one','internal'=>'nbse_elective1_int','external'=>'nbse_elective1_ext','total'=>'nbse_elective1_total','opt'=>'nbse_elective_one_opted'],
            ['col'=>'nbse_elective_two','internal'=>'nbse_elective2_int','external'=>'nbse_elective2_ext','total'=>'nbse_elective2_total','opt'=>'nbse_elective_two_opted'],
            ['col'=>'nbse_additional_subject','internal'=>'nbse_additional_int','external'=>'nbse_additional_ext','total'=>'nbse_additional_total','opt'=>'nbse_additional_subject_opted'],
        ],
        'exams'=>[
            'board' => [
                'table'=>'nbse_12science_results'
            ],
            'comp' => [
                'table'=>'nbse_compartment12_science'
            ],
            'imp' => [
                'table'=>'nbse_improvement12_science','suffix'=>'imp'
            ],
            'cc' => [
                'table'=>'nbse_compartmentboard12_science','suffix'=>'opted'
            ]
        ]
    ],
];
echo '<pre>';
$queries = [];
foreach($streams as $streamCode=>$stream){
    foreach($stream['exams'] as $examCode=>$exam){
        $join = '';
        if($examCode=='comp'){
            $join = "join `nbse`.{$stream['exams']['board']['table']} r1 on f.nbse_app_id=r1.nbse_app_id";
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
            $queries[] = "select @cl12id+@{$stream['idcode']}+@$examCode+r.nbse_result_id as student_exam_id,s.id as subject_id,r.{$subject['internal']} as internal,r.{$subject['external']} as external,r.{$subject['total']} as total,$appeared as appeared <br> from `nbse`.{$stream['ft']} f join `nbse`.{$exam['table']} r on f.nbse_app_id=r.nbse_app_id join `nbse`.subjects s on f.{$subject['col']}=s.subject_code and f.nbse_course_session=s.session_id and s.stream_id='$streamCode' and s.class_level_id=12 $join <br>where f.nbse_appId_Disable='Enable' and length(f.nbse_session)=9 $additional";
        }
    }
}
$query = implode("<br>union all<br>", $queries);
echo $query."<br><br>";
