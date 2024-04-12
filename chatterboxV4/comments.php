<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Chatterbox</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <?php
                    require_once 'connectionDB.php';
                    if (!isset($_SESSION["username"])) {
                        echo '<li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
              </li>';
                    } else {
                        echo '<li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
              </li>';
                        echo '<li class="nav-item">
                <a class="nav-link" href="users_account.php">My Account</a>
              </li>';
                    }

                    ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Options
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="create_community.php">Create a Chatterbox</a></li>
                            <li><a class="dropdown-item" href="community_list.php">Find a Chatterbox</a></li>
                            <li><a class="dropdown-item" href="join_com.php">Join a Chatterbox</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="createPost.php">Create a Chat</a></li>
                        </ul>
                    </li>
                </ul>
                <form id="searchcomm" class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="breadcrumbs">
        <ul>
            <li><a href="index.php">Home</a> |</li>
            <li>
                <p>View Post</p>
            </li>
        </ul>
    </div>
    <div class="post" style="margin-left: 50px;">
        <?php
        session_start();
        require_once 'connectionDB.php';
        $post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
            // Assuming you have a way to identify the logged-in user (e.g., $_SESSION['uid'])
            $uid = $_SESSION['uid']; // Make sure this is properly sanitized and validated
            $comment = trim($_POST['comment']);

            if (!empty($comment)) {
                $stmt = $conn->prepare("INSERT INTO comments (con_id, author, text, date, likes) VALUES (?, ?, ?, NOW(), ?)");
                $likes_initial_value = 0; // Assuming you want to start with 0 likes
                $stmt->bind_param("iisi", $post_id, $user_id, $comment, $likes_initial_value);
                if ($stmt === false) {
                    die("Prepare failed: " . $conn->error);
                }
                $stmt->execute();
                $stmt->close();
            }
        }

        if ($post_id > 0) {
            $stmt = $conn->prepare("SELECT * FROM content WHERE content_id = ?");
            $stmt->bind_param("i", $post_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $post = $result->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<h2>" . htmlspecialchars($post['title']) . "</h2>";
                echo "<p>" . htmlspecialchars($post['text']) . "</p>";
                echo "<a href='updateLikes.php?post_id=$post_id&vote=like'>Like</a> " . $post['likes'];
                echo "</div>";

                // Display the comment form
                echo "<form action='' method='post'>";
                echo "<textarea name='comment' placeholder='Write a comment...'></textarea>";
                echo "<br><button type='submit'>Submit</button>";
                echo "</form>";

                // Fetch and display comments for the post
                $stmt = $conn->prepare("SELECT c.text, u.username, c.date FROM comments c JOIN users u ON c.author = u.uid WHERE c.con_id = ? ORDER BY c.date DESC");
                $stmt->bind_param("i", $post_id);
                $stmt->execute();
                $comments_result = $stmt->get_result();

                if ($comments_result) {
                    while ($comment = $comments_result->fetch_assoc()) {
                        echo "<div class='comment'>";
                        echo "<strong>" . htmlspecialchars($comment['username']) . "</strong>: ";
                        echo htmlspecialchars($comment['text']);
                        echo "<span style='float: right;'>" . htmlspecialchars($comment['date']) . "</span>";
                        echo "</div>";
                    }
                }
            } else {
                echo "Post not found.";
            }
            $stmt->close();
        } else {
            echo "Invalid post ID.";
        }
        ?>

    </div>

</body>

</html>