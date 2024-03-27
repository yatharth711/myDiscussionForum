<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .form-container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container input[type="text"],
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container input[type="submit"] {
            padding: 10px 20px;
            border: none;
            background-color: #008CBA;
            color: white;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #007B9A;
        }
    </style>
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

// if(empty($_SESSION["uid"])){
//     header("Location: login.php");
// }

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

