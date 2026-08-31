<?php

require_once 'common.php';

$exams = [
    8=>[
        'board'=>2019
    ],
    9=>[
        'board'=>2016
    ],
    10=>[
        'board'=>2016,
        'compartment'=>2016,
        'compartment_compartment'=>2022,
        'enhancement'=>2022,
    ],
    11=>[
        'board'=>2016
    ],
    12=>[
        'board'=>2016,
        'compartment'=>2016,
        'compartment_compartment'=>2022,
        'enhancement'=>2022,
    ]
];
$query = "insert into exams (name,session_id,exam_type_id,class_level_id) values ";
$year = 2016;
$endYear = date('Y')-1;
while($year <= $endYear){
    foreach($exams as $classLevelId=>$examTypes){
        foreach($examTypes as $examType=>$examYear){
            if(in_array($classLevelId,[10,12])){
                $examName = $classLevelId == 10 ? 'HSLC' : 'HSSLC';
                $examName = "$examName $examType $year";
            }else{
                $examName = "Board Exam $year";
            }
            if($year >= $examYear){
                $query .= "<br>('$examName','$year','$examType','$classLevelId'),";
            }
        }
        
    }
    $year++;
}
$query = rtrim($query,',').';';
return $query;