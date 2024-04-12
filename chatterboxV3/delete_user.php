<?php
require_once 'connectionDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    // Delete post and comments associated to user from the database
    $stmt = $conn->prepare("DELETE FROM comments WHERE author = ?");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $stmt->close();
    //content
    $stmt = $conn->prepare("DELETE FROM content WHERE author = ?");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $stmt->close();

    //Delete User
    $stmt = $conn->prepare("DELETE FROM users WHERE uid = ?");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $stmt->close();

    //Delete Communities
    $stmt = $conn->prepare("DELETE FROM communities WHERE com_id = ?");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $stmt->close();
    // Redirect to the homepage
    header('Location: admin.php');
    exit();
}
?>