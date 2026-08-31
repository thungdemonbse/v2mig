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
$subjectCode='BIO';
$session='2025-2026';
echo '<pre>';
foreach($streams as $stream){
    $wheres = [];
    foreach($stream['subjects'] as $subject){
        $wheres[] = "(r.{$subject['rt']}<0 and f.{$subject['col']}='$subjectCode')";
    }
    $wheres = implode(' or <br>',$wheres);
    $query = "select f.nbse_hsslc_roll from 
    nbsemis_sync.{$stream['ft']} f join nbsemis_sync.{$stream['rt']} r on f.nbse_app_id=r.nbse_app_id join nbsemis_sync.{$stream['ct']} c on f.nbse_app_id=c.nbse_app_id 
    where f.nbse_session='$session' and ($wheres)";
    
    $wheres = [];
    foreach($stream['subjects'] as $subject){
        $wheres[] = "(i.{$subject['imp']}=1 and f.{$subject['col']}='$subjectCode')";
    }
    $wheres = implode(' or <br>',$wheres);
    $impQuery = "select f.nbse_hsslc_roll from 
    nbsemis_sync.{$stream['ft']} f join nbsemis_sync.{$stream['rt']} r on f.nbse_app_id=r.nbse_app_id join nbsemis_sync.{$stream['it']} i on f.nbse_app_id=i.nbse_app_id 
    where f.nbse_session='$session' and ($wheres)";
    $query = $query."<br>union all<br>".$impQuery;
    echo $query."<br><br>";
}
