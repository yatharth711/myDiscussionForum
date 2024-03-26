<?php
include 'connectionDB.php';
session_start();
if(empty($_SESSION["uid"])){
    header("Location: login.php");
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $community = $_POST['community'];
    $description = $_POST['description'];
    $username = $_SESSION['uid'];

    // handle img file upload
    if(isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $fileName = basename($_FILES["img"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Check if file is an img
        $allowedTypes = array("jpg", "jpeg", "png", "gif", "heic");
        if(!in_array($fileType, $allowedTypes)) {
            // Add JavaScript alert here
            exit;
        }

        $target_dir = "postsUploads/";
        $uploadPath = $target_dir . $fileName;
        if(move_uploaded_file($_FILES["img"]["tmp_name"], $uploadPath)) {
            //insert statement if img is added
            $imgPath = $uploadPath;
            $query = "INSERT INTO content (title, text , author, com_id, img) VALUES (?,?,?,?,?)";
            $stmt = mysqli_prepare($conn,$query);
            mysqli_stmt_bind_param($stmt, "ssiis", $title, $description, $username, $community, $fileName);
            $result = mysqli_stmt_execute($stmt);
            // Add header redirection here
            mysqli_close($conn);
        } else {
            // Add JavaScript alert here
            exit;
        }
    } else {
        //insert statement for no img
        $query = "INSERT INTO content (title, text, author, com_id) VALUES (?,?,?,?)";
        $stmt = mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt, "ssii", $title, $description, $username, $community);
        $result = mysqli_stmt_execute($stmt);
        // Add header redirection here
        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Add CSS link here -->
    <!-- Add JavaScript link here -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <!-- <title>Chatterbox</title> -->
</head>

<body>
    <h2>CHATTERBOX</h2>
    <div class="flex-create">
        <div class="createPost">
            <!-- Add HTML/CSS here -->
            <form name="createPosts" method="post" enctype="multipart/form-data" action="createPost.php">
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
                <input type="text" id="description" name="description"
                    placeholder="Description (optional)"></textarea><br>
                <input type="file" id="image" name="image"><br>
                <input type="submit" value="Post" id="postButton">
            </form>
        </div>
    </div>
    <!-- Add JavaScript here -->
    <script src="script/validatePost.js"></script>

</body>
<footer>
    <!-- Add HTML/CSS here -->
</footer>

</html>