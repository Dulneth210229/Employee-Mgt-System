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
    <form id="employeeForm">
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

        <button type="submit">Add Employee</button>
    </form>

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
                <th>Action</th> <!-- New Action Column -->
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
                        // Action Column
                        data: null,
                        render: function(data, type, row) {
                            // Create Delete and Update buttons
                            return `
                                <button class="btn-delete" data-id="${data.id}">Delete</button>
                                <button class="btn-update" data-id="${data.id}">Update</button>
                            `;
                        }
                    }
                ]
            });

            // Handle form submission via AJAX
            $('#employeeForm').on('submit', function(e) {
                e.preventDefault();

                // Get values manually
                let name = $('#name').val();
                let birth = $('#birth').val();
                let gender = $('#gender').val();

                // Create data object with key-value pairs
                let data = {
                    name: name,
                    birth: birth,
                    gender: gender
                };

                // Send AJAX request
                $.ajax({
                    url: 'add_employee.php',
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        alert(response); // Display response from the backend
                        dataTable.ajax.reload(); // Refresh DataTable
                        $('#employeeForm')[0].reset(); // Clear the form
                    }
                });
            });

            // Handle Delete Button Click
            $('#employeeTable').on('click', '.btn-delete', function() {
                let employeeId = $(this).data('id'); // Get the employee ID from the button's data-id attribute

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

            // Handle Update Button Click
            $('#employeeTable').on('click', '.btn-update', function() {
                let employeeId = $(this).data('id'); // Get the employee ID from the button's data-id attribute
                alert('Update functionality for employee ID: ' + employeeId);
                // You can implement the update logic here (e.g., open a modal with a form to update the employee)
            });
        });
    </script>
</body>
</html>