<?php
include 'connectionDB.php';

if (isset($_POST['contentId'])) {
    $contentId = $_POST['contentId'];
    
    // Increment like count (Ensure you have logic to prevent multiple likes from the same user)
    $query = "UPDATE content SET likes = likes + 1 WHERE content_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $contentId);
    $stmt->execute();
    
    // Fetch the updated likes count
    $likesQuery = "SELECT likes FROM content WHERE content_id = ?";
    $stmt = $conn->prepare($likesQuery);
    $stmt->bind_param("i", $contentId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    echo $result['likes'];
    
    $stmt->close();
    $conn->close();
}
?>
