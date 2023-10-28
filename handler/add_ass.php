<?php
    require_once('../object/stud.php');

    $ass_name = isset($_POST['ass_name']) ? $_POST['ass_name'] : '';

    $assName = array(
        "ass_name" => $ass_name
    );

    $student = new Student();
    $ret = $student->addAss($assName);
    echo $ret;