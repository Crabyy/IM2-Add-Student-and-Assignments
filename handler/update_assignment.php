<?php
require_once('../object/stud.php');

$assignment_id = isset($_POST['assignment_id']) ? $_POST['assignment_id'] : '';
$newAssignmentName = isset($_POST['new_assignment_name']) ? $_POST['new_assignment_name'] : '';

if (!empty($assignment_id) && !empty($newAssignmentName)) {
    $student = new Student();
    $success = $student->updateAssignment($assignment_id, $newAssignmentName);
    echo $success ? 'success' : 'error';
} else {
    echo 'error';
}
?>
