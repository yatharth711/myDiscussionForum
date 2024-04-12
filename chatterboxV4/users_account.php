<?php
session_start();
require_once 'connectionDB.php';
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define the ID of the user you want to display information for
$userId = $_SESSION['uid']; // Example user ID. Adjust this value based on your application's context.

// Fetch information for the specified user from the database
$userQuery = "SELECT * FROM users WHERE uid = " . intval($userId);
$userResult = $conn->query($userQuery);
if ($userResult === false) {
    die("Error fetching user: " . $conn->error);
}

if ($userResult->num_rows > 0) {
    $user = $userResult->fetch_assoc();
} else {
    echo "User not found.";
    exit;
}
// if ($userResult->num_rows > 0) {
//     $user = $userResult->fetch_assoc();
// } else {
//     echo "User not found.";
//     exit;
// }

// Fetch the communities the user is a part of from the database
$communityQuery = "SELECT c.name, c.description FROM communities c JOIN user_communities uc ON c.com_id = uc.com_id WHERE uc.uid = " . intval($userId);
$communitiesResult = $conn->query($communityQuery);
$communities = [];
if ($communitiesResult === false) {
    die("Error fetching communities: " . $conn->error);
}

if ($communitiesResult->num_rows > 0) {
    while ($row = $communitiesResult->fetch_assoc()) {
        $communities[] = $row;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>

<head>
    <title>My Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
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
    <div class="breadcrumbs">
        <ul>
            <li><a href="index.php">Home</a> |</li>
            <li>
                <p>My Account</p>
            </li>
        </ul>
    </div>


    <div class="info">
        <h4 style="margin-left: 50px;"><strong>My Information</strong></h4>
        <div class="container mt-5">
            <div class="card" style="width: 18rem;">
                <?php if (!empty($user['profile'])) : ?>
                    <!-- Display the user's profile picture if available -->
                    <img src="data:image/jpeg;base64,<?= base64_encode($user['profile']) ?>" class="card-img-top" alt="Profile Picture">
                <?php endif; ?>
                <div class="card-body">
                    <!-- Display the user's username -->
                    <h5 class="card-title"><?= htmlspecialchars($user['username']) ?></h5>
                    <!-- Display the user's email -->
                    <p class="card-text">Email: <?= htmlspecialchars($user['email']) ?></p>
                    <!-- Display the date the user joined -->
                    <p class="card-text">Date Joined: <?= htmlspecialchars($user['date']) ?></p>
                    <?php if (!empty($communities)) : ?>
                        <h6>Communities</h6>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($communities as $community) : ?>
                                <!-- Display the name and description of each community the user is part of -->
                                <li class="list-group-item"><?= htmlspecialchars($community['name']) ?> - <?= htmlspecialchars($community['description']) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <a href="resetPwd.php" class="btn btn-primary" style="background-color: black; color: white; border-radius: 5px; font-size: .85em;" onmouseover="this.style.backgroundColor='#88a888'; this.style.color='#2e2e2e';" onmouseout="this.style.backgroundColor='black'; this.style.color='white';">Reset Password</a>
                </div>
            </div>
        </div>
    </div>
    <div class="mycomm">
        <?php
        include "view_communities.php";
        ?>
    </div>
</body>

</html>