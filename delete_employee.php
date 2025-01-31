<?php
    include('config.php');

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        // Get the employee ID
        $id = $_POST['id'];

        // $id = "2";

        if(!$id){
            echo "Invalid User ID";
            return ;
        }

        $sql = "DELETE FROM emp_table WHERE id = $id";

        if(mysqli_query($conn, $sql)){
            echo "Employee Removed successfully";

        }else{
            echo "Error deleting employee " . mysqli_error($conn);
        }

        mysqli_close($conn);

    }else {
        echo "Invalid Request";
    }

?>