<?php

require_once 'common.php';

$cl10 = [
    [2014,2016],
    [2016,2019],
    [2019,2024],
    [2024,2026]
];
$inserts = [];
foreach($cl10 as $years) {
    $year = $years[0]+1;
    while($year < $years[1]) {
        $inserts[] = "SELECT
    `nbse_subject_code` as subject_code,
    `nbse_subject_name` as name,
    case when `nbse_int_min` REGEXP '^[0-9]+$' then nbse_int_min end as int_pass_mark,
    case when `nbse_int_max` REGEXP '^[0-9]+$' then nbse_int_max end as int_full_mark,
    case when `nbse_ext_min` REGEXP '^[0-9]+$' then nbse_ext_min end as ext_pass_mark,
    case when `nbse_ext_max` REGEXP '^[0-9]+$' then nbse_ext_max end as ext_full_mark,
    case when nbse_sixSubject='Y' then 'six' when nbse_secondLanguage='Y' then 'second' else 'comp' end as subject_type,
    {$year} as session_id,
    0 as mil,
    10 as class_level_id,
    null as stream_id
FROM ".DB_NAME.".`nbse_subjects` where nbse_subject_code not in ('MAA','MAB') and nbse_course_session={$years[0]}";
        $year++;
    }
}
$inserts = implode("<br>union all<br>", $inserts);
$cl10filler = "insert into `subjects`(
    `subject_code`,`name`,`int_pass_mark`,`int_full_mark`,`ext_pass_mark`,`ext_full_mark`,`subject_type`,`session_id`,`mil`,`class_level_id`,`stream_id`
)
$inserts";

$cl12 = [
    [2014,2016],
    [2016,2019],
    [2019,2021],
    [2021,2024],
    [2024,2027]
];
$inserts = [];
foreach($cl12 as $years) {
    $year = $years[0]+1;
    while($year < $years[1]) {
        $inserts[] = "SELECT
    nbse_subjects_twelve.`nbse_subject_code` as subject_code,
    `nbse_subject_name` as name,
    case when `nbse_int_min` REGEXP '^[0-9]+$' then nbse_int_min end as int_pass_mark,
    case when `nbse_int_max` REGEXP '^[0-9]+$' then nbse_int_max end as int_full_mark,
    case when `nbse_ext_min` REGEXP '^[0-9]+$' then nbse_ext_min end as ext_pass_mark,
    case when `nbse_ext_max` REGEXP '^[0-9]+$' then nbse_ext_max end as ext_full_mark,
    case when nbse_subjects_twelve_data.nbse_compulsory='Y' then 'comp' else 'elective' end as subject_type,
    {$year} as session_id,
    case when nbse_mil='Y' then 1 else 0 end as mil,
    12 as class_level_id,
    nbse_stream as stream_id
FROM ".DB_NAME.".`nbse_subjects_twelve` left join ".DB_NAME.".nbse_subjects_twelve_data on nbse_subjects_twelve.nbse_subject_code=nbse_subjects_twelve_data.nbse_subject_code 
where nbse_course_session={$years[0]}";
        $year++;
    }
}
$inserts = implode("<br>union all<br>", $inserts);
$cl12filler = "insert into `subjects`(
    `subject_code`,`name`,`int_pass_mark`,`int_full_mark`,`ext_pass_mark`,`ext_full_mark`,`subject_type`,`session_id`,`mil`,`class_level_id`,`stream_id`
)
$inserts";

$insert = "INSERT INTO `subjects`(
    `id`,`subject_code`,`name`,`int_pass_mark`,`int_full_mark`,`ext_pass_mark`,`ext_full_mark`,`subject_type`,`session_id`,`mil`,`class_level_id`,`stream_id`
)";

