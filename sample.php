<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <h1>Employee Management System</h1>

    <!-- Add Employee Form -->
    <form id="employeeForm" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="birth">Birthdate:</label>
        <input type="date" id="birth" name="birth" required><br><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select><br><br>

        <label for="resume">Resume (PDF only):</label>
        <input type="file" id="resume" name="resume" accept=".pdf" required><br><br>

        <button type="submit" id="submit-content">Add Employee</button>
    </form>

    <!-- Update Employee Modal -->
    <div id="updateModal" style="display:none;">
        <h2>Update Employee</h2>
        <form id="updateForm" enctype="multipart/form-data">
            <input type="hidden" id="updateId" name="id">
            <label for="updateName">Name:</label>
            <input type="text" id="updateName" name="name" required><br><br>

            <label for="updateBirth">Birthdate:</label>
            <input type="date" id="updateBirth" name="birth" required><br><br>

            <label for="updateGender">Gender:</label>
            <select id="updateGender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select><br><br>

            <label for="updateResume">Resume (PDF only):</label>
            <input type="file" id="updateResume" name="resume" accept=".pdf"><br><br>

            <button type="submit" id="update-employee">Update Employee</button>
            <button type="button" id="closeModal">Close</button>
        </form>
    </div>

    <hr>

    <!-- DataTable to display employees -->
    <table id="employeeTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Birthdate</th>
                <th>Gender</th>
                <th>Resume</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be loaded here via AJAX -->
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var dataTable = $('#employeeTable').DataTable({
                ajax: {
                    url: 'fetch_employees.php',
                    dataSrc: ''
                },
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'age' },
                    { data: 'birth' },
                    { data: 'gender' },
                    {
                        data: 'resume',
                        render: function(data, type, row) {
                            if (data) {
                                return `<a href="${data}" target="_blank">View Resume</a>`;
                            } else {
                                return 'No resume uploaded';
                            }
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn-delete" data-id="${data.id}">Delete</button>
                                <button class="btn-update" data-id="${data.id}">Update</button>
                            `;
                        }
                    }
                ]
            });

            // Handle Add Employee Form Submission
            $("#employeeForm").on('submit', function(e) {
                e.preventDefault();

                // Create a FormData object
                let formData = new FormData(this);

                // Send AJAX request
                $.ajax({
                    url: 'add_employee_with_file.php',
                    method: 'POST',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting the content type
                    success: function(response) {
                        alert(response); // Display response from the backend
                        dataTable.ajax.reload(); // Refresh DataTable
                        $("#employeeForm")[0].reset(); // Clear the form
                    },
                    error: function(xhr, status, error) {
                        console.error('Error adding employee:', error);
                    }
                });
            });

            // Handle Update Button Click
            $('#employeeTable').on('click', '.btn-update', function(e) {
                e.preventDefault();
                const empId = $(this).data('id');

                // Fetch employee data for the selected ID
                $.ajax({
                    url: 'fetch_employee_byid.php',
                    method: 'GET',
                    data: { id: empId },
                    success: function(response) {
                        // Populate the update form with the fetched data
                        $('#updateId').val(response.id);
                        $('#updateName').val(response.name);
                        $('#updateBirth').val(response.birth);
                        $('#updateGender').val(response.gender);

                        // Show the update modal
                        $('#updateModal').show();
                    }
                });
            });

            // Handle Update Employee Form Submission
            $('#updateForm').on('submit', function(e) {
                e.preventDefault();

                // Create a FormData object
                let formData = new FormData(this);

                // Send AJAX request
                $.ajax({
                    url: 'update_employee-with_file.php',
                    method: 'POST',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting the content type
                    success: function(response) {
                        alert(response); // Display response from the backend
                        dataTable.ajax.reload(); // Refresh DataTable
                        $('#updateModal').hide(); // Hide the modal
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating employee:', error);
                    }
                });
            });

            // Handle Delete Button Click
            $('#employeeTable').on('click', '.btn-delete', function() {
                let employeeId = $(this).data('id'); // Get the employee ID from the data-id attribute
                if (confirm('Are you sure you want to delete this employee?')) {
                    $.ajax({
                        url: 'delete_employee.php',
                        method: 'POST',
                        data: { id: employeeId },
                        success: function(response) {
                            alert(response); // Display response from the backend
                            dataTable.ajax.reload(); // Refresh DataTable
                        }
                    });
                }
            });

            // Handle Close Modal Button Click
            $('#closeModal').on('click', function() {
                $('#updateModal').hide(); // Hide the modal
            });
        });
    </script>
</body>
</html>