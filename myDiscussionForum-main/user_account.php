<?php
require 'connectionDB.php';
session_start();
if(empty($_SESSION["uid"])){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!-- Add CSS link here -->
	<!-- Add JavaScript link here -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>

<body>
<!-- USER ID RETRIEVAL -------------------->
<?php 
require_once 'connectionDB.php';
//getting uid
if(isset($_GET['uid'])) {
    // use the user ID from the URL instead of the session user ID
    $uid = $_GET['uid'];
} else {
    // use the session user ID if no user ID is specified in the URL
    $uid = $_SESSION['uid'];
}
?>
<!-- Add HTML/CSS here -->
</body>
</html>
<!-- NAV -->
<div class = "nav">
    <!-- Add HTML/CSS here -->
    <?php if(isset($_SESSION["uid"])) { ?>
    <a href="user_account.php" class="button"><?php echo $_SESSION["username"]; ?></a>
    <?php } else { ?>
    <a href="create_account.php" class="button">Login</a>
    <?php } ?>
    <?php  require_once 'connectionDB.php';
        $query = 'SELECT checkAdmin, uid FROM users WHERE checkAdmin = 1';
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
            <button type = "submit" name = "submit"> <!-- Add HTML/CSS here --></button>
        </form>
    </div>
    <a href= "home.php" class = "button"><!-- Add HTML/CSS here --></a>
    <a href= "settings.php" class = "button"><!-- Add HTML/CSS here --></a>
    <a href = "logout.php" class = "button">Logout</a>
</div>
<!-- END-NAV -->

<?php
    if (isset($_GET['uid'])) {
        $uid = $_GET['uid'];
        // Retrieve information for the specified user
        $sql = "SELECT username, date, profilepic FROM users WHERE uid = $uid";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        $date = $row['date'];
        $profilepic_pic = $row['profilepic'];
        // Format the account creation date as a human-readable date
        $join_date = date('F Y', strtotime($date));
    } else {
        // Retrieve information for the logged-in user
        $uid = $_SESSION['uid'];
        $sql = "SELECT username, date, profilepic FROM users WHERE uid = $uid";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        $date = $row['date'];
        $profilepic_pic = $row['profilepic'];
        // Format the account creation date as a human-readable date
        $join_date = date('F Y', strtotime($date));
    }
?>

<!-- POST QUERIES -->
<?php 
require_once 'connectionDB.php';
require_once "updateLikes.php";

if(isset($_GET['submit'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    //query that checks search term using LIKE
    $query = "SELECT p.*, u.username, u.uid, c.name FROM content p 
    INNER JOIN users u ON p.author  = u.uid
    INNER JOIN communities c on p.com_id = c.com_id
    WHERE (p.title LIKE '%$search_term%'
    OR c.name LIKE '%$search_term%')
    AND p.author = $uid";
} else {
    //query to show all content
    $query = "SELECT p.*, u.username, u.uid, c.name FROM content p 
    INNER JOIN users u ON p.author = u.uid
    INNER JOIN communities c ON p.com_id = c.com_id
    WHERE p.author = $uid";
}
$result = mysqli_query($conn, $query);
?>
<body>
<!-- Add HTML/CSS here -->
<!-- END POST QUERIES -->
<!-- DISPLAY content -->
<div class = "flex-container">
    <div class = "flex">
        <!-- Add HTML/CSS here -->
        <div class = "scroll">
        <?php 
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['name'];
            $com_id = $row['com_id'];
            $title = $row['title'];
            $post_id = $row['post_id'];
            $image = $row['image'];
            echo '<div class = "content">';
            echo '<div class = "top">';
            echo '<p><a href="user_account.php?uid='.$row['uid'].'">'.$row['username'].'</a></p>';
            echo '<p><a href = "community.php?com_id='.$com_id.'">'.$name.'</a></p>';
            echo '</div>';
            if($row['image'] != null) {
                echo '<div><img src="postUploads/'.$image.'"></div>';
            }
            echo '<a href="viewPost.php?post_id='.$post_id.'">'.$title.'</a>';
            echo '<div class="postContainer">';
            echo '<div class="contentcore">' . $row['score'] . '</div>';
            echo '<a href="viewPost.php?post_id='.$post_id.'" class="commentButton"><i class="fa-regular fa-comment"></i></a>';
            echo '</div>';
            echo '</div>';
        }
        ?>
        
        <script>
    function redirectToPost(post_id){
        window.location.href = "viewPost.php?post_id="+post_id;
    }
    </script>
    <!-- END DISPLAY content -->

        </div> <!-- closes scroll -->
    </div> <!-- closes flex -->


    <!-- USER INFO -->
    <div class = "flex-left"> 
        <!-- Add HTML/CSS here -->
        <div class = "popular">
        
        <?php
            if (isset($_GET['uid'])) {
                $uid = $_GET['uid'];
                // Retrieve information for the specified user
                $sql = "SELECT username, date, profilepic FROM users WHERE uid = $uid";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $username = $row['username'];
                $date = $row['date'];
                $profilepic_pic = $row['profilepic'];
                // Format the account creation date as a human-readable date
                $join_date = date('F Y', strtotime($date));
                echo '<div>';
                echo '<p>'. $username. '</p>';
                echo '<img src="uploads/'. $profilepic_pic.'" alt="profilepic Picture">';
                echo '<p><strong>Joined:</strong>'.$join_date.'</p>';
                echo '</div>';
            } else {
                // Retrieve information for the logged-in user
                $uid = $_SESSION['uid'];
                $sql = "SELECT username, date, profilepic FROM users WHERE uid = $uid";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $username = $row['username'];
                $date = $row['date'];
                $profilepic_pic = $row['profilepic'];
                // Format the account creation date as a human-readable date
                $join_date = date('F Y', strtotime($date));
                // Display the logged-in user's information
                echo '<div>';
                echo '<p>'. $username. '</p>';
                echo '<img src="uploads/'. $profilepic_pic.'" alt="profilepic Picture">';
                echo '<p><strong>Joined:</strong>'.$join_date.'</p>';
                echo '</div>';
            }
        ?>
        </div>
    </div>
</div>
<!-- END USER INFO -->
</div>
<div class = "categories">
    <!-- Add HTML/CSS here -->
    <?php 
    require_once 'connectionDB.php';
    if(isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];
    $query = "SELECT c.name, u.com_id FROM communities c JOIN user_community u ON c.com_id = u.com_id WHERE u.uid = '$uid' LIMIT 7";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)) {
    $com_id = $row['com_id'];
    $name = $row['name'];
    echo '<form method="post" action="leaveCommunity.php">';
    echo '<input type="hidden" name="com_id" value="'.$com_id.'">';
    echo '<button type="submit" class="deleteButton"><!-- Add HTML/CSS here --></button>';
    echo '<p><a href="community.php?com_id='.$com_id.'">'.$name.'</a></p>';
    echo '</form>';
    }
    } else {
    echo '<p> Login To Join Communities </p>';
    }
    ?>
    <a href="createCommunity.php" class = "button">Create</a>
