<?php
    include('config.php');

    //set the content type to json
    header('Content-Type:  application/json');

    //sql statement to get data from the database
    $sql = "SELECT * FROM emp_table";

    $result = mysqli_query($conn, $sql);

    if(!$result){
        die("Error executing Query :" . mysqli_error($conn));

    }

    //Fetch all rows as an associative array
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

    //Encode the result as JSON and output
    echo json_encode($result);

    //Free the result set (released the memory)
    mysqli_free_result($result);

    //close the database connection
    mysqli_close($conn);


?>