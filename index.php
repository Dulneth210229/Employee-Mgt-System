<?php
?>
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

    <!--Add Employee Form-->

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

        <button type="submit" id="submit-content">Add Employee</button>
    </form>
     <!-- Update Employee Modal -->
     <div id="updateModal" style="display:none;">
        <h2>Update Employee</h2>
        <form id="updateForm">
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

            <button type="submit">Update Employee</button>
            <button type="button" id="closeModal">Close</button>
        </form>
    </div>

    <hr>
    
    <!--Data table to display employees-->
    <table id="employeeTable" class="display" style="width:100%">
        <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Birthdate</th>
            <th>Gender</th>
            <th>Action</th>
        </thead>
        <tbody>
            <!--Data will be loaded here via AJAX-->
        </tbody>
    </table>

     

    <script>
        $(document).ready(function(){

            //!Initialize DataTable
            var dataTable = $('#employeeTable').DataTable({
                ajax: {
                    url: 'fetch_employees.php',
                    dataSrc: ''
                },
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'age'},
                    {data: 'birth'},
                    {data: 'gender'},
                    { data: null,
                        render: function(data, type, row){
                            //Create Delete and Update buttons
                           return `<button class="btn-delete" data-id="${data.id}">Delete</button>
                           <button class="btn-update" data-id="${data.id}">Update</button>
                           `    
                        }
                    }
                ]
            });

            //Handle update function
            // $("#employeeTable").on('click', '.btn-confirm', function(e){
            //     e.preventDefault();
            //     let employeeId = $(this).attr('data-id'); //Get the employee ID from the button's data-id attribute 

            //     $.ajax({
            //         url: 'update_employee.php',
            //         method: 'POST',
            //         data: {id : employeeId},
            //         success: function(response){
            //             $('#name').val(response.id);
            //             $('#birth').val(response.birth);
            //             $('#gender').val(response.gender);
            //         }
            //     })

            // })


            //Handle delete function
            $("#employeeTable").on('click', '.btn-delete', function(){
                let employeeId = $(this).data('id'); //Get the employee ID from the button's data-id attribute

                if(confirm('Are you sure you want to delete this employee?')){
                    $.ajax({
                        url : 'delete_employee.php',
                        method : 'POST',
                        data : { id : employeeId},
                        success: function(response){
                            alert(response); //display response as an alert
                            dataTable.ajax.reload()// reload the table after delete
                        }
                    })
                }
            })

            //Handle update function
            $('#employeeTable').on('click', '.btn-update', function(e) {
                e.preventDefault();
                const empId = $(this).data('id');

                $.ajax({
                    url : 'fetch_employee_byid.php',
                    method : 'GET',
                    data : {id : empId},
                    success: function(response){
                        console.log(response);
                        //populate the update form with the fetched data
                        $('#updateId').val(response.id);
                        $('#updateName').val(response.name);
                        $('#updateBirth').val(response.birth);
                        $('#updateGender').val(response.gender);

                        //show the update modal
                        $('#updateModal').show()
                        //close the addEmployee modal
                        $('#employeeForm').remove();

                    }
                })

               
            })



            //Handle form submission via ajax
            $("#employeeForm").on('submit', function(e){
                e.preventDefault();

                //Get values manually
                let name = $('#name').val();
                let birth = $('#birth').val();
                let gender = $('#gender').val();

                //create data object with key value pairs
                let data = {
                    name: name,
                    birth: birth,
                    gender: gender,
                }


                $.ajax({
                    url: 'add_employee.php',
                    method: 'POST',
                    data: data,
                    success: function(response){
                        alert(response); //get the response from the backend and display the response as an alert
                        dataTable.ajax.reload(); //refresh the data table
                        $("employeeForm").reset();
                    }
                })
            })
        })


    </script>

</body>
</html>