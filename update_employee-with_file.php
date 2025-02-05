<?php
    include('config.php'); //import the database configuration

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        //Get the form data
        $id = $_POST['id'];
        $name = $_POST['name'];
        $birth = $_POST['birth'];
        $gender = $_POST['gender'];

        //calculate the age from the birth data
        $birthDate = new DateTime($birth);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;

        //Hale file upload (if a new resume is provided)
        $filePath = null;

        if ($_FILES['resume']['error'] === UPLOAD_ERR_OK){
            $uploadDir = 'uploads/' ; //Directory to store uploaded files
            if(!is_dir($uploadDir)){
                mkdir($uploadDir, 0777, true); //create the new directory if it does not exist
            }

            $fileName = uniqid() . '_' .basename($_FILES['resume']['name']);
            $filePath = $uploadDir . $fileName;
            
            if(!move_uploaded_file($_FILES['resume']['temp_name'],$filePath)){
                echo "Error uploading resume";
                exit;
            }


        }

        //Update data in the database
        if($filePath){
            //If a new resume uploaded, update the resume field
            $sql = "UPDATE emp_table SET name = '$name', age = $age, birth = '$birth' gender = '$gender' resume = '$filePath' WHERE id = $id ";
        }else{
            //If no resume is uploaded, keep the existing resume
            $sql = "UPDATE emp_table SET name = '$name', age = $age, birth = '$birth', gender = '$gender' WHERE id = $id";
        }

        if(mysqli_query($conn, $sql)){
            echo "Employee updated successfully";
        }else{
            echo "Updating employee error!..... " . mysqli_error($conn);
        }
        mysqli_close($conn);
    }else{
        echo "Invalid request";
    }

?>