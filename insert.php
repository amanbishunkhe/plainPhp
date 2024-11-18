<?php
include( 'db-connect.php' );

if ($_SERVER["REQUEST_METHOD"] === "POST" ) {
    $name =$_POST['name'];
    $email = $_POST['email'];   
    $profile_pic = $_FILES['profile_picture'];
    
    //file details

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $fileName = $_FILES['profile_picture']['name'];
        $fileTmp = $_FILES['profile_picture']['tmp_name'];
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/plainPhp/uploads/';
        $uploadPath = $uploadDir . basename($fileName);
    
        // Check if the temporary file exists
        if (!file_exists($fileTmp)) {
            echo 'Temporary file does not exist.<br>';
            exit;
        }
    
        // Check if the upload directory is writable
        if (!is_writable($uploadDir)) {
            echo 'Upload directory is not writable.<br>';
            exit;
        }
    
        // Attempt to move the uploaded file
        if (move_uploaded_file($fileTmp, $uploadPath)) {
            echo 'File uploaded successfully to ' . $uploadPath . '<br>';

            // for saving to database
            $newfilePath = $uploadDir.$fileName;
        } else {
            echo 'Failed to move uploaded file. Check permissions or PHP error log.<br>';
            echo 'Error: ' . error_get_last()['message'] . '<br>';
        }
    } else {
        echo 'File upload error: ' . $_FILES['profile_picture']['error'] . '<br>';
    }
    


    // Server-side validation
    if (strlen($name) < 3) {
        echo "Name must be at least 3 characters long.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }
    
    // Check if email already exists
    $checkEmailSql = "SELECT id FROM users WHERE email = ?";
    $checkStmt = $conn->prepare($checkEmailSql);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "Email already exists. Please use a different email.";
        exit;
    }

    // Insert user into the database
    $sql = "INSERT INTO users (name, email, profile_picture ) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email,$newfilePath);

    if ($stmt->execute()) {
        echo "User added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $checkStmt->close();
}

$conn->close();