<?php

require_once 'connectionDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the post ID and vote from the request
    $com_id = mysqli_real_escape_string($conn, $_POST['com_id']);

    $vote = $_POST['vote'];

    // Update the post score in the database
    if ($vote === 'up') {
        $query = "UPDATE comments SET likes = likes + 1 WHERE com_id = '$com_id'";
    } else if ($vote === 'down') {
        $query = "UPDATE comments SET likes = likes - 1 WHERE com_id = '$com_id'";
    }
    mysqli_query($conn, $query);

    // Return the new score as JSON
    $query = "SELECT CAST(likes AS UNSIGNED) as likes FROM comments WHERE com_id = '$com_id' ";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $newScore = $row['likes'];
    echo json_encode(['newScore' => $newScore]);
}

?>
