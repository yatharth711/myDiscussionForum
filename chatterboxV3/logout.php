<?php
session_start();
require 'connectionDB.php';
$_SESSION = [];
session_unset();
session_destroy();
header("Location: index.php");
?>