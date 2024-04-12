<?php
session_start();

include_once 'connectionDB.php';

$query = "SELECT com_id, name FROM communities";

// check if search query has been submitted
if(isset($_POST['submit'])) {
    $search = $_POST['search'];
    $query .= " WHERE name LIKE '%$search%'";
} 

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    // Here you can add HTML to format the output
    // You can also add CSS for styling
    // If needed, you can add JavaScript for interactivity
}


mysqli_close($conn);
?>
