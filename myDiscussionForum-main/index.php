<?php 
        require_once 'connectionDB.php';
        $query = 'SELECT c.name, u.com_id, COUNT(u.uid)as numJoined FROM communities c JOIN user_communities u
         ON c.com_id = u.com_id GROUP BY c.com_id ORDER BY numJoined DESC
        LIMIT 5';
        $result = mysqli_query($conn, $query);
        echo '<p>Top Communities</p>';
        while($row = mysqli_fetch_assoc($result)) {
        $com_id = $row['com_id'];
        $name = $row['name'];
        echo '<p><a href = "community.php?com_id='.$com_id.'">'.$name.'</a></p>';
        }
?> 
        
         
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">

</head>

<body>
    <h2>Chatterbox</h2>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="adminlogin.php">Admin</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="create_account.php">Register</a></li>
        </ul>
    </nav>

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
        if(isset($_SESSION['uid'])) {
        $uid = $_SESSION['uid'];
        $query = "SELECT c.name, u.com_id FROM communities c JOIN user_communities u ON c.com_id = u.com_id WHERE u.uid = '$uid' LIMIT 7";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
        $com_id = $row['com_id'];
        $name = $row['name'];
        echo '<form method="post" action="leaveCommunity.php">';
        echo '<input type="hidden" name="com_id" value="'.$com_id.'">';
        echo '<button type="submit" class="deleteButton1"> Add HTML/CSS here </button>';
        echo '<p><a href="community.php?com_id='.$com_id.'">'.$name.'</a></p>';
        echo '</form>';
        }
    } else {
        echo '<p> Login To Join Communities </p>';
    }
         ?>
                <div id="top_comm_card">
                    <p>Name<a href="#">Join</a></p>
               </div>
        </div>

        <div class="recent-posts">
            <h4>Recent Posts</h4>
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