<?php

session_start();
if(!isset($_SESSION['uid'])) {
    header("Location: login.php");
    die;    
    }

include 'connectionDB.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Assuming you've validated/sanitized these inputs
    $title = $_POST['title'];
    $com_id = $_POST['com_id'];
    $description = $_POST['description'];
    $username = $_SESSION['uid']; // Ensure session is started at the top

    // Handle img file upload
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $fileName = basename($_FILES["img"]["name"]);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Check if file is an image
        $allowedTypes = array("jpg", "jpeg", "png", "gif", "heic");
        if (!in_array($fileType, $allowedTypes)) {
            echo "<script>alert('File must be an image.');</script>";
            exit;
        }

        $target_dir = "imgPosts/";
        $newFileName = uniqid('IMG_', true) . '.' . $fileType; // Generate a unique name for the file
        $uploadPath = $target_dir . $newFileName;

        if (move_uploaded_file($_FILES["img"]["tmp_name"], $uploadPath)) {
            $imgPath = $uploadPath;
            $query = "INSERT INTO content (title, text, author, com_id, img) VALUES (?, ?, ?, ?, ?)";
        } else {
            echo "<script>alert('Error uploading file.');</script>";
            exit;
        }
    } else {
        // Query for no img
        $query = "INSERT INTO content (title, text, author, com_id) VALUES (?, ?, ?, ?)";
    }

    $stmt = mysqli_prepare($conn, $query);
    
    // Bind parameters based on whether an image was uploaded
    if (isset($imgPath)) {
        mysqli_stmt_bind_param($stmt, "sssis", $title, $description, $username, $com_id, $newFileName);
    } else {
        mysqli_stmt_bind_param($stmt, "sssi", $title, $description, $username, $com_id);
    }

    // Execute and check for errors
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php"); // Redirect only on success
    } else {
        echo "<script>alert('Error: " . mysqli_stmt_error($stmt) . "');</script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel = "stylesheet" href = "css/style.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatterbox</title>
</head>
<body>
<h2>Chatterbox</h2>

    <div class = "flex-create">
        <div class = "createPost">
            <h1 style = "color:#A67EF3; font-size: 1.3em;" >Create Post</h1>
            <form class = "createPosts" name = "createPosts" method = "post"  enctype="multipart/form-data" action = "createPost.php" onsubmit="return(validate());">
                <input type="text" id="title" name="title" placeholder="Title"><br>
                <select id="com_id" name="com_id">
        <option value="">Choose Community</option>
        <?php
            // Connect to the database
            include 'connectionDB.php';            
            // Get all communities from the database
            $query = "SELECT * FROM communities";
            $result = mysqli_query($conn, $query);            
            // Loop through each com_id and create an option element for the select element
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['com_id'] . "'>" . $row['name'] . "</option>";
            }
            
            // Close the database connection
            mysqli_close($conn);
        ?>
    </select><br>
                <input id="description" name="description" placeholder="Description (optional)"></textarea><br>
                <input type="file" id="img" name="img"><br>
                <input type="submit" value="Post" id="postButton">
            </form>
        </div>
</div>
<script src = "scripts/validate.js"></script>
<script src = "scripts/alert.js"></script>

</body>
<footer>
    <p class = "tos">Terms of Service</p>
    <p class = "tos">About</p>
    <p class = "tos">Contact Us</p>
    <p class = "tos">FAQ</p>
    <p class = "tos">Privacy and Policy</p>
</footer>
</html>