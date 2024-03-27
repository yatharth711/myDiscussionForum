<!DOCTYPE html>
<html>
<head>
    <style>
        .navbar {
    background-color: black;
    text-align: center;  
    padding: 10px;
    font-size: 20px;
    font-family: sans-serif;
    width: 100%;
    
}

        body {
            font-family: Arial, sans-serif;
        }
        .categories, .posts {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            border: none;
            background-color: #008CBA;
            color: white;
            text-align: center;
            cursor: pointer;
        }
        .button:hover {
            background-color: #007B9A;
        }
        .post {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .post-title {
            font-size: 20px;
            font-weight: bold;
        }
        .post-content {
            margin-top: 10px;
        }

    </style>
</head>
<body>
<div class="navbar"> <!--Navbar-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
            <div class="container-fluid">
              <a class="navbar-brand" href="#">My Discussion Forum</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="user.html">User Contents</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Settings</a>
                  </li>
                <div class ="center">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                      </form>
                </div>
                </ul>                
              </div>
            </div>
          </nav>
        </div>
    <?php 
    require_once 'connectionDB.php';
    $query = "SELECT * FROM content ORDER BY date DESC LIMIT 10";
    $result = mysqli_query($conn, $query);
    echo '<div class="posts">';
    while($row = mysqli_fetch_assoc($result)) {
        $title = $row['title'];
        $text = $row['text'];
        $date = $row['date'];
        $likes = $row['likes'];
        echo '<div class="post">';
        echo '<h2>'.$title.'</h2>';
        echo '<p>'.$text.'</p>';
        echo '<p>Posted on: '.$date.'</p>';
        echo '<p>Likes: '.$likes.'</p>';
        echo '</div>';
    }
    echo '</div>';
    ?>
    <div class="categories">
        <p>Communities</p>
        <?php 
        require_once 'connectionDB.php';
        if(isset($_SESSION['uid'])) {
            $uid = $_SESSION['uid'];
            $query = "SELECT c.name, u.com_id FROM communities c JOIN user_communities u ON c.com_id = u.com_id WHERE u.uid = '$uid' LIMIT 7";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($result)) {
                $com_id = $row['com_id'];
                $name = $row['name'];
                echo '<form method="post" action="leaveCommunity.php">';
                echo '<input type="hidden" name="com_id" value="'.$com_id.'">';
                echo '<button type="submit" class="deleteButton1"><!-- Add HTML/CSS here --></button>';
                echo '<p><a href="community.php?com_id='.$com_id.'">'.$name.'</a></p>';
                echo '</form>';
            }
        } else {
            echo '<p> Login To Join Communities </p>';
        }
        ?>
        <a href="create_community.php" class="button">Create Community</a>
        <a href="join_com.php" class="button">Join Community</a>
        <a href="create_post.php" class="button">Create Post</a>
    </div>
</body>
<footer>
    <!-- Add HTML/CSS here -->
</footer>
</html>
