
        <?php 
        require_once 'connectionDB.php';
        $query = 'SELECT c.name, u.com_id, COUNT(u.uid)as numJoined FROM communities c JOIN user_communities u
         ON c.com_id = u.com_id GROUP BY c.com_id ORDER BY numJoined DESC
        LIMIT 5';
        $result = mysqli_query($conn, $query);
        echo '<p>Top Communities</p>';
        while($row = mysqli_fetch_assoc($result)) {
        $com_id = $row['com_id'];
        $name = $row['name'];
        echo '<p><a href = "community.php?com_id='.$com_id.'">'.$name.'</a></p>';
        }
         ?>
 
    <div class = "categories">
        <p>Communities</p>
        
        <?php 
        require_once 'connectionDB.php';
        if(isset($_SESSION['uid'])) {
        $uid = $_SESSION['uid'];
        $query = "SELECT c.name, u.com_id FROM communities c JOIN user_communities u ON c.com_id = u.com_id WHERE u.uid = '$uid' LIMIT 7";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
        $com_id = $row['com_id'];
        $name = $row['name'];
        echo '<form method="post" action="leaveCommunity.php">';
        echo '<input type="hidden" name="com_id" value="'.$com_id.'">';
        echo '<button type="submit" class="deleteButton1"><!-- Add HTML/CSS here --></button>';
        echo '<p><a href="community.php?com_id='.$com_id.'">'.$name.'</a></p>';
        echo '</form>';
        }
    } else {
        echo '<p> Login To Join Communities </p>';
    }
         ?>
        <a href="createCommunity.php" class = "button">Create</a>
        <a href="communityList.php" class = "button">Join</a>

    </div>

</div>
</div>
<!-- Add JavaScript here -->
</body>
<footer>
    <!-- Add HTML/CSS here -->
</footer>

</html>
