<?php
    include('config.php');

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $name = $_POST['name'];
        $birth = $_POST['birth'];
        $gender = $_POST['gender'];

        // $name = "Alice";
        // $birth = "2002-12-21";
        // $gender = "Female";

        //calculate age from the birth data
        $birthDate = new DateTime($birth);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;

        //insert data into the database
        $sql = "INSERT INTO emp_table (name, age, birth, gender) VALUES ('$name', $age, '$birth', '$gender')";
   

    //Execute the query and check for errors
    if(mysqli_query($conn, $sql)){
        echo "Employee added successfully";
    }else{
        echo "Error: " . mysqli_error($conn); //This will display the specific database error
    }

    //close the connection
    mysqli_close($conn);
}
?>