$query = "$insert
SELECT 
    (10000000+`nbse_subject_id`) as id, 
    `nbse_subject_code` as subject_code, 
    `nbse_subject_name` as name,
    case when `nbse_int_min` REGEXP '^[0-9]+$' then nbse_int_min end as int_pass_mark,
    case when `nbse_int_max` REGEXP '^[0-9]+$' then nbse_int_max end as int_full_mark,
    case when `nbse_ext_min` REGEXP '^[0-9]+$' then nbse_ext_min end as ext_pass_mark,
    case when `nbse_ext_max` REGEXP '^[0-9]+$' then nbse_ext_max end as ext_full_mark,
    case when nbse_subject_cat='six_sub' then 'six' when nbse_subject_cat='sec_lang' then 'second' else 'comp' end as subject_type,
    substring(`nbse_session`,1,4) as session_id,
    0 as mil,
    9 as class_level_id,
    null as stream_id
FROM ".DB_NAME.".`nbse_subjects_nine`;

$insert
SELECT
    (20000000+`nbse_subject_id`) as id,
    `nbse_subject_code` as subject_code,
    `nbse_subject_name` as name,
    case when `nbse_int_min` REGEXP '^[0-9]+$' then nbse_int_min end as int_pass_mark,
    case when `nbse_int_max` REGEXP '^[0-9]+$' then nbse_int_max end as int_full_mark,
    case when `nbse_ext_min` REGEXP '^[0-9]+$' then nbse_ext_min end as ext_pass_mark,
    case when `nbse_ext_max` REGEXP '^[0-9]+$' then nbse_ext_max end as ext_full_mark,
    case when nbse_sixSubject='Y' then 'six' when nbse_secondLanguage='Y' then 'second' else 'comp' end as subject_type,
    `nbse_course_session` as session_id,
    0 as mil,
    10 as class_level_id,
    null as stream_id
FROM ".DB_NAME.".`nbse_subjects` where nbse_subject_code not in ('MAA','MAB');

$cl10filler;

$insert
 SELECT
    rpad(concat(3,field(nbse_stream,'A','C','S')),8,'0')+nbse_subjects_eleven.`nbse_subject_id` as id,
    nbse_subjects_eleven.`nbse_subject_code`,
    `nbse_subject_name` as name,
    case when `nbse_int_min` REGEXP '^[0-9]+$' then nbse_int_min end as int_pass_mark,
    case when `nbse_int_max` REGEXP '^[0-9]+$' then nbse_int_max end as int_full_mark,
    case when `nbse_ext_min` REGEXP '^[0-9]+$' then nbse_ext_min end as ext_pass_mark,
    case when `nbse_ext_max` REGEXP '^[0-9]+$' then nbse_ext_max end as ext_full_mark,
    case when nbse_subjects_eleven_data.nbse_compulsory='Y' then 'comp' else 'elective' end as subject_type,
    substring(`nbse_session`,1,4) as session_id,
    case when nbse_mil='Y' then 1 else 0 end as mil,
    11 as class_level_id,
    nbse_stream as stream_id
FROM ".DB_NAME.".`nbse_subjects_eleven` left join ".DB_NAME.".nbse_subjects_eleven_data on nbse_subjects_eleven.nbse_subject_code=nbse_subjects_eleven_data.nbse_subject_code;

$insert
 SELECT
    rpad(concat(4,field(nbse_stream,'A','C','S')),8,'0')+nbse_subjects_twelve.`nbse_subject_id` as id,
    nbse_subjects_twelve.`nbse_subject_code`,
    `nbse_subject_name` as name,
    case when `nbse_int_min` REGEXP '^[0-9]+$' then nbse_int_min end as int_pass_mark,
    case when `nbse_int_max` REGEXP '^[0-9]+$' then nbse_int_max end as int_full_mark,
    case when `nbse_ext_min` REGEXP '^[0-9]+$' then nbse_ext_min end as ext_pass_mark,
    case when `nbse_ext_max` REGEXP '^[0-9]+$' then nbse_ext_max end as ext_full_mark,
    case when nbse_subjects_twelve_data.nbse_compulsory='Y' then 'comp' else 'elective' end as subject_type,
    `nbse_course_session` as session_id,
    case when nbse_mil='Y' then 1 else 0 end as mil,
    12 as class_level_id,
    nbse_stream as stream_id
FROM ".DB_NAME.".`nbse_subjects_twelve` left join ".DB_NAME.".nbse_subjects_twelve_data on nbse_subjects_twelve.nbse_subject_code=nbse_subjects_twelve_data.nbse_subject_code;

$cl12filler;";

return $query;