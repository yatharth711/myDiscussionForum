<?php
session_start(); // Start the session

if (!isset($_SESSION['uid'])) {
    echo "You must be logged in to perform this action.";
    exit();
}

include 'connectionDB.php'; // Include your DB connection

$contentId = $_POST['content_id'];
$likeType = $_POST['like_type'];
$userId = $_SESSION['uid']; // User ID from session

// Prevent SQL Injection
$contentId = mysqli_real_escape_string($conn, $contentId);
$likeType = mysqli_real_escape_string($conn, $likeType);
$userId = mysqli_real_escape_string($conn, $userId);

$query = "INSERT INTO likes (content_id, uid, like_type) VALUES ($contentId, $userId, $likeType) ON DUPLICATE KEY UPDATE like_type=$likeType";

if(mysqli_query($conn, $query)) {
    echo "Like/Dislike updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
?>
