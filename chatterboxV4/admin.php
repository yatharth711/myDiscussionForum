<?php
session_start();
?>

<!-- php code for search functionality -->
<?php 
require_once 'connectionDB.php';

if(isset($_GET['submit'])) {
$search_term = mysql_real_escape_string($conn, $_GET['search']);
//query that checks search term using LIKE
$query = "SELECT p.*, u.username, c.name FROM content p
INNER JOIN users u ON p.author  = u.uid
INNER JOIN communities c on p.com_id = c.com_id
WHERE p.title LIKE '%$search_term%'
OR c.name LIKE '%$search_term%'
OR u.username LIKE '%$search_term%'";
} else {
//query to show all content
$query = "SELECT p.*, u.username, c.name FROM content p 
INNER JOIN users u ON p.author = u.uid
INNER JOIN communities c ON p.com_id = c.com_id";
}
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <link rel="stylesheet" href="css/admin.css">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatter Box Admin</title>
</head>
<body>
<div class="navbar">
        <nav>
            <ul>
                <!-- <input id="search" type="text" placeholder="Search"> -->
                <li id="admin"><a href="#">Admin</a></li>
                <li><a href="#">Community Statistics</a></li>
                <li><a href="#">User Statistics</a></li>
                <li><a href="index.php">Home</a></li>
                <li><a href = "logout.php" class = "button">Logout</a></li>
            </ul>
        </nav>
    </div>
        
        <?php  require_once 'connectionDB.php';
            $query = 'SELECT checkAdmin, uid FROM users WHERE checkAdmin = 1';
            $res = mysqli_query($conn, $query);
            if(isset($_SESSION["uid"])) {
            while ($rw = mysqli_fetch_assoc($res) ) {
                $admin = $rw['uid'];
            if (($_SESSION["uid"] == $admin)) {
                echo '<a href = "admin.php" class = "button" style = "color: #fbeee0;">Admin</a>'; 
                } 
            }}?>  

        <!-- <div class = "search-container"> 
            <form method = "GET">
                <input type = "text" name = "search" placeholder = "Type here to search..">
                <button type = "submit" name = "submit"> <i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div> -->
        <a href= "index.php" class = "button"><i class="fa-solid fa-house"></i></a>
        
        
        

    </div>
    <div id="community">
    <h3>Community Statistics</h3>
    <div class="categories">
        <p style="color:#A67EF3; font-size: 1.3em;"><a href="community_list.php">Communities</a></p>
        <?php 
        require_once 'connectionDB.php';
        if(isset($_SESSION['uid'])) {
            // Start the table and add headers for community name and description
            echo '<table border="1" style="width:100%; margin-top: 20px;">';
            echo '<thead><tr><th>Community Name</th><th>Description</th></tr></thead>';
            echo '<tbody>';
            
            $query = "SELECT com_id, name, description FROM communities";
            $result = mysqli_query($conn, $query);
            if($result) {
                while($row = mysqli_fetch_assoc($result)) {
                    $com_id = $row['com_id'];
                    $name = $row['name'];
                    $description = $row['description'];
                    // Each community is displayed as a row within the table
                    echo '<tr>';
                    echo '<td><a href="community.php?com_id='.$com_id.'">'.htmlspecialchars($name).'</a></td>';
                    echo '<td>'.htmlspecialchars($description).'</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="2">Error: '.mysqli_error($conn).'</td></tr>';
            }
            echo '</tbody>';
            echo '</table>'; // Close the table
        } else {
            echo '<p> Login To Join Communities </p>';
        }
        ?>
    </div>
</div>


    <section>
        

        <div id="user">
            <h3>User Statistics</h3>
            <p></p>
            
        <div class = "popular">
            <?php 
            require_once 'connectionDB.php';
            if(isset($_POST['submit'])){
                $search_term = mysqli_real_escape_string($conn, $_POST['search']);
                $query = "SELECT username, email, uid FROM users WHERE username LIKE '%$search_term%' 
                OR email LIKE '%$search_term%' LIMIT 4";
            } else { 
                $query = 'SELECT username, uid FROM users LIMIT 4';
            }
            $result = mysqli_query($conn, $query);
            echo '<p style = "color:#A67EF3; font-size: 1.3em;" >Users</p>';
            echo '<div class = "search-container">';
            echo '<form method = "POST">';
                echo '<input type = "text" name = "search" placeholder = "Search users..">';
                echo '<button type = "submit" name = "submit"> <i class="fa-solid fa-magnifying-glass"></i></button>';
            echo '</form>';
            echo '</div>';
            while($row = mysqli_fetch_assoc($result)) {
            $username = $row['username'];
            $uid = $row['uid'];
            echo '<div style = "display: flex; align-items: center;">';
            echo '<form method="post" action="delete_user.php" style ="margin-left: 1em;" class="deleteForm">';
            echo '<input  type="hidden" name="uid" value="'.$uid.'">';
            echo '<button type="submit" class="deleteButton" style = "display: inline-block;" ><i style=" color: #616161; " class="fa-solid fa-trash"></i></button>';
            echo '<p style = "display: inline-block; margin-left:1.6em;">'.$username.'</p>';
            echo '</form>';
            echo '</div>';
            }
             ?>
        </div>           
           
    </div>
    </section>
<div class = "flex-container">
    <div class = "flex">
        <div class = "scroll">
        <?php 
        
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['name'];
            $com_id = $row['com_id'];
            $title = $row['title'];
            $content_id = $row['content_id$content_id'];
            echo '<div class = "content">';
            echo '<div class = "top">';
            echo '<p style = "color:#A67EF3; font-size: .8em;">'.$row['username'].'</p>';
            echo '<p style = "color:#A67EF3; font-size: .8em;"><a href = "community.php?com_id='.$com_id.'">'.$name.'</a></p>';
            echo '</div>';
            echo '<a href="viewPosts.php?content_id$content_id='.$content_id.'">'.$title.'</a>';
            echo '<div class="postContainer">';
            echo '<a href="viewPosts.php?content_id$content_id='.$content_id.'" class="commentButton" style="cursor: pointer;"><i class="fa-regular fa-comment"></i></a>';
            echo '<form method="post" action="delete_post.php" style ="margin-left: 1em;" class="deleteForm">';
            echo '<input style ="margin-left: 1em;" type="hidden" name="content_id$content_id" value="'.$content_id.'">';
            echo '<button type="submit" class="deleteButton"><i style=" color: #616161; " class="fa-solid fa-trash"></i></button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }
        
        
        ?>
    </div>
    </div>
    
        
      
    </div>
</div>
<script src = "scripts/script.js"></script>
</body>
<footer>
    <p class = "tos">Terms of Service</p>
    <p class = "tos">About</p>
    <p class = "tos">Contact Us</p>
    <p class = "tos">FAQ</p>
    <p class = "tos">Privacy and Policy</p>
</footer>
</html>
