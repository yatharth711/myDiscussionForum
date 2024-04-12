<?php

session_start();
if (!isset($_SESSION['uid'])) {
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Chatterbox</title>
</head>

<body>
    <h2>Chatterbox</h2>
    <nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary bg-dark" data-bs-theme="dark">
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
                        echo '<li class="nav-item">
                <a class="nav-link" href="users_account.php">My Account</a>
              </li>';
                    }

                    ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Options
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="create_community.php">Create a Chatterbox</a></li>
                            <li><a class="dropdown-item" href="community_list.php">Find a Chatterbox</a></li>
                            <li><a class="dropdown-item" href="join_com.php">Join a Chatterbox</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="createPost.php">Create a Chat</a></li>
                        </ul>
                    </li>
                </ul>
                <form id="searchcomm" class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="breadcrumbs" style="margin-top: 0;">
        <ul>
            <li><a href="index.php">Home</a> |</li>
            <li>
                <p>Create a Chatterbox</p>
            </li>
        </ul>
    </div>
    <div class="flex-create">
        <div class="createPost">
            <h4>Create a Chatterbox</h4>
            <form class="createPosts" name="createPosts" method="post" enctype="multipart/form-data" action="createPost.php" onsubmit="return(validate());">
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
    <script src="scripts/validate.js"></script>
    <script src="scripts/alert.js"></script>

</body>

</html>