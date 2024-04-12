<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    die;
}
?>

<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Chatterbox</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <?php
                    require_once 'connectionDB.php';
                    if (!isset($_SESSION["username"])) {
                        echo '<li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
              </li>';
                    } else {
                        echo '<li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
              </li>';
                        echo '<li class="nav-item">
                <a class="nav-link" href="users_account.php">My Account</a>
              </li>';
                    }

                    ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Options
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="create_community.php">Create a Chatterbox</a></li>
                            <li><a class="dropdown-item" href="community_list.php">Find a Chatterbox</a></li>
                            <li><a class="dropdown-item" href="join_com.php">Join a Chatterbox</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="createPost.php">Create a Chat</a></li>
                        </ul>
                    </li>
                </ul>
                <form id="searchcomm" class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="breadcrumbs">
        <ul>
            <li><a href="index.php">Home</a> |</li>
            <li>
                <p>Find Chatterbox</p>
            </li>
        </ul>
    </div>

    <div class="searchcomm">
        <h4><strong>Search Below</strong></h4>
        <form method="POST" action="">
            <input type="text" name="search" placeholder="Type Here...">
            <input type="submit" name="submit" value="Search">
        </form>
    </div>

</body>

</html>



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

if ($result) {
    echo '<div class="comms">';
    echo '<h4>List of Communities</h4>';
    while ($row = mysqli_fetch_assoc($result)) {
        $com_id = $row['com_id'];
        $name = $row['name'];
        $followers = $row['followers'];
        $posts = $row['posts'];

        echo '<div class="commname">';
        echo '<p class="community-name" onmouseover="changeColor(this)" onmouseout="resetColor(this)"><a href = "community_post.php?com_id=' . $com_id . '">' . $name . '</a> - Chatters: ' . $followers . ' - Posts: ' . $posts . '</p>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo '<p>Error: ' . mysqli_error($conn) . '</p>';
}

mysqli_close($conn);
?>