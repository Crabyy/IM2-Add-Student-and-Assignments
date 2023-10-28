<?php
require_once('../object/stud.php');

$email = isset($_POST['email']) ? $_POST['email'] : '';
$fname = isset($_POST['fname']) ? $_POST['fname'] : '';
$lname = isset($_POST['lname']) ? $_POST['lname'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$dobirth = isset($_POST['dobirth']) ? $_POST['dobirth'] : '';
$contactNo = isset($_POST['contactNo']) ? $_POST['contactNo'] : '';

$stud = array(
    "email" => $email,
    "fname" => $fname,
    "lname" => $lname,
    "gender" => $gender,
    "dobirth" => $dobirth,
    "contactNo" => $contactNo
);

$student = new Student();
$ret = $student->studInsert($stud);
echo $ret;