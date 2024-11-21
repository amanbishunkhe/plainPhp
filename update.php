<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update User</title>
</head>
<style>
    .hidden {
      display: none;
    }
  </style>
<body>
<?php
include( 'db-connect.php' );
// Check if the user ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch user data based on the ID
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $imagebaseURL = '/plainPhp/uploads/';

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        ?>
        <form id="updateForm">
            <input id="update_user_id" type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="user_name" name="user_name" value="<?php echo $user['name']; ?>" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="user_email" name="user_email" value="<?php echo $user['email']; ?>" required>
            </div>
            <div>
                <div class="hidden" id="image_update_upload">
                    <label for="edited_profile_picture"  >Profile Picture</label>
                    <input type="file" name="edited_profile_picture" id="edited_profile_picture" />
                </div>                
                <img src="<?php echo $imagebaseURL.basename( $user['profile_picture'] ); ?>" width="100px" />
                <button id="edit_picture">Edit Picture</button>
            </div>
            <button id="user_update" type="submit">Update</button>
        </form>
<?php
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

?>
<script src="https://code.jquery.com/jquery-3.7.1.js" ></script>
<!-- Include external JavaScript file -->
<script src="update.js"></script>
</body>

</html>
