<?php

$query = "
ALTER TABLE student_sessions ADD INDEX idx_school_session (school_code, session_id);
ALTER TABLE school_sessions ADD INDEX idx_school_session (school_code, session_id);

update student_sessions ss join school_sessions s on ss.school_code=s.school_code and ss.session_id=s.session_id set ss.school_session_id=s.id;

ALTER TABLE `student_sessions` DROP INDEX `idx_school_session`;
ALTER TABLE `school_sessions` DROP INDEX `idx_school_session`;

update student_sessions ss join students s on ss.primary_id=s.primary_id set ss.student_id=s.id;
update student_subjects ss join student_sessions s on ss.app_id=s.app_id set ss.student_session_id=s.id;
update student_exams e join student_sessions s on e.app_id=s.app_id set e.student_session_id=s.id;
";

return $query;