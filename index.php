<?php

require_once 'common.php';

$primary = "insert into students (primary_id,name,father_name,mother_name,gender_id,dob,id_mark,community_id,cwd,created_at,updated_at)
SELECT
    nbse_primary_id,
    nbse_fname,
    nbse_father_name,
    nbse_mother_name,
    (case when nbse_gender in ('M','Male') then 'M' else 'F' end) as gender_id,
    nbse_dob,
    nullif(nbse_identification_mark,''),
    nbse_community as community_id,
    (case when cwd in ('Y','Yes') then 1 else 0 end) as cwd,
    created_date,
    updated_date
FROM " . DB_NAME . ".nbse_form13primary as p
WHERE  p.nbse_appId_Disable = 'Enable' and nullif(p.nbse_primary_id,'') is not null and nullif(nbse_community,'') is not null and p.nbse_fname is not null;";

$forms = require 'forms.php';
$centres = require 'centers.php';
$exams = require 'exams.php';
$results = require 'results.php';
$subjects = require 'subject.php'; 
echo "<pre>";
// echo $primary;
// echo "<br><br>";
// echo $forms;
// echo "<br><br>";
// echo $exams;
// echo "<br><br>";
// echo $centres;
// echo "<br><br>";
// echo $results;
echo "<br><br>";
echo $subjects;
