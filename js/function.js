
    // JavaScript to populate modal fields with current data
    $(document).on('click', '.updateStudentButton', function () {
        var studId = $(this).data('id');
        var email = $(this).data('email');
        var fname = $(this).data('fname');
        var lname = $(this).data('lname');
        var gender = $(this).data('gender');
        var dobirth = $(this).data('dobirth');
        var contactNo = $(this).data('contactno');

        $('#editStudId').val(studId);
        $('#editEmail').val(email);
        $('#editFname').val(fname);
        $('#editLname').val(lname);
        $('#editGender').val(gender);
        $('#editDobirth').val(dobirth);
        $('#editContactNo').val(contactNo);
    });


    $(document).ready(function () {
        // Add Student
        $("#studentForm").submit(function (event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "handler/stud_save.php",
                data: $(this).serialize(),
                success: function (response) {
                    alert(response);
                    location.reload();
                }
            });
        });

        // Add Assignment
        $("#addAssignmentForm").submit(function (event) {
            event.preventDefault();
            var ass_name = $("#ass_name").val();
            $.ajax({
                type: "POST",
                url: "handler/add_ass.php",
                data: { ass_name: ass_name },
                success: function (response) {
                    alert(response);
                    location.reload();
                }
            });
        });

        $('#ass_ids').select2();

        // Assign Assignments
        $("#assignAssignmentForm").submit(function (event) {
        event.preventDefault();
        var stud_id = $("#stud_id").val();
        var ass_ids = $("#ass_ids").val(); 
    
        $.ajax({
            type: "POST",
            url: "handler/assign_ass.php",
            data: { stud_id: stud_id, ass_ids: ass_ids },
            success: function (response) {
                alert(response);
                location.reload();
            }
        });
    });
        // Update Student
        $("#updateStudentForm").submit(function (event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "handler/update_stud.php",
                data: $(this).serialize(),
                success: function (response) {
                    alert(response);
                    location.reload();
                }
            });
        });

        // Remove Student
        $(".studRemove").click(function (event) {
            event.preventDefault();
            var stud_id = $(this).data('id');
            if (confirm("Are you sure you want to remove this student?")) {
                $.ajax({
                    type: "GET",
                    url: "handler/remove_stud.php?id=" + stud_id,
                    success: function (response) {
                        alert(response);
                        location.reload();
                    }
                });
            }

            
        }); 
        
    });