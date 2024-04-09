<?php
include 'connectionDB.php';

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username= $_SESSION['username'];
    $stmt= $conn->prepare("select uid from users where username=?");
    $stmt-> bind_param("s", $username);
    $stmt->execute();
    $result=$stmt->get_result();
    $user_id= $result->fetch_assoc();

    $community= $_POST['community'];
    $stmt= $conn->prepare("select com_id from communities where name=?");
    $stmt-> bind_param("s", $community);
    $stmt->execute();
    $result= $stmt->get_result();
    $com_id= $result->fetch_assoc();

    $current_date = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO user_communities (uid, com_id, date) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $community_id, $current_date);

    if ($stmt->execute()) {
        echo "You have successfully joined the community!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    mysqli_close($conn);
} else {
    header('Location: join_form.php'); // Replace with actual form page
    exit();
}
?>
