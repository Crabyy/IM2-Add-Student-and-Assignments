<?php
require_once('config/dbconfig.php');

$database = new Database();

if ($database->dbState()) {
    $conn = $database->dbConn();

    $query = "SELECT * FROM stud_info";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    echo "Database connection failed: " . $database->errMsg();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <title>Student Information Form</title>
</head>
<body>
<div class="container">
    <h1>Student Information Form</h1>
    <form action="handler/stud_save.php" method="POST" id="studentForm">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="contactNo">Contact No.:</label>
                    <input type="number" name="contactNo" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input type="text" name="fname" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input type="text" name="lname" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select name="gender" class="form-control" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="dobirth">Date of Birth:</label>
                    <input type="date" name="dobirth" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" id="submitStudent">Submit Student</button>
        </div>
    </form>

        <div class="row">
        <div class="col-md-6">
        <h1>Add Assignments</h1>
        <form id="addAssignmentForm" action="handler/add_ass.php" method="POST">
            <div class="form-group">
                <label for="ass_name">Assignment Name:</label>
                <input type="text" name="ass_name" id="ass_name" class="form-control" required>
            </div>

            <input type="submit" class="btn btn-primary" value="Add Assignment" id="addAssignment">
        </form>
        </div>

        <div class="col-md-6">
    <h1>Assign Assignments</h1>
    <form action="handler/assign_ass.php" method="POST" id="assignAssignmentForm">
        <div class="form-group">
            <label for="stud_id">Select Student:</label>
            <select name="stud_id" id="stud_id" class="form-control" required>
                <?php
                foreach ($students as $student) {
                    echo "<option value='" . $student['stud_id'] . "'>" . $student['fname'] . " " . $student['lname'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
    <label for="ass_ids[]">Assignments:</label>
    <select name="ass_ids[]" id="ass_ids" class="form-control" multiple required>
        <?php
        $query = "SELECT * FROM stud_ass";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($assignments as $assignment) {
            echo "<option value='" . $assignment['ass_id'] . "'>" . $assignment['ass_name'] . "</option>";
        }
        ?>
    </select>
</div>



        <input type="submit" class="btn btn-primary" value="Assign Assignments" id="assAssignment"><br><br>
    </form>
</div>

    </div>
    </div>

<div style="max-width: 80rem; margin: 0 auto; overflow-x: auto;">
<table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Student ID</th>
                <th scope="col">Email</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Gender</th>
                <th scope="col">Date of Birth</th>
                <th scope="col">Contact No.</th>
                <th scope="col">Assignment Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (isset($students) && is_array($students)) {
            foreach ($students as $student) {
                echo "<tr>";
                    echo "<td>" . $student['stud_id'] . "</td>";
                    echo "<td>" . $student['email'] . "</td>";
                    echo "<td>" . $student['fname'] . "</td>";
                    echo "<td>" . $student['lname'] . "</td>";
                    echo "<td>" . $student['gender'] . "</td>";
                    echo "<td>" . $student['dobirth'] . "</td>";
                    echo "<td>" . $student['contactNo'] . "</td>";
                    echo "<td>";
                    $query = "SELECT ass_name FROM stud_ass INNER JOIN stud_assignments ON stud_ass.ass_id = stud_assignments.ass_id WHERE stud_assignments.stud_id = :stud_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':stud_id', $student['stud_id']);
            $stmt->execute();
            $assignedAssignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($assignedAssignments as $assignment) {
                echo $assignment['ass_name'] . "<br>";
            }
            echo "</td>";
                    echo "<td>";
                    echo "<a href='#editStudentModal' data-toggle='modal'
                    data-id='" . $student['stud_id'] . "'
                    data-email='" . $student['email'] . "'
                    data-fname='" . $student['fname'] . "'
                    data-lname='" . $student['lname'] . "'
                    data-gender='" . $student['gender'] . "'
                    data-dobirth='" . $student['dobirth'] . "'
                    data-contactNo='" . $student['contactNo'] . "'
                    class='btn btn-success updateStudentButton'>Update</a>
                 
                    ";

                    echo " | ";
                    echo "<a href='#' data-id='" . $student['stud_id'] . "' class='btn btn-danger studRemove'>Remove</a>";
                    echo "</td>";
                    echo "</tr>";
            }
        }
        ?>
        </tbody>    
    </table>
    </div>


    <div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Update Student Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="handler/update_stud.php" method="POST" id="updateStudentForm">
                    <input type="hidden" name="stud_id" id="editStudId">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="editEmail" required><br><br>

                    <label for="fname">First Name:</label>
                    <input type="text" name="fname" id="editFname" required><br><br>

                    <label for="lname">Last Name:</label>
                    <input type="text" name="lname" id="editLname" required><br><br>

                    <label for="gender">Gender:</label>
                    <select name="gender" id="editGender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select><br><br>

                    <label for="dobirth">Date of Birth:</label>
                    <input type="date" name="dobirth" id="editDobirth" required><br><br>

                    <label for="contactNo">Contact No.:</label>
                    <input type="number" name="contactNo" id="editContactNo" required><br><br>

                    <input type="submit" class="btn btn-success" value="Update">
                </form>
            </div>
        </div>
    </div>
</div>

<script src="js/function.js"></script>

</body>
</html>