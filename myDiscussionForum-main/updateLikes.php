<?php

require_once 'connectionDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $con_id = $_POST['con_id'];
    $vote = $_POST['vote'];

    // Update the post likes in the database
    if ($vote === 'up') {
        $query = "UPDATE content SET likes = likes + 1 WHERE con_id = $con_id";
    } else if ($vote === 'down') {
        $query = "UPDATE content SET likes = likes - 1 WHERE con_id = $con_id";
    }
    mysqli_query($conn, $query);

    // Return the new likes as JSON
    $query = "SELECT likes FROM content WHERE con_id = $con_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $newlikes = $row['likes'];
    echo json_encode(['newlikes' => $newlikes]);
}

?>