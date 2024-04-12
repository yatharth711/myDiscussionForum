<?php

$host = 'localhost';
$username = '70362710';
$password = '70362710';
$dbname = 'db_70362710';

//Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

if(mysqli_connect_error()) {
echo "DB Connection error: " . mysqli_error($conn);
exit();
}
?>
