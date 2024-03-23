<?php
session_start();
require_once 'connectionDB.php';

if (isset($_GET['submit'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    $query = "SELECT p.*, u.username, c.name FROM content p 
    INNER JOIN users u ON p.created_by = u.uid
    INNER JOIN communities c ON p.com_id = c.com_id
    WHERE p.title LIKE '%$search_term%'
    OR c.name LIKE '%$search_term%'
    OR u.username LIKE '%$search_term%'";
} else {
    $query = "SELECT p.*, u.username, c.name FROM content p 
    INNER JOIN users u ON p.created_by = u.uid
    INNER JOIN communities c ON p.com_id = c.com_id";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/41893cf31a.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DiscussionForum</title>
</head>
<body>
    <div class="nav">
        <div class="search-container">
            <form method="GET">
                <input type="text" name="search" placeholder="Type here to search..">
                <button type="submit" name="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
    </div>

    <div class="flex-container">
        <div class="flex">
            <div class="scroll">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $name = $row['name'];
                    $com_id = $row['com_id'];
                    $title = $row['title'];
                    $post_id = $row['post_id'];
                    echo '<div class="content">';
                    echo '<div class="top">';
                    echo '<p style="color:#A67EF3; font-size: .8em;">' . $row['username'] . '</p>';
                    echo '<p style="color:#A67EF3; font-size: .8em;"><a href="community.php?com_id=' . $com_id . '">' . $name . '</a></p>';
                    echo '</div>';
                    echo '<a href="viewPost.php?post_id=' . $post_id . '">' . $title . '</a>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

   
</body>
</html>