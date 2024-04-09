<!DOCTYPE html>
<html>
<head>
    <title>Join a Community</title>
</head>
<body>
    <h1>Join a Community</h1>
    <form action="process_join.php" method="post">
        <label for="community">Select a community:</label>
        <!-- <select id="community" name="community">
            <?php
            include 'connectionDB.php';
            

            $query = "SELECT * FROM communities";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {

                echo "<option value='" . $row['com_id'] . "'>" . $row['name'] . "</option>";
            }
            
            mysqli_close($conn);
            ?>
        </select> -->
        <select id="community" name="community" onchange="updateCommunityName(this)">
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
    <!-- Hidden input to store the community name -->
    <input type="hidden" id="community_name" name="community_name" value="">
        <input type="submit" value="Join Community">
    </form>

    <script>
        function updateCommunityName(selectElement){
            var selected= selectElement.options[selectElement.selectedIndex];
            document.getElementById('community_name').value= selectedOption.text;
        }
    </script>
</body>
</html>