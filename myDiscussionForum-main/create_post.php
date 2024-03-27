<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Add CSS link here -->
    <!-- Add JavaScript link here -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeChat</title>
</head>
<body>
<div class = "flex-create">
    <div class = "createPost">
        <!-- Add HTML/CSS here -->
        <form name = "createPosts" method = "post"  enctype="multipart/form-data" action = "create_post.php">
            <input type="text" id="title" name="title" placeholder="Title"><br>
            <select id="community" name="community">
                <option value="">Choose Community</option>
                <?php
                    // Connect to the database
                    include 'connectionDB.php';
                    
                    // Get all communities from the database
                    $query = "SELECT * FROM communities";
                    $result = mysqli_query($conn, $query);
                    
                    // Loop through each community and create an option element for the select element
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['com_id'] . "'>" . $row['name'] . "</option>";
                    }
                    
                    // Close the database connection
                    mysqli_close($conn);
                ?>
            </select><br>
            <input id="description" name="description" placeholder="Description (optional)"></textarea><br>
            <input type="file" id="image" name="image"><br>
            <input type="submit" value="Post" id="postButton">
        </form>
    </div>
</div>
<!-- Add JavaScript here -->
</body>
<footer>
    <!-- Add HTML/CSS here -->
</footer>
</html>

</body>
</html>
<?php
include 'connectionDB.php';
session_start();
// if(empty($_SESSION["uid"])){
//     header("Location: login.php");
// }

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $community = $_POST['community'];
    $description = $_POST['description'];
    // $username = $_POST['uid'];

        $query = "INSERT INTO content (title, text, com_id) VALUES (?,?,?)";
        $stmt = mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt, "ssi", $title, $description, $community);
        $result = mysqli_stmt_execute($stmt);
    //     // Add header redirection here
        header("Location: index.php");
        mysqli_close($conn);
     }

?>
