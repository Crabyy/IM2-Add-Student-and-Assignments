<?php
require_once('../object/stud.php');

$stud_id = isset($_GET['stud_id']) ? $_GET['stud_id'] : '';

if (!empty($stud_id)) {
    $student = new Student();
    $assignments = $student->getStudentAssignments($stud_id);
    echo json_encode($assignments);
} else {
    echo json_encode([]);
}
?>
