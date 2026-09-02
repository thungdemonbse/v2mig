<?php

return [
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