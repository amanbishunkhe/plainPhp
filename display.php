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
        echo '</tr>';

        while( $row = $result->fetch_assoc() ){
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td><a href='update.php?id={$row['id']}'>Edit</a></td>
            </tr>";
        }

    echo '</table>';
}

$conn->close();