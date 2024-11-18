<?php

include ( 'db-connect.php' );

if( $_SERVER["REQUEST_METHOD"] === "POST" && isset( $_POST['user_name'] ) && isset( $_POST['user_email'] ) ){
     $updated_user_name = $_POST['user_name'];
     $updated_user_email = $_POST['user_email'];
     $updated_user_id = $_POST['user_id'];     

    // validation
    if( empty( $updated_user_email ) || empty( $updated_user_name ) ){
        echo 'Name and email must be filled';
        exit;
    }

    ini_set('display_errors',1);
    error_reporting( E_ALL );
    
    $sql = "UPDATE users SET name = ?, email = ? WHERE id = ? ";
    $stmt = $conn->prepare( $sql );

    if ($stmt === false) {
        // Error during statement preparation
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
    
    // Bind the parameters (s = string, i = integer)
    if (!$stmt->bind_param("ssi", $updated_user_name, $updated_user_email, $updated_user_id)) {
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