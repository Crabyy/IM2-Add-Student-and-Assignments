<?php
require_once('../object/stud.php');

$assignment_id = isset($_POST['assignment_id']) ? $_POST['assignment_id'] : '';

if (!empty($assignment_id)) {
    $student = new Student();
    $success = $student->removeAssignment($assignment_id);
    echo $success ? 'success' : 'error';
} else {
    echo 'error';
}
?>
