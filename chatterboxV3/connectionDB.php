echo 'Hello world'
<?php

$host = 'localhost';
$username = '48138358';
$password = '48138358';
$dbname = 'db_48138358';

//Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

if(mysqli_connect_error()) {
echo "DB Connection error: " . mysqli_error($conn);
exit();
}
?>
