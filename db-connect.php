<?php 
//database connection details
$servername = 'localhost';
$username = 'root';
$password = 'az';
$dbname = 'myapp';

//create connection
$conn = new mysqli( $servername, $username, $password,$dbname );

//check connection
if( $conn->connect_error ){
    die("Connection Failed: ".$conn->connect_error);
}else{
    echo 'db connected';
}