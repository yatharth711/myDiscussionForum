<?php

// $host = 'localhost';
// $username = 'root';
// $password = '';
// $dbname = 'discussionforum';
$host = 'localhost';
$username = '80074958';
$password = '80074958';
$dbname = 'db_80074958';



//Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

if(mysqli_connect_error()) {
echo "DB Connection error: " . mysqli_error($conn);
exit();
}
?>