</div>

</div> <!-- this closes flex left -->

<div class = "flex-right"> 
    <!-- Add HTML/CSS here -->
    <div class = "popularAdmin">
        <div class = "scroll">
    <?php
        // Get the comments for the current post
      //Retrieve user's comments from the database
      if(isset($_GET['uid'])) {
        // use the user ID from the URL instead of the session user ID
        $uid = $_GET['uid'];
    } else {
        // use the session user ID if no user ID is specified in the URL
        $uid = $_SESSION['uid'];
    }
      $sql = "SELECT comments.content, content.title, content.post_id, communities.name 
              FROM comments 
              JOIN content ON comments.post_id = content.post_id 
              JOIN communities ON content.com_id = communities.com_id 
              WHERE comments.author = $uid";
      
      $result = mysqli_query($conn, $sql);
      
      // Display user's comments on the page
      
      while ($row = mysqli_fetch_assoc($result)) {
          $content = $row['content'];
          $post_title = $row['title'];
          $post_id = $row['post_id'];
          $name = $row['name']; 
        echo '<a href="viewPost.php?post_id='.$post_id.'">'.$post_title.'</a>';
        echo '<p>'.$content.'</p>';
        echo '<hr>';
      }
    ?>
    </div>

</div>

</div> <!-- this closes flex right -->
</div>
</body>
<footer>
    <!-- Add HTML/CSS here -->
</footer>

</html>
