<?php

include ( 'db-connect.php' );

if( $_SERVER["REQUEST_METHOD"] === "POST" ){
    // echo '<pre>';
    // print_r( $edited_profile_pictue = $_FILES['edited_profile_picture'] );
    // echo '</pre>';

    $updated_user_name = $_POST['user_name'];
    $updated_user_email = $_POST['user_email'];
    $updated_user_id = $_POST['id'];   

    if( isset( $_FILES['edited_profile_picture'] ) && $_FILES['edited_profile_picture']['error'] === 0 ){
        $image_name = $_FILES['edited_profile_picture']['name'];
        $tmp_image_name = $_FILES['edited_profile_picture']['tmp_name'];
        $upload_directory = $_SERVER['DOCUMENT_ROOT'].'/plainPhp/uploads/';
        $upload_path = $upload_directory.basename( $image_name );

        // Ensure the upload directory exists
        if (!is_dir($upload_directory)) {
            mkdir($upload_directory, 0755, true); // Create the directory if it doesn't exist
        }

        if( move_uploaded_file( $tmp_image_name, $upload_path ) ){
            echo 'File uploaded successfully to ' . $upload_path . '<br>';
            $new_file_path = $upload_directory.$image_name;
        }
    }else{        
        $updated_user_id = $_POST['user_id'];  
        $sql = "SELECT profile_pircture FROM users WHERE id = ? ";
        $stmt = $conn->prepare( $sql );
        $stmt -> bind_param( "i", $updated_user_id );
        $stmt -> execute();
        $result = $stmt->get_result();
        $user_data = $result->fetch_assoc();        

        if ($user_data) {
           echo  $new_file_path = $user_data['profile_picture']; // Use the existing image path
        } else {
            echo "User not found.";
            exit;
        }

        $stmt->close();
    }


    // validation
    if( empty( $updated_user_email ) || empty( $updated_user_name ) ){
        echo 'Name and email must be filled';
        exit;
    }

    ini_set('display_errors',1);
    error_reporting( E_ALL );
    
    $sql = "UPDATE users SET name = ?, email = ?, profile_picture = ? WHERE id = ? ";
    $stmt = $conn->prepare( $sql );

    if ($stmt === false) {
        // Error during statement preparation
        echo "Error preparing statement: " . $conn->error;
        exit;
    }   
    // Bind the parameters (s = string, i = integer)
    if (!$stmt->bind_param("sssi", $updated_user_name, $updated_user_email, $new_file_path, $updated_user_id)) {
        echo "Error binding parameters: " . $stmt->error;
        exit;
    }
    
    // Execute the statement
    if (!$stmt->execute()) {
        echo "Error executing statement: " . $stmt->error;
        exit;
    }
    
    echo "User updated successfully. <a href='display.php'>GO BACK</a>";
    
    // Close the statement and connection
    $stmt->close();

}
$conn->close();