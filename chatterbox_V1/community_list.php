<?php
session_start();

include_once 'connectionDB.php';

// check if search query has been submitted
if(isset($_POST['submit'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $query = "SELECT com_id, name FROM communities WHERE name LIKE '%$search%'";
} else {
    $query = "SELECT com_id, name FROM communities";
}

$result = mysqli_query($conn, $query);

if($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        
        $com_id = $row['com_id'];
    $name = $row['name'];
    echo '<div class="community">';
    echo '<p class="community-name" onmouseover="changeColor(this)" onmouseout="resetColor(this)"><a href = "community.php?com_id='.$com_id.'">'.$name.'</a></p>';
    echo '</div>';
    }
} else {
    echo '<p>Error: '.mysqli_error($conn).'</p>';
}

mysqli_close($conn);
?>

<!-- HTML form for the search bar -->
<form method="POST" action="">
    <input type="text" name="search" placeholder="Search communities...">
    <input type="submit" name="submit" value="Search">
</form>
