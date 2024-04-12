<?php
session_start();

include_once 'connectionDB.php';

if(isset($_GET['com_id'])) {
    $com_id = mysqli_real_escape_string($conn, $_GET['com_id']);

    $communityQuery = "SELECT name FROM communities WHERE com_id = '$com_id'";
    $communityResult = mysqli_query($conn, $communityQuery);

    if($communityRow = mysqli_fetch_assoc($communityResult)) {
        $communityName = $communityRow['name'];
        echo "<h2>Posts in '$communityName'</h2>";
    } else {
        echo "<p>Community not found.</p>";
    }

    $query = "SELECT c.content_id, c.title, c.text, c.date, c.likes, u.username AS author
              FROM content c
              JOIN users u ON c.author = u.uid
              WHERE c.com_id = '$com_id'
              ORDER BY c.date DESC";

    $result = mysqli_query($conn, $query);

    if($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $content_id = $row['content_id'];
            $title = $row['title'];
            $text = $row['text'];
            $date = $row['date'];
            $likes = $row['likes'];
            $author = $row['author'];
            
            echo '<div class="post">';
            echo '<h3>' . htmlspecialchars($title) . '</h3>';
            echo '<p>' . htmlspecialchars($text) . '</p>';
            echo '<p>Posted by: ' . htmlspecialchars($author) . ' on ' . htmlspecialchars($date) . ' | Likes: ' . htmlspecialchars($likes) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>Error fetching posts: '.mysqli_error($conn).'</p>';
    }
} else {
    echo '<p>No community selected.</p>';
}

mysqli_close($conn);
?>
