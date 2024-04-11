<?php

$conn = "";

try {
	$host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'discussionforum';

	$conn = new PDO(
		"mysql:host=$host; dbname=discussionforum",
		$username, $password
	);
	
$conn->setAttribute(PDO::ATTR_ERRMODE,
					PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}

?>
