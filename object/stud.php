<?php

require_once ('../config/dbconfig.php');

class Student extends Database{

    private $dbconn;
    private $state;
    private $errMsg;

    public function __construct() {
        parent::__construct();
        $this->dbconn = $this->dbConn();
        $this->state = $this->dbState();
        $this->errMsg = $this->errMsg();
    }

    public function studInsert($stud) {
        $stmt = $this->dbconn->prepare("CALL InsertStudent(:email, :fname, :lname, :gender, :dobirth, :contactNo)");
        $stmt->bindParam(':email', $stud['email']);
        $stmt->bindParam(':fname', $stud['fname']);
        $stmt->bindParam(':lname', $stud['lname']);
        $stmt->bindParam(':gender', $stud['gender']);
        $stmt->bindParam(':dobirth', $stud['dobirth']);
        $stmt->bindParam(':contactNo', $stud['contactNo']);
        try {
            $stmt->execute();
            if ($stmt) {
                return true;
            }else {
                return false;
            }
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function addAss($assName) {
        $stmt = $this->dbconn->prepare("CALL InsertAss(:ass_name)");
        $stmt->bindParam(':ass_name', $assName['ass_name']);
        try {
            $stmt->execute();
            if ($stmt) {
                return true;
            }else {
                return false;
            }
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function assignAssignments($stud_id, $ass_ids) {
        try {
        $stmt = $this->dbconn->prepare("INSERT INTO stud_assignments (stud_id, ass_id) VALUES (:stud_id, :ass_id)");
        $stmt->bindParam(':stud_id', $stud_id);

        foreach ($ass_ids as $assignment_id) {
        // Check if the assignment is already assigned to the student
        $checkQuery = "SELECT COUNT(*) FROM stud_assignments WHERE stud_id = :stud_id AND ass_id = :assignment_id";
        $checkStmt = $this->dbconn->prepare($checkQuery);
        $checkStmt->bindParam(':stud_id', $stud_id);
        $checkStmt->bindParam(':assignment_id', $assignment_id);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        if ($count == 0) {
            // Assignment is not assigned to the student, so assign it
            $stmt->bindParam(':ass_id', $assignment_id);
            $stmt->execute();
        }
        }

        return true;
        } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
        }
        }

public function removeStudent($stud_id) {
    $stmtAssignments = $this->dbconn->prepare("DELETE FROM stud_assignments WHERE stud_id = :stud_id");
    $stmtAssignments->bindParam(':stud_id', $stud_id);

    $stmtStudent = $this->dbconn->prepare("DELETE FROM stud_info WHERE stud_id = :stud_id");
    $stmtStudent->bindParam(':stud_id', $stud_id);

    try {
        $this->dbconn->beginTransaction();
        $stmtAssignments->execute();
        $stmtStudent->execute();
        $this->dbconn->commit();
        return true;
    } catch (PDOException $e) {
        $this->dbconn->rollBack();
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Method to update student records using the stored procedure
public function updateStudentWithProcedure($studData) {
    $stmt = $this->dbconn->prepare("CALL UpdateStudent(:stud_id, :email, :fname, :lname, :gender, :dobirth, :contactNo)");
    $stmt->bindParam(':stud_id', $studData['stud_id']);
    $stmt->bindParam(':email', $studData['email']);
    $stmt->bindParam(':fname', $studData['fname']);
    $stmt->bindParam(':lname', $studData['lname']);
    $stmt->bindParam(':gender', $studData['gender']);
    $stmt->bindParam(':dobirth', $studData['dobirth']);
    $stmt->bindParam(':contactNo', $studData['contactNo']);

    try {
        $stmt->execute();
        return 'success';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return 'error';
    }
}

// Method to retrieve assignments for a specific student
public function getStudentAssignments($stud_id) {
    $stmt = $this->dbconn->prepare("SELECT sa.ass_id, sa.ass_name FROM stud_assignments sa
        INNER JOIN stud_info si ON sa.stud_id = si.stud_id
        WHERE sa.stud_id = :stud_id");
    $stmt->bindParam(':stud_id', $stud_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Method to update an assignment
public function updateAssignment($assignment_id, $newAssignmentName) {
    $stmt = $this->dbconn->prepare("UPDATE stud_assignments SET ass_name = :newAssignmentName WHERE ass_id = :assignment_id");
    $stmt->bindParam(':assignment_id', $assignment_id);
    $stmt->bindParam(':newAssignmentName', $newAssignmentName);
    return $stmt->execute();
}

// Method to remove an assignment
public function removeAssignment($assignment_id) {
    $stmt = $this->dbconn->prepare("DELETE FROM stud_assignments WHERE ass_id = :assignment_id");
    $stmt->bindParam(':assignment_id', $assignment_id);
    return $stmt->execute();
}

}