<?php
session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel = "stylesheet" href = "css/style.css">
    <script src="https://kit.fontawesome.com/41893cf31a.js" crossorigin="anonymous"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chatterbox</title>
</head>
<body>
<div class = "nav">
        <img src = "images/navLogo.jpg" alt = "logo" class = "logo">
        <?php if(isset($_SESSION["uid"])) { ?>
        <a href="viewAccount.php" class="button"><?php echo $_SESSION["username"]; ?></a>
        <?php } else { ?>
        <a href="createAccount.php" class="button">Login</a>
        <?php } ?>
        <?php  require_once 'connectionDB.php';
            $query = 'SELECT isAdmin, uid FROM users WHERE isAdmin = 1';
            $res = mysqli_query($conn, $query);
            if(isset($_SESSION["uid"])) {
            while ($rw = mysqli_fetch_assoc($res) ) {
                $admin = $rw['uid'];
            if (($_SESSION["uid"] == $admin)) {
                echo '<a href = "admin.php" class = "button">Admin</a>'; 
                } 
            }}?>  
        <div class = "search-container"> 
            <form method = "GET">
                <input type = "text" name = "search" placeholder = "Type here to search..">
                <button type = "submit" name = "submit"> <i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
        <a href= "home.php" class = "button"><i class="fa-solid fa-house"></i></a>
        <a href= "settings.php" class = "button"><i class="fa-solid fa-gear"></i></a>
        <a href = "logout.php" class = "button">Logout</a>
    </div>
    <div class="createCommunity">
        <a href="createCommunity.php" class="button">Create Community</a>
    </div>
    <div class="community-container">
        <?php
        require_once 'connectionDB.php';

        if(isset($_GET['com_id'])){
            $com_id = $_GET['com_id'];
        }
        $query = "SELECT c.com_id, c.name, c.description, COUNT(DISTINCT u.uid) AS totalJoined
         FROM communities c JOIN user_communities u ON u.com_id = c.com_id WHERE u.com_id = $com_id";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
        
            echo '<div class="communities">';
            echo '<div style="color:#A67EF3;font-size: 1.8em;">'.$row['name'].'</div>';
            echo '<hr>';
            echo '<div style="font-size: 1.2em;">Members: '.$row['totalJoined'].'</div>';
            echo '<hr >';
            echo '<div style="color:#A67EF3; font-size: 1.2em;">'.$row['description'].'</div> ';
            echo '<hr >';
            echo ' <div class="postContainer">';
            echo '<form method="POST" action="join_com.php">';
            echo '<input type="hidden" name="com_id" value="' . $row['com_id'] . '">';
            echo '<input type = "submit" value = "Join" name = "join" style="font-size: 1.2em; max-width: 15em;" class="button"</input>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            
        }
        ?> 
    </div> 
    <div class = "flex-container">
        <div class = "flex">
            <div class = "scroll">
            <?php 
            require_once 'connectionDB.php';
            require_once "updateScore.php";
            if(isset($_GET['com_id'])) {
                $com_id = $_GET['com_id'];
            } else {
                $com_id = 0;
            }
            $query = "SELECT p.*, u.username, u.uid, c.name FROM content p 
            INNER JOIN users u ON p.author = u.uid
            INNER JOIN communities c ON p.com_id = c.com_id
            WHERE p.com_id = $com_id";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class = "content">';
                echo '<div class = "top">';
                echo '<p style="color:#A67EF3; font-size: .8em;"><a href="viewAccount.php?uid='.$row['uid'].'">'.$row['username'].'</a></p>';
                echo '<p style = "color:#A67EF3; font-size: .8em;">'.$row['name'].'</p>';
                echo '</div>';
                if($row['image'] != null) {
                    echo '<div><img src="postsUpload/'.$row['image'].'"></div>';
                }
                echo '<p onclick="redirectToPost('.$row['content_id'].')" style="cursor: pointer;">' . $row['title'] . '</p>';
                echo '<div class="postContainer">';
                echo '<div class="contentcore">' . $row['score'] . '</div>';
                echo '<div class="upvote" style="cursor: pointer;" data-postid="' . $row['content_id'] . '"><i class="fa-solid fa-arrow-up"></i></div>';
                echo '<div class="downvote" style="cursor: pointer;" data-postid="' . $row['content_id'] . '"><i class="fa-solid fa-arrow-down"></i></div>';
                echo '<div class="commentButton" style="cursor: pointer;" onclick="redirectToPost('.$row['content_id'].')"><i class="fa-regular fa-comment"></i></div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
            
            <script>
        function redirectToPost(content_id){
            window.location.href = "viewPost.php?content_id="+content_id;
        }
    
        // Get the upvote and downvote buttons
        const upvoteButtons = document.querySelectorAll('.upvote');
        const downvoteButtons = document.querySelectorAll('.downvote');
    
        // Add a click event listener to each upvote button
        upvoteButtons.forEach(button => {
            button.addEventListener('click', () => {
                const postId = button.dataset.postid;
                const scoreElement = button.parentNode.querySelector('.contentcore');
    
                // Make an AJAX call to update the post score
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'updateScore.php');
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Update the score in the UI
                        const newScore = JSON.parse(xhr.responseText).newScore;
                        scoreElement.innerHTML = newScore;
                        button.classList.add('active');
                        button.parentNode.querySelector('.downvote').classList.remove('active');
                    } else {
                        console.error('Error updating score');
                    }
                };
                xhr.send(`postId=${postId}&vote=up`);
            });
        });
    
        // Add a click event listener to each downvote button
        downvoteButtons.forEach(button => {
            button.addEventListener('click', () => {
                const postId = button.dataset.postid;
                const scoreElement = button.parentNode.querySelector('.contentcore');
    
                // Make an AJAX call to update the post score
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'updateScore.php');
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Update the score in the UI
                        const newScore = JSON.parse(xhr.responseText).newScore;
                        scoreElement.innerHTML = newScore;
                        button.classList.add('active');
                        button.parentNode.querySelector('.upvote').classList.remove('active');
                    } else {
                        console.error('Error updating score');
                    }
                };
                xhr.send(`postId=${postId}&vote=down`);
            });
        });
    </script>
        </div>
        </div>
</body>
</html>