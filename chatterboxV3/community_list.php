<?php
session_start();
if(!isset($_SESSION['uid'])) {
    header("Location: login.php");
    die;    
    }
?>

<!DOCTYPE html>
<html>
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    </head>
    <body>
    <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Find a Chatterbox</li>
  </ol>
</nav>
    </body>
</html>

<form method="POST" action="">
    <input type="text" name="search" placeholder="Search communities...">
    <input type="submit" name="submit" value="Search">
</form>

<?php


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