<?php 
    $hostname="localhost";
    $username="root";
    $password="password";
    $database="discussionforum";

    //Database credentials for server dev
/*
$host = 'localhost';
$username = '80772049';
$password = '80772049';
$dbname = 'db_80772049'; //db name here
*/
//Create connection
    $conn = new mysqli_connect($hostname, $username, $password, $database);

    if(mysqli_connect_error()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
?>