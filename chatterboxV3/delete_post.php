<?php
require_once 'connectionDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $com_id = mysqli_real_escape_string($conn, $_POST['com_id']);

    $stmt = $conn->prepare("DELETE FROM comments WHERE com_id = ?");
    $stmt->bind_param("i", $com_id);
    $stmt->execute();
    $stmt->close();
    // Delete post from the database
    $stmt = $conn->prepare("DELETE FROM content WHERE com_id = ?");
    $stmt->bind_param("i", $com_id);
    $stmt->execute();
    $stmt->close();
    // Redirect to the homepage
    header('Location: admin.php');
    exit();
}
?>