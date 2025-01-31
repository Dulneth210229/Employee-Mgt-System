<?php
    include('config.php');

    // Set the Content-Type header to JSON
    header('Content-Type: application/json');

    //sql statement to get data from the database
    $sql = "SELECT * FROM emp_table";

    $result = mysqli_query($conn, $sql);

    if(!$result) {
        die("Error executing query:" . mysqli_error($conn));
    }

    //Fetch all rows as an associative array
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    //Encode the result as JSON and output it
    echo json_encode($rows);

    //Free the result set (released the memory)
    mysqli_free_result($result);

    //close the database connection
    mysqli_close($conn);
?>