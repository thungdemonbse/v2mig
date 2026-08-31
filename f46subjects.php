<?php

$streams = [
    'a'=>[
        'ft'=>'nbse_form46arts',
        'rt'=>'nbse_12arts_results',
        'ct'=>'nbse_compartment12_arts',
        'it'=>'nbse_improvement12_arts',
        'subjects'=>[
            ['col'=>'nbse_compulsory_one','rt'=>'nbse_compulsory1_total','imp'=>'nbse_compulsory_one_imp','pos'=>1],
            ['col'=>'nbse_elective_one','rt'=>'nbse_elective1_total','imp'=>'nbse_elective_one_imp','pos'=>1],
            ['col'=>'nbse_elective_two','rt'=>'nbse_elective2_total','imp'=>'nbse_elective_two_imp','pos'=>2],
            ['col'=>'nbse_elective_three','rt'=>'nbse_elective3_total','imp'=>'nbse_elective_three_imp','pos'=>3],
            ['col'=>'nbse_elective_four','rt'=>'nbse_elective4_total','imp'=>'nbse_elective_four_imp','pos'=>4],
            ['col'=>'nbse_additional_subject','rt'=>'nbse_additional_total','imp'=>'nbse_additional_subject_imp'],
        ]
    ],
    'c'=>[
        'ft'=>'nbse_form46commerce',
        'rt'=>'nbse_12commerce_results',
        'ct'=>'nbse_compartment12_commerce',
        'it'=>'nbse_improvement12_commerce',
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
        'ft'=>'nbse_form46science',
        'rt'=>'nbse_12science_results',
        'ct'=>'nbse_compartment12_science',
        'it'=>'nbse_improvement12_science',
        'subjects'=>[
            ['col'=>'nbse_compulsory_one','rt'=>'nbse_compulsory1_total','imp'=>'nbse_compulsory_one_imp','pos'=>1],
            ['col'=>'nbse_compulsory_two','rt'=>'nbse_compulsory2_total','imp'=>'nbse_compulsory_two_imp','pos'=>2],
            ['col'=>'nbse_compulsory_three','rt'=>'nbse_compulsory3_total','imp'=>'nbse_compulsory_three_imp','pos'=>3],
            ['col'=>'nbse_elective_one','rt'=>'nbse_elective1_total','imp'=>'nbse_elective_one_imp','pos'=>1],
            ['col'=>'nbse_elective_two','rt'=>'nbse_elective2_total','imp'=>'nbse_elective_two_imp','pos'=>2],
            ['col'=>'nbse_additional_subject','rt'=>'nbse_additional_total','imp'=>'nbse_additional_subject_imp'],
        ]
    ],
];
echo '<pre>';
$queries = [];
foreach($streams as $id=>$stream){
    foreach($stream['subjects'] as $subject){
        $pos = isset($subject['pos'])?$subject['pos']:'null';
        $queries[] = "select concat('f46$id',f.nbse_app_id) as app_id,s.id as subject_id,$pos as pos <br>from `nbse`.{$stream['ft']} f join subjects s on f.{$subject['col']}=s.subject_code and f.nbse_course_session=s.session_id <br>where f.nbse_appId_Disable='Enable' and length(f.nbse_session)=9 and s.stream_id='$id' and s.class_level_id=12";
    }
}
$query = implode("<br>union all<br>", $queries);
echo $query."<br><br>";
