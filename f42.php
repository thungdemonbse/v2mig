<?php

$streams = [
    'a'=>[
        'ft'=>'nbse_form42arts',
        'rt'=>'nbse_11arts_results',
        'ct'=>'nbse_compartment11_arts',
        'it'=>'nbse_improvement11_arts',
        'subjects'=>[
            ['col'=>'nbse_compulsory','rt'=>'nbse_compulsory1_total','imp'=>'nbse_compulsory_one_imp','pos'=>1],
            ['col'=>'nbse_elective_one','rt'=>'nbse_elective1_total','imp'=>'nbse_elective_one_imp','pos'=>1],
            ['col'=>'nbse_elective_two','rt'=>'nbse_elective2_total','imp'=>'nbse_elective_two_imp','pos'=>2],
            ['col'=>'nbse_elective_three','rt'=>'nbse_elective3_total','imp'=>'nbse_elective_three_imp','pos'=>3],
            ['col'=>'nbse_elective_four','rt'=>'nbse_elective4_total','imp'=>'nbse_elective_four_imp','pos'=>4],
            ['col'=>'nbse_additional_subject','rt'=>'nbse_additional_total','imp'=>'nbse_additional_subject_imp'],
        ]
    ],
    'c'=>[
        'ft'=>'nbse_form42commerce',
        'rt'=>'nbse_11commerce_results',
        'ct'=>'nbse_compartment11_commerce',
        'it'=>'nbse_improvement11_commerce',
        'subjects'=>[
            ['col'=>'nbse_compulsory_one','rt'=>'nbse_compulsory1_total','imp'=>'nbse_compulsory_one_imp','pos'=>1],
            ['col'=>'nbse_compulsory_two','rt'=>'nbse_compulsory2_total','imp'=>'nbse_compulsory_two_imp','pos'=>2],
            ['col'=>'nbse_compulsory_three','rt'=>'nbse_compulsory3_total','imp'=>'nbse_compulsory_three_imp','pos'=>3],
            ['col'=>'nbse_compulsory_four','rt'=>'nbse_compulsory4_total','imp'=>'nbse_compulsory_four_imp','pos'=>4],
            ['col'=>'nbse_elective_one','rt'=>'nbse_elective1_total','imp'=>'nbse_elective_one_imp','pos'=>1],
            ['col'=>'nbse_additional_subject','rt'=>'nbse_additional_total','imp'=>'nbse_additional_subject_imp'],
        ]
    ],
    's'=>[
        'ft'=>'nbse_form42science',
        'rt'=>'nbse_11science_results',
        'ct'=>'nbse_compartment11_science',
        'it'=>'nbse_improvement11_science',
        'subjects'=>[
            ['col'=>'nbse_compulsory','rt'=>'nbse_compulsory1_total','imp'=>'nbse_compulsory_one_imp','pos'=>1],
            ['col'=>'nbse_compulsoryOne','rt'=>'nbse_compulsory2_total','imp'=>'nbse_compulsory_two_imp','pos'=>2],
            ['col'=>'nbse_compulsoryTwo','rt'=>'nbse_compulsory3_total','imp'=>'nbse_compulsory_three_imp','pos'=>3],
            ['col'=>'nbse_elective_one','rt'=>'nbse_elective1_total','imp'=>'nbse_elective_one_imp','pos'=>1],
            ['col'=>'nbse_elective_two','rt'=>'nbse_elective2_total','imp'=>'nbse_elective_two_imp','pos'=>2],
            ['col'=>'nbse_additional_subject','rt'=>'nbse_additional_total','imp'=>'nbse_additional_subject_imp'],
        ]
    ],
];
$subjectCode='BIO';
$session='2025-2026';
echo '<pre>';
$queries = [];
foreach($streams as $id=>$stream){
    foreach($stream['subjects'] as $subject){
        $pos = isset($subject['pos'])?$subject['pos']:'null';
        $queries[] = "select concat('f42$id',f.nbse_app_id) as app_id,s.id as subject_id,$pos as pos <br>from `nbse`.{$stream['ft']} f join subjects s on f.{$subject['col']}=s.subject_code and substring(f.nbse_session,1,4)=s.session_id <br>where f.nbse_appId_Disable='Enable' and length(f.nbse_session)=9 and s.stream_id='$id' and s.class_level_id=11";
    }
}
$query = implode("<br>union all<br>", $queries);
echo $query."<br><br>";
