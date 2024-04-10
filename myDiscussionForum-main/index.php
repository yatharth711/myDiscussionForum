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

    <!-- <link rel="stylesheet" href="css/index.css"> -->
    <style>
        .button {
            border: none;
            color: white;
            text-align: center;
            display: inline-block;
            font-size: 16px;
            transition-duration: 0.4s;
            cursor: pointer;
        }

        .upvote {
            background-color: white;
            color: black;
            border: 2px solid #4CAF50;
        }

        .upvote:hover {
            background-color: #4CAF50;
            color: white;
        }

        .downvote {
            background-color: white;
            color: black;
            border: 2px solid #f44336;
        }

        .downvote:hover {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>

<body style="margin: 5px;">

    <nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary">
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
                            <li><a class="dropdown-item" href="community_list.php">Find a Chatterbox</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
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
    
    <section class="content">
        <br>
        <br>
        <br>
        </div>
        <div class="top-comm">
            <h4>Top Communities</h4>
            <?php
            require_once 'connectionDB.php';

            $query = "SELECT c.name, c.description, count(u.uid) as joined FROM communities c JOIN user_communities u ON c.com_id = u.com_id order by joined desc";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                if (empty($row) == 0) {
                    echo '<p>No Chatterboxes here</p>';
                    echo '<a href="create_community.php">Make the first Chatterbox</a>';
                } else {
                    $desc = $row['description'];
                    $name = $row['name'];
                    echo '<h3>' . $name . '</h3>';
                    echo '<p>' . $desc . '</p>';
                    if (isset($_SESSION['uid'])) {
                        echo '<a href="join_com.php">Join Chatterbox</a>';
                    } else {
                        echo '<a href="login.php">Join Chatterbox</a>';
                    }
                }
            }

            ?>

        </div>

        <div class="recent-posts">


            <h4>Top Chats</h4>
            <?php
                require_once "connectionDB.php";
                $sql= "select title, author, text, date, img from content";
                $result= mysqli_query($conn, $sql);
               
                if(empty(mysqli_num_rows($result))){
                    echo "<p>No Chats Here";
                    echo '<p>Start Chat<a href="create_post.php"> Now</a></p>';
                }else{
                    while($row= mysqli_num_rows($result)){
                        echo '<div class="card" style="width: 18rem;">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">'.$row['title'].'</h5>';
                        echo '<h6 class="card-subtitle mb-2 text-body-secondary">'.$row['author'].'</h6>';
                        echo '<p class="card-text">'.$row['text'].'</p>';
                        echo '<a href="#" class="card-link">Card link</a>';
                    }
                }
               
            
            ?>
            
                
                    
                    
                    
                    
                    <a href="#" class="card-link">Another link</a>
                </div>
            </div>
            
        </div>


    </section>



</body>