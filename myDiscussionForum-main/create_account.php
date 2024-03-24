<?php 
    session_start();
    require 'connectionDB.php';
    if(!empty($_SESSION['uid'])) {
        header('Location: index.php');
    }
    if(isset($_POST['submit'])) {
        $username = $_POST['new-username'];
        $email = $_POST['email'];
        $password = $_POST['new-password'];
        $confirm_password = $_POST['confirm-password'];
        if(isset($_FILES['profilepic']) && $_FILES['profilepic']['error'] == 0) {
            $fileName = basename($_FILES["profilepic"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);    
            $allowedTypes = array("jpg", "jpeg", "png", "gif");
            if(!in_array($fileType, $allowedTypes)) {
                echo "<script>alert('File must be an image.');</script>";
                exit;
            } 
            $uploadDir = "ProfilePics/";
            $uploadPath = $uploadDir . $fileName;
            if(move_uploaded_file($_FILES["profilepic"]["tmp_name"], $uploadPath)) {
                $profilepicPicPath = $uploadPath;
            } else {
                echo "<script>alert('Error uploading file.');</script>";
                exit;
            }
        }
        $stmt = mysqli_stmt_init($conn);
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "<script> alert('SQL statement failed! ');</script>";
            echo "Error: " . mysqli_error($conn);
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $username, $email);
            mysqli_stmt_execute($stmt);
            $exists = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($exists)> 0){
                echo "<script>alert('Username or email already exists');</script>";
            }else{
                if($password == $confirm_password) {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users (username, email, password, profilepic) VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "<script> alert('SQL statement failed! ');</script>";
                        echo "Error: " . mysqli_error($conn);
                    } else {
                        // Bind parameters to the placeholder
                        $profilepic = isset($profilepicPicPath) ? $profilepicPicPath : null;
                        mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $password, $profilepic);
                    
                        // Run parameters inside database
                        if(mysqli_stmt_execute($stmt)){
                            echo "<script> alert('Account has been created successfully! ');</script>";
                        } else {
                            echo "<script> alert('Failed to execute the statement! ');</script>";
                            echo "Error: " . mysqli_stmt_error($stmt);
                        }
                    }
                } else {
                    echo "<script> alert('Passwords do not match! ');</script>";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Create Account</title>
</head>
<body>
    <!-- ADD The login and Create account stuff here  -->
        <h1>Create Account</h1>

        <form name = "signupForm" action = "" method = "POST" autocomplete = "off" enctype="multipart/form-data">
            <input type="text" id="new-username" name="new-username" placeholder="Username" required value = ""><br>
            <input type="email" id="email" name="email" placeholder="Email Address" required value = ""><br>
            <input type="file" id="profile" name="profile" accept="image/*"><br>
            <input type="password" id="new-password" name="new-password" placeholder="Password" required value= ""><br>
            <input type = "password" id = "confirm-password" name = "confirm-password" placeholder="Confirm Password" required value = ""><br>
            <button class = "button" type="submit" name="submit">Create Account</button>
        </form>
        <p>Already have an account? <a href="login.php">Log in</a></p>
        <div id="passwordRules">
        <h3>Password must contain the following:</h3>
        <p id="lowLetter" class="invalid">A <b>lowercase</b> letter</p>
        <p id="upperCapital" class="invalid">An <b>uppercase</b> letter</p>
        <p id="number" class="invalid">A <b>number</b></p>
        <p id="maxLength" class="invalid">Minimum <b>8 characters</b></p>
      </div>

</body>
<footer>
    <!-- Add footer stuff here -->
</footer>
</html>