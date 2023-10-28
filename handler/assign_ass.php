<?php
require_once('../object/stud.php');

$stud_id = isset($_POST['stud_id']) ? $_POST['stud_id'] : '';
$ass_ids = isset($_POST['ass_ids']) ? $_POST['ass_ids'] : [];

$student = new Student();
$ret = $student->assignAssignments($stud_id, $ass_ids);
echo $ret;
