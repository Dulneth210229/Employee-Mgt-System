<?php
   include('config.php');


   if($_SERVER['REQUEST_METHOD'] === 'POST'){

      $id = $_POST['id'];
      $name = $_POST['name'];
      $birth = $_POST['birth'];
      $gender = $_POST['gender'];

      if(!$id){
         die("Invalid employee id" . mysqli_error($conn));
         return;
      }

      //calculate age by birth data
      $birthDate = new DateTime($birth);
      $today = new DateTime();
      $age = $today->diff($birthDate)->y;

      //Update the employee data in the databse
      $sql = "UPDATE emp_table SET name = '$name', age = $age, birth = '$birth', gender = '$gender' WHERE id = $id ";

      if(mysqli_query($conn, $sql)){
         echo "Employee Update successfully!....";
      }else{
         echo "Error Updating Employee!..." . mysqli_error($conn);
      }

      mysqli_close($conn);


   }else{
      echo "Invalid request";
   }
?>