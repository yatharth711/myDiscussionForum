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
    while($row = $communitiesResult->fetch_assoc()) {
        $communities[] = $row;
    }
}

$conn->close();
?>

<div class="container mt-5">
    
</div>


<div class="container mt-5">
    <div class="card" style="width: 18rem;">
        <?php if (!empty($user['profile'])): ?>
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
            <?php if (!empty($communities)): ?>
                <h6>Communities</h6>
                <ul class="list-group list-group-flush">
                    <?php foreach ($communities as $community): ?>
                        <!-- Display the name and description of each community the user is part of -->
                        <li class="list-group-item"><?= htmlspecialchars($community['name']) ?> - <?= htmlspecialchars($community['description']) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <a href="resetPwd.php" class="btn btn-primary">Reset Password</a>
        </div>
    </div>
</div>
