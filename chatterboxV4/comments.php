<?php
session_start();
require_once 'connectionDB.php';
$post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    // Assuming you have a way to identify the logged-in user (e.g., $_SESSION['uid'])
    $uid = $_SESSION['uid']; // Make sure this is properly sanitized and validated
    $comment = trim($_POST['comment']);

    if (!empty($comment)) {
        $stmt = $conn->prepare("INSERT INTO comments (con_id, author, text, date, likes) VALUES (?, ?, ?, NOW(), ?)");
        $likes_initial_value = 0; // Assuming you want to start with 0 likes
        $stmt->bind_param("iisi", $post_id, $user_id, $comment, $likes_initial_value);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->execute();
        $stmt->close();
    }
}

if ($post_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM content WHERE content_id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $post = $result->fetch_assoc()) {
        echo "<div class='post'>";
        echo "<h2>" . htmlspecialchars($post['title']) . "</h2>";
        echo "<p>" . htmlspecialchars($post['text']) . "</p>";
        echo "<a href='updateLikes.php?post_id=$post_id&vote=like'>Like</a> " . $post['likes'];
        echo "</div>";

        // Display the comment form
        echo "<form action='' method='post'>";
        echo "<textarea name='comment' placeholder='Write a comment...'></textarea>";
        echo "<button type='submit'>Submit</button>";
        echo "</form>";

        // Fetch and display comments for the post
        $stmt = $conn->prepare("SELECT c.text, u.username, c.date FROM comments c JOIN users u ON c.author = u.uid WHERE c.con_id = ? ORDER BY c.date DESC");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $comments_result = $stmt->get_result();

        if ($comments_result) {
            while ($comment = $comments_result->fetch_assoc()) {
                echo "<div class='comment'>";
                echo "<strong>" . htmlspecialchars($comment['username']) . "</strong>: ";
                echo htmlspecialchars($comment['text']);
                echo "<span style='float: right;'>" . htmlspecialchars($comment['date']) . "</span>";
                echo "</div>";
            }
        }
    } else {
        echo "Post not found.";
    }
    $stmt->close();
} else {
    echo "Invalid post ID.";
}
?>
