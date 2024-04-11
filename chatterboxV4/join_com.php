<?php
session_start();
if(!isset($_SESSION['uid'])) {
    header("Location: login.php");
    die;    
    }
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <title>Join a Community</title>
</head>
<body>
<nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Join Chatterbox</li>
  </ol>
</nav>
    <h1>Join a Chatterbox</h1>
    <form action="process_join.php" method="post">
        <label for="community">Pick Chatterbox:</label>
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
            // Connect to the database
            include 'connectionDB.php';            
            // Get all communities from the database
            $query = "SELECT * FROM communities";
            $result = mysqli_query($conn, $query);            
            // Loop through each com_id and create an option element for the select element
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['com_id'] . "'>" . $row['name'] . "</option>";
            }
            
            // Close the database connection
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