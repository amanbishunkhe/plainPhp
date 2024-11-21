<?php

include( 'db-connect.php' );

$sql = "SELECT * from users";
$result = $conn->query( $sql );


if( $result->num_rows > 0 ){
    echo "<h2>Users</h2>";
    echo '<table>';
        echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Name</th>';
            echo '<th>Email</th>';
            echo '<th>Image</th>';
        echo '</tr>';
        $imagebaseURL = '/plainPhp/uploads/'; // Relative to your web server's root       
        
        while( $row = $result->fetch_assoc() ){
            $imageUrl = basename($row['profile_picture']);
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                
                <td><img src='{$imagebaseURL}{$imageUrl}' width='100px' /></td>
                <td><a href='update.php?id={$row['id']}'>Edit</a></td>
            </tr>";
        }

    echo '</table>';
}

$conn->close();