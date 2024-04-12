<?php
require_once 'connectionDB.php';
session_start();
// Retrieve user ID from session
$uid = $_SESSION['uid'];

// Retrieve selected community ID from form submission
$com_id = mysqli_real_escape_string($conn, $_POST['com_id']);

// Check if user is a member of the selected community
$sql = "SELECT COUNT(*) AS count FROM user_communities WHERE uid = $uid AND com_id = $com_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$count = $row['count'];

if ($count == 1) {
    // Remove user from community
    $sql = "DELETE FROM user_communities WHERE uid = $uid AND com_id = $com_id";
    mysqli_query($conn, $sql);
}

// Close database connection
mysqli_close($conn);

// Redirect to remaining communities page
header('Location: index.php');
exit();

?>