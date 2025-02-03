<?php
include('config.php'); // Include the database configuration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $birth = $_POST['birth'];
    $gender = $_POST['gender'];

    // Handle file upload
    if ($_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Folder to store uploaded files
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create the folder if it doesn't exist
        }

        // Generate a unique file name[]
        $fileName = uniqid() . '_' . basename($_FILES['resume']['name']);
        $filePath = $uploadDir . $fileName;

        // Move the uploaded file to the uploads folder
        if (move_uploaded_file($_FILES['resume']['tmp_name'], $filePath)) {
            // Insert data into the database
            $sql = "INSERT INTO emp_table (name, birth, gender, resume) VALUES ('$name', '$birth', '$gender', '$filePath')";
            if (mysqli_query($conn, $sql)) {
                echo "Employee added successfully!";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Error uploading resume.";
        }
    } else {
        echo "Please upload a valid resume.";
    }
}
?>