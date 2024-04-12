<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'discussionforum';

//Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

if(mysqli_connect_error()) {
echo "DB Connection error: " . mysqli_error($conn);
exit();
}
?>
