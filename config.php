<?php
    $db_server = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'employees';
    $conn = '';

   try{
     //create the database connection
     $conn = new mysqli($db_server, $db_user, $db_password, $db_name, 3308 );
    //  echo "Connection is successful";
   }catch(mysqli_sql_exception){
    echo "could not connect!";
   }    
?>