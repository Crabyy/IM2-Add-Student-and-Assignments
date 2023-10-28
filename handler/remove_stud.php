<?php
require_once('../object/stud.php');

$stud_id = isset($_GET['id']) ? $_GET['id'] : '';

if (!empty($stud_id)) {
    $student = new Student();
    $ret = $student->removeStudent($stud_id);
    echo $ret;
}
