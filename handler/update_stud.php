<?php
require_once('../object/stud.php');

$stud_id = isset($_POST['stud_id']) ? $_POST['stud_id'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$fname = isset($_POST['fname']) ? $_POST['fname'] : '';
$lname = isset($_POST['lname']) ? $_POST['lname'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$dobirth = isset($_POST['dobirth']) ? $_POST['dobirth'] : '';
$contactNo = isset($_POST['contactNo']) ? $_POST['contactNo'] : '';

$studData = array(
    "stud_id" => $stud_id,
    "email" => $email,
    "fname" => $fname,
    "lname" => $lname,
    "gender" => $gender,
    "dobirth" => $dobirth,
    "contactNo" => $contactNo
);

$student = new Student();
$ret = $student->updateStudentWithProcedure($studData);
echo $ret;
