<!DOCTYPE html>
<html>
<head>
    <title>Create a Chatterbox</title>
</head>
<body>
    <div class="form-container">
        <form method="post" action="">
            <input type="text" name="name" placeholder="Community Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="submit" value="Create Community">
        </form>
    </div>
</body>
</html>
<?php
session_start();



include 'connectionDB.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $community_name = $_POST['name'];
    $description = $_POST['description'];
    $query = "INSERT INTO communities (name, description) VALUES ('$community_name', '$description')";
    $result = mysqli_query($conn, $query);
    header("Location: index.php");
    mysqli_close($conn);
}
?>