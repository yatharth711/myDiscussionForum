<?php
require_once 'connectionDB.php';
// require_once "updateLikes.php";
session_start();
if (isset($_GET['submit'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);

    $query = "SELECT p.*, u.username, u.uid, c.name FROM content p 
INNER JOIN users u ON p.author  = u.uid
INNER JOIN communities c on p.com_id = c.com_id
WHERE p.title LIKE '%$search_term%'
OR c.name LIKE '%$search_term%'
OR u.username LIKE '%$search_term%'";
} else {

    $query = "SELECT p.*, u.username, u.uid, c.name FROM posts p 
INNER JOIN users u ON p.author = u.uid
INNER JOIN communities c ON p.com_id = c.com_id";
}
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <link rel = "stylesheet" href = "css/index.css"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">

    <title>Chatterbox</title>
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
    
    <div class="container text-center" style="margin-top: 75px;">
        
    <div class="row">
        
            <div class="col">
                <div class="top-comm">
                    <h4>Top Communities</h4>
                    <?php
                    include 'connectionDB.php';
                    $query = "SELECT * FROM content ORDER BY content_id DESC";

                    $result = mysqli_query($conn, $query);
                    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    ?>
                    <script>
                        function likePost(contentId, element) {
                            const xhr = new XMLHttpRequest();
                            xhr.open("POST", "incrementLikes.php", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.onload = function() {
                                if (this.status === 200) {
                                    // Update the likes count in the button
                                    document.getElementById("likes-count-" + contentId).innerText = this.responseText;
                                }
                            };
                            xhr.send("contentId=" + contentId);
                        }
                    </script>

                </div>
            </div>
            <div class="col">
                <div class="recent-posts">
                    <h4>Recent Posts</h4>

                    <?php foreach ($posts as $post) :
                        // $query= $conn->prepare("select username from users where uid=?");
                        // $query->bind_param("i", $post['author']);
                        // $result= $query->get_result();
                        // $username= $result->fetch_assoc();
                    ?>
                        <div id="post-card">
                            <img src="imgPosts/<?= $post['img'] ?>" class="card-img-top" style="height: 50%; width: 50%;" alt="<?= htmlspecialchars($post['title']) ?>">

                            <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($post['text']) ?></p>
                            <p class="card-text"><small class="text-muted">By <?= htmlspecialchars($post['author']) ?></small></p>

                            <!-- Adjusted Like Button with JavaScript function call -->
                            <button onclick="likePost(<?= $post['content_id'] ?>, this)" class="btn btn-primary">Likes: <span id="likes-count-<?= $post['content_id'] ?>"><?= $post['likes'] ?></span></button>


                            <!-- New Comments Button -->
                            <a href="comments.php?post_id=<?= $post['content_id'] ?>" class="btn btn-secondary">Comments</a>
                        </div>
                    <?php endforeach; ?>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                </div>
            </div>
        </div>
    </div>

    <script src="scripts/script.js"></script>
    <script src="scripts/async.js"></script>
</body>

</html>