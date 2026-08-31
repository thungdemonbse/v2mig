<?php

$streams = [
    'a'=>[
        'ft'=>'nbse_form46arts',
        'rt'=>'nbse_12arts_results',
        'ct'=>'nbse_compartment12_arts',
        'it'=>'nbse_improvement12_arts',
        'subjects'=>[
            ['col'=>'nbse_compulsory_one','rt'=>'nbse_compulsory1_total','imp'=>'nbse_compulsory_one_imp'],
            ['col'=>'nbse_elective_one','rt'=>'nbse_elective1_total','imp'=>'nbse_elective_one_imp'],
            ['col'=>'nbse_elective_two','rt'=>'nbse_elective2_total','imp'=>'nbse_elective_two_imp'],
            ['col'=>'nbse_elective_three','rt'=>'nbse_elective3_total','imp'=>'nbse_elective_three_imp'],
            ['col'=>'nbse_elective_four','rt'=>'nbse_elective4_total','imp'=>'nbse_elective_four_imp'],
            ['col'=>'nbse_additional_subject','rt'=>'nbse_additional_total','imp'=>'nbse_additional_subject_imp'],
        ]
    ],
    'c'=>[
        'ft'=>'nbse_form46commerce',
        'rt'=>'nbse_12commerce_results',
        'ct'=>'nbse_compartment12_commerce',
        'it'=>'nbse_improvement12_commerce',
        'subjects'=>[
            ['col'=>'nbse_compulsory_one','rt'=>'nbse_compulsory1_total','imp'=>'nbse_compulsory_one_imp'],
            ['col'=>'nbse_compulsory_two','rt'=>'nbse_compulsory2_total','imp'=>'nbse_compulsory_two_imp'],
            ['col'=>'nbse_compulsory_three','rt'=>'nbse_compulsory3_total','imp'=>'nbse_compulsory_three_imp'],
            ['col'=>'nbse_compulsory_four','rt'=>'nbse_compulsory4_total','imp'=>'nbse_compulsory_four_imp'],
            ['col'=>'nbse_elective_one','rt'=>'nbse_elective1_total','imp'=>'nbse_elective_one_imp'],
            ['col'=>'nbse_additional_subject','rt'=>'nbse_additional_total','imp'=>'nbse_additional_subject_imp'],
        ]
    ],
    's'=>[
        'ft'=>'nbse_form46science',
        'rt'=>'nbse_12science_results',
        'ct'=>'nbse_compartment12_science',
        'it'=>'nbse_improvement12_science',
        'subjects'=>[
            ['col'=>'nbse_compulsory_one','rt'=>'nbse_compulsory1_total','imp'=>'nbse_compulsory_one_imp'],
            ['col'=>'nbse_compulsory_two','rt'=>'nbse_compulsory2_total','imp'=>'nbse_compulsory_two_imp'],
            ['col'=>'nbse_compulsory_three','rt'=>'nbse_compulsory3_total','imp'=>'nbse_compulsory_three_imp'],
            ['col'=>'nbse_elective_one','rt'=>'nbse_elective1_total','imp'=>'nbse_elective_one_imp'],
            ['col'=>'nbse_elective_two','rt'=>'nbse_elective2_total','imp'=>'nbse_elective_two_imp'],
            ['col'=>'nbse_additional_subject','rt'=>'nbse_additional_total','imp'=>'nbse_additional_subject_imp'],
        ]
    ],
];
echo '<pre>';
$queries = [];
foreach($streams as $id=>$stream){
    $select = [];
    foreach($stream['subjects'] as $i=>$s){
        $select[] = $s['col'].' as sub'.($i+1);
    }
    $select = implode(',',$select);
    $queries[] = "select concat('f46$id',nbse_app_id) as app_id,nbse_reg_no,nbse_school_code,nbse_session,nbse_hslc_roll,$select <br>from {$stream['ft']}";
}
$query = implode("<br>union all<br>", $queries);
echo $query."<br><br>";

$queries = [];
foreach($streams as $id=>$stream){
    $select = [];
    foreach($stream['subjects'] as $i=>$s){
        $select[] = $s['rt'].' as sub'.($i+1).'_total';
    }
    $select = implode(',',$select);
    $queries[] = "select concat('f46$id',nbse_app_id) as app_id,nbse_results,$select <br>from {$stream['rt']}";
}
$query = implode("<br>union all<br>", $queries);
echo $query."<br><br>";
