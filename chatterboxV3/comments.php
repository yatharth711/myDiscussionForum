<?php
include 'connectionDB.php'; // Include your DB connection file

$post_id = $_GET['post_id']; // Get the post_id from the URL

// Query the post from the database
$post_query = "SELECT * FROM content WHERE content_id = ?";
$stmt = $conn->prepare($post_query);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post_result = $stmt->get_result();
if ($post_result->num_rows > 0) {
    $post = $post_result->fetch_assoc();
    // Display the post content
    echo "<h2>" . htmlspecialchars($post['title']) . "</h2>";
    echo "<p>" . htmlspecialchars($post['text']) . "</p>";
    // Add more post details as needed
}
?>
<?php
$comments_query = "SELECT * FROM comments WHERE post_id = ? ORDER BY comment_date DESC";
$stmt = $conn->prepare($comments_query);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$comments_result = $stmt->get_result();

if ($comments_result->num_rows > 0) {
    while ($comment = $comments_result->fetch_assoc()) {
        // Display each comment
        echo "<div class='comment'><p>" . htmlspecialchars($comment['comment_text']) . "</p></div>";
    }
} else {
    echo "<p>No comments yet.</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<form id="commentForm">
    <textarea name="comment" id="comment" required></textarea>
    <input type="hidden" name="post_id" value="<?= $post_id ?>">
    <button type="submit">Submit Comment</button>
</form>
<div id="commentsSection">
    <!-- New comments will be appended here -->
</div>
<script>
document.getElementById('commentForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent the default form submit action

    var formData = new FormData(this); // 'this' refers to the form

    fetch('submitComment.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Append the new comment HTML to the comments container
            location.reload();
            document.getElementById('commentsContainer').innerHTML += data.commentHtml;
        } else {
            // Handle error (you might want to display this error to the user)
            console.error(data.error);
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>


</html>

