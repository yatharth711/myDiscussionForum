<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start(); // Start a new session or resume the existing one
    include 'connectionDB.php'; // Include your database connection script
    
    // Retrieve username, old password, and new password from the POST request
    $username = $_POST['username'] ?? '';
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    
    if (empty($username) || empty($old_password) || empty($new_password)) {
        $error = 'Please fill all fields.';
    } else {
                // Step 2: Verify username and old password
          $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
          $stmt->bind_param("s", $username);
          $stmt->execute();
          $result = $stmt->get_result();
          $user = $result->fetch_assoc();

          if (!$user) {
              die('User not found.');
          }

          // Assuming you're using password_hash() for password storage; verify the old password
          if (!password_verify($old_password, $user['password'])) {
              die('Old password does not match.');
          }

          // Step 3: Update the password
          $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
          $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
          $update_stmt->bind_param("ss", $new_password_hash, $username);
          $update_stmt->execute();

          if ($update_stmt->affected_rows === 0) {
              die('Password reset failed.');
          }

          // Step 4: Redirect to home.php on success
          header('Location: index.php');
          exit();
              }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        .valid {
            color: green;
        }
        .invalid {
            color: red;
        }
    </style>
</head>
<body>
    <!-- Display error message if any -->
    <?php if (!empty($error)) echo "<p>$error</p>"; ?>

    <form action="resetpwd.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" id="password" name="old_password" placeholder="Old Password" required>
        <input type="password" id="new_password" name="new_password" placeholder="New Password" required>
        <button type="submit">Reset Password</button>
    </form>
    
    <div id="passwordRules" style="display:none;">
        <p id="lower" class="invalid">Contains a lowercase letter</p>
        <p id="upper" class="invalid">Contains an uppercase letter</p>
        <p id="num" class="invalid">Contains a number</p>
        <p id="len" class="invalid">Length is 8-25 characters</p>
    </div>

    <script>
        var pass = document.getElementById("new_password"); // Ensure correct ID
        var lower = document.getElementById("lower");
        var upper = document.getElementById("upper");
        var num = document.getElementById("num");
        var len = document.getElementById("len");

        pass.onfocus = function () {
            document.getElementById("passwordRules").style.display = "block";
        }

        pass.onblur = function () {
            document.getElementById("passwordRules").style.display = "none";
        }

        pass.onkeyup = function () {
            // Check for lowercase
            var lowercase = /[a-z]/g;
            if (pass.value.match(lowercase)) {
                lower.classList.remove("invalid");
                lower.classList.add("valid");
            } else {
                lower.classList.remove("valid");
                lower.classList.add("invalid");
            }

            // Check for uppercase
            var uppercase = /[A-Z]/g;
            if (pass.value.match(uppercase)) {
                upper.classList.remove("invalid");
                upper.classList.add("valid");
            } else {
                upper.classList.remove("valid");
                upper.classList.add("invalid");
            }

            // Check for numbers
            var nums = /[0-9]/g;
            if (pass.value.match(nums)) {
                num.classList.remove("invalid");
                num.classList.add("valid");
            } else {
                num.classList.remove("valid");
                num.classList.add("invalid");
            }

            // Check for length
            if (pass.value.length >= 8 && pass.value.length <= 25) {
                len.classList.remove("invalid");
                len.classList.add("valid");
            } else {
                len.classList.remove("valid");
                len.classList.add("invalid");
            }
        }
    </script>
</body>
</html>
