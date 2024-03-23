<!-- Front end and php for communities -->
<?php
session_start();

include_once 'connectionDB.php';


if(isset($_GET['com_id'])) {
    $com_id = $_GET['com_id'];
} else {
    $com_id = 0;
}

$query = "SELECT c.com_id, c.community_name, c.description, COUNT(DISTINCT u.uid) AS totalJoined
 FROM communities c JOIN user_community u ON u.com_id = c.com_id WHERE u.com_id = $com_id";

$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($result)) {
    // Here you can add HTML to format the output
    // You can also add CSS for styling
    // If needed, you can add JavaScript for interactivity
}

require_once 'connectDB.php';
require_once "updateLikes.php";

if(isset($_GET['com_id'])) {
    $com_id = $_GET['com_id'];
} else {
    $com_id = 0;
}

$query = "SELECT p.*, u.username, u.uid, c.community_name FROM content p 
INNER JOIN users u ON p.created_by = u.uid
INNER JOIN communities c ON p.com_id = c.com_id
WHERE p.com_id = $com_id";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    // Here you can add HTML to format the output
    // You can also add CSS for styling
    // If needed, you can add JavaScript for interactivity
}
?>
