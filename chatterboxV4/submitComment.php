<?php


session_start();
include 'connectionDB.php'; // Ensure this path is correct

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle comment submission
    $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
    $user_id = isset($_SESSION['uid']) ? $_SESSION['uid'] : ''; // Example user ID

    // Insert the comment into the database
    $query = $conn->prepare("INSERT INTO comments (post_id, user_id, comment_text) VALUES (?, ?, ?)");
    $query->bind_param("iis", $post_id, $user_id, $comment);
    if ($query->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to insert comment']);
    }
} else {
    // Fetch and return comments for a specific post
    $post_id = isset($_GET['post_id']) ? $_GET['post_id'] : '';
    
    $query = $conn->prepare("SELECT user_id, comment_text FROM comments WHERE post_id = ?");
    $query->bind_param("i", $post_id);
    $query->execute();
    $result = $query->get_result();

    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }

    echo json_encode($comments);
}


// session_start();
// include 'connectionDB.php'; // Ensure this path is correct

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';
//     $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
//     $user_id = isset($_SESSION['uid']) ? $_SESSION['uid'] : ''; // Example user ID

//     // Insert the comment into the database
//     $query = $conn->prepare("INSERT INTO comments (post_id, user_id, comment_text) VALUES (?, ?, ?)");
//     $query->bind_param("iis", $post_id, $user_id, $comment);
//     if($query->execute()) {
//         $newCommentId = $query->insert_id;
//         $commentHtml = "<div><strong>User:</strong> {$user_id} <p>{$comment}</p></div>"; // Adjust HTML as needed
//         echo json_encode(['success' => true, 'commentHtml' => $commentHtml]);
//     } else {
//         echo json_encode(['success' => false, 'error' => 'Failed to insert comment']);
//     }
// } else {
//     echo json_encode(['success' => false, 'error' => 'Invalid request']);
// }


// session_start(); this works but referesh required
// include 'connectionDB.php'; // Include your database connection script

// $post_id = $_POST['post_id'];
// $comment = $_POST['comment'];
// $user_id = $_SESSION['uid']; // Example user ID, replace with actual logged-in user ID

// // Insert the comment into the database
// $query = $conn->prepare("INSERT INTO comments (post_id, user_id, comment_text) VALUES (?, ?, ?)");
// $query->bind_param("iis", $post_id, $user_id, $comment);
// if($query->execute()) {
//     $newCommentId = $query->insert_id;
//     $commentHtml = "<div class='comment'><p><strong>User ID:</strong> " . htmlspecialchars($user_id) . "</p><p><strong>Comment:</strong> " . htmlspecialchars($comment) . "</p></div>";

//     //$commentHtml = "<div>Some HTML structure for the comment</div>"; // Generate the HTML for the new comment
//     echo json_encode(['success' => true, 'commentHtml' => $commentHtml]);
// } else {
//     // Handle error
//     echo json_encode(['success' => false, 'error' => 'Failed to insert comment']);
// }
?>
