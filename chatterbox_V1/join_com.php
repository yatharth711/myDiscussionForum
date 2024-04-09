<!DOCTYPE html>
<html>
<head>
    <title>Join a Community</title>
</head>
<body>
    <h1>Join a Community</h1>
    <form action="process_join.php" method="post">
        <label for="community">Select a community:</label>
        <select id="community" name="community">
            <?php
            include 'connectionDB.php';
            
            $query = "SELECT * FROM communities";
            $result = mysqli_query($conn, $query);
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['com_id'] . "'>" . $row['name'] . "</option>";
            }
            
            mysqli_close($conn);
            ?>
        </select>
        <input type="submit" value="Join Community">
    </form>
</body>
</html>