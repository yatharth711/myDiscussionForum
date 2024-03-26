<!-- <?php
session_start();
require_once 'connectionDB.php';

if (isset($_GET['submit'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    $query = "SELECT p.*, u.username, c.name FROM content p 
    INNER JOIN users u ON p.created_by = u.uid
    INNER JOIN communities c ON p.com_id = c.com_id
    WHERE p.title LIKE '%$search_term%'
    OR c.name LIKE '%$search_term%'
    OR u.username LIKE '%$search_term%'";
} else {
    $query = "SELECT p.*, u.username, c.name FROM content p 
    INNER JOIN users u ON p.created_by = u.uid
    INNER JOIN communities c ON p.com_id = c.com_id";
}

$result = mysqli_query($conn, $query);
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/admin.css">
    <!-- <script src="https://kit.fontawesome.com/41893cf31a.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatterbox</title>
</head>
<body>
    <nav>
        <ul>
            <li id="admin"><a href="#">Admin</a></li>
            <li><a href="#">Community Statistics</a></li>
            <li><a href="#">User Statistics</a></li>
        </ul>
    </nav>

    <section>
        <div id="community">
            <h3>Community Statistics</h3>
            <p>Here are a list of all the communities:</p>
            <!-- add php here -->
        </div>

        <div id="user">
            <h3>User Statistics</h3>
            <p>Here is xyz data about site use per day</p>
            <!-- add php here -->
        </div>
    </section>

   
</body>
</html>