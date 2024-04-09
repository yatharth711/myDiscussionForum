<!-- <?php
        require_once 'connectionDB.php';
        $query = 'SELECT c.name, u.com_id, COUNT(u.uid)as numJoined FROM communities c JOIN user_communities u
         ON c.com_id = u.com_id GROUP BY c.com_id ORDER BY numJoined DESC
        LIMIT 5';
        $result = mysqli_query($conn, $query);
        echo '<p>Top Communities</p>';
        while ($row = mysqli_fetch_assoc($result)) {
            $com_id = $row['com_id'];
            $name = $row['name'];
            echo '<p><a href = "community.php?com_id=' . $com_id . '">' . $name . '</a></p>';
        }
        ?> 
         -->

<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="css/index.css">

</head>

<body style="margin: 5px;">

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
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
                            }

                            ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Options
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="create_community.php">Create a Chatterbox</a></li>
            <li><a class="dropdown-item" href="#">Find a Chatterbox</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
                    <!-- <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">Disabled</a>
        </li> -->
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="adminlogin.php">Admin</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="create_account.php">Register</a></li>
        </ul>
    </nav> -->

    <section class="content">
        <div id="sidebar">
            <a href="create_community.php">Create Chat</a>
            <hr>
            <a href="community_list.php">Find Chatters</a>
            <hr>


        </div>
        <div class="top-comm">
            <h4>Top Communities</h4>
            <?php
            require_once 'connectionDB.php';
            if (isset($_SESSION['uid'])) {
                $uid = $_SESSION['uid'];
                $query = "SELECT c.name, u.com_id FROM communities c JOIN user_communities u ON c.com_id = u.com_id WHERE u.uid = '$uid' LIMIT 7";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    $com_id = $row['com_id'];
                    $name = $row['name'];
                    echo '<form method="post" action="leaveCommunity.php">';
                    echo '<input type="hidden" name="com_id" value="' . $com_id . '">';
                    echo '<button type="submit" class="deleteButton1"> Add HTML/CSS here </button>';
                    echo '<p><a href="community.php?com_id=' . $com_id . '">' . $name . '</a></p>';
                    echo '</form>';
                }
            } else {
                echo '<p> Login To Join Communities </p>';
            }
            ?>
            <div id="top_comm_card">
                <p>Name<a href="join_com.php">Join</a></p>
            </div>
        </div>
       
        <div class="recent-posts">
            <h4>Recent Posts</h4>
            <div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
  </div>
</div>
            <div id="recent_post_card">
                <!-- TODO php to display all the community posts here -->
                <p>Title</p>
                <p>User</p>
                <p>Content</p>
                <p>Like</p>
                <p>Dislike</p>
                <hr>
            </div>
        </div>


    </section>



</body>