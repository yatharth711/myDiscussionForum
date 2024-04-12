<?php 
require_once 'connectionDB.php';

session_start();
if (isset($_GET['searchQuery'])) {
    $searchQuery = $conn->real_escape_string($_GET['searchQuery']);

    // Search users
    $userResults = $conn->query("SELECT * FROM users WHERE username LIKE '%$searchQuery%'");

    // Search communities
    $communityResults = $conn->query("SELECT * FROM communities WHERE name LIKE '%$searchQuery%'");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel = "stylesheet" href = "css/index.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <title>Chatterbox</title>
</head>

<body>
    <h2>Chatterbox</h2>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li> 
                <?php if(isset($_SESSION["uid"])) { ?>
                    <a href="users_account.php" class="button"><?php echo $_SESSION["username"]; ?></a>
        <?php } else { ?><a href="login.php" class="button">Login</a><?php } ?>
            </li>

        <li><a href="create_account.php">Register</a></li>
        <li>
</li>
        <li><a href = "logout.php" class = "button">Logout</a></li>
        <li><a href="resetPwd.php">Forgot Password</a></li>
        </ul>
        
    </nav>

    <section class="content">
        <div id="sidebar">
            <a href="create_community.php">Create Chat Areas</a>
            <hr>
            <a href="community_list.php">Find Chatters</a>
            <hr>
            <a href="createPost.php">Create Chat</a>
            <hr>
            <a href="join_com.php">Join Chats !</a>
            <hr>
            <form method="get">
    <input type="text" name="searchQuery" id="searchQuery" placeholder="Search users and communities..." onkeyup="searchFunction()">
    <button type="submit">Search</button>
    <button type="reset">Reset</button>
</form>
<!-- Container for displaying search results -->
<div id="searchResults" class="search-results"></div>
            

        </div>
        
        <div class="top-comm">
            <h4>Top Communities</h4>
            <?php 
    include 'connectionDB.php';
    $query = "SELECT * FROM communities ORDER BY com_id DESC";
    
    $result = mysqli_query($conn, $query);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>
    <a href="join_com.php">Join Chats !</a>
            </div>
        </div>
        
        <div class="recent-posts">
            <h4>Recent Posts</h4>
    <?php 
    include 'connectionDB.php';
    $query = "SELECT * FROM content ORDER BY content_id DESC";
    
    $result = mysqli_query($conn, $query);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>
    <!-- <script>
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
</script> -->

    <div class="container">
    <div class="row">
        <?php foreach ($posts as $post): ?>
            <div class="col-md-4 mt-3">
                <div class="card">
                    <img src="imgPosts/<?= $post['img'] ?>" class="card-img-top" alt="<?= htmlspecialchars($post['title']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($post['text']) ?></p>
                        <p class="card-text"><small class="text-muted">By <?= htmlspecialchars($post['author']) ?></small></p>
                        
                         <!-- Adjusted Like Button with JavaScript function call
                        <button onclick="likePost(<?= $post['content_id'] ?>, this)" class="btn btn-primary">Likes: <span id="likes-count-<?= $post['content_id'] ?>"><?= $post['likes'] ?></span></button> -->

                        
                        <!-- New Comments Button -->
                       <a href="comments.php?post_id=<?= $post['content_id'] ?>" class="btn btn-secondary">Comments</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

        
   
    </div>
            </div>
        </div>

       
    </section>
    

<script src = "scripts/search.js"></script>

</body>



</html>