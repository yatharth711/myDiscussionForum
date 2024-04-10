<?php
    require 'connectionDB.php';

    if ($vote == 'upvote') {
        $sql = "UPDATE content SET likes = likes + 1 WHERE id = ?";
    } else {
        $sql = "UPDATE content SET dislikes = dislikes - 1 WHERE id = ?";
    }

    $stmt = $conn->prepare($sql);
$stmt->bind_param("i", $postId);
$stmt->execute();

$sql = "SELECT upvotes, downvotes FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $postId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode($row);

$conn->close();
?>