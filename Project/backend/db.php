<?php
    $host= "localhost";
    $dbname= "discussionforum";
    $user= "root";
    $pwd= "";

    $conn = mysqli_connect($host, $user, $pwd, $dbname);
    
    //check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }
?>