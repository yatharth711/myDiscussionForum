<form method="POST" action="">
    <input type="text" name="search" placeholder="Search communities...">
    <input type="submit" name="submit" value="Search">
</form>

<?php
session_start();

include_once 'connectionDB.php';

if (isset($_POST['submit'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);

    $query = "SELECT c.com_id, c.name, COUNT(DISTINCT uc.uid) as followers, COUNT(DISTINCT ct.content_id) as posts
              FROM communities c
              LEFT JOIN user_communities uc ON c.com_id = uc.com_id
              LEFT JOIN content ct ON c.com_id = ct.com_id
              WHERE c.name LIKE '%$search%'
              GROUP BY c.com_id";
} else {
    $query = "SELECT c.com_id, c.name, COUNT(DISTINCT uc.uid) as followers, COUNT(DISTINCT ct.content_id) as posts
              FROM communities c
              LEFT JOIN user_communities uc ON c.com_id = uc.com_id
              LEFT JOIN content ct ON c.com_id = ct.com_id
              GROUP BY c.com_id";
}
$result = mysqli_query($conn, $query);

if($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $com_id = $row['com_id'];
        $name = $row['name'];
        $followers = $row['followers'];
        $posts = $row['posts'];

        echo '<div class="community">';
        echo '<p class="community-name" onmouseover="changeColor(this)" onmouseout="resetColor(this)"><a href = "community_post.php?com_id='.$com_id.'">'.$name.'</a> - Chatters: '.$followers.' - Posts: '.$posts.'</p>';
        echo '</div>';
    }
} else {
    echo '<p>Error: '.mysqli_error($conn).'</p>';
}

mysqli_close($conn);
?>
