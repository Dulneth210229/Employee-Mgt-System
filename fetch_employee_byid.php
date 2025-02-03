<?php 
    include('config.php');
    header('Content-Type: application/json');

    if(isset($_GET['id'])){

        $id = $_GET['id'];

        //Fetch the employee data fom the database
        $sql = "SELECT * FROM emp_table WHERE id = $id";

        $result = mysqli_query($conn, $sql);

        if($result && mysqli_num_rows($result) > 0){
            $employee = mysqli_fetch_assoc($result);
            echo json_encode($employee);
        }else{
            echo json_encode(['error' => 'Employee Not found']);
        }

    }else{
        echo "Invalid request";
    }

?>