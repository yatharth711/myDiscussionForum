<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- ADD The login and Create account stuff here  -->
    <title>Login</title>
</head>
<body>
    <form action = "create_account.php" method = "POST">
        <!-- ADD The login and Create account stuff here  -->
        <!-- Also check tags mentioned on create_account.php -->
        <input type="text" id="new-username" name="new-username" placeholder="Username" required><br>
            <input type="email" id="email" name="email" placeholder="Email Address" required><br>
            <input type="password" id="new-password" name="new-password" placeholder="Password" required><br>
            <input type = "password" id = "confirm-password" name = "confirm-password" placeholder="Confirm Password" required><br>
            <input type="submit" value="Create Account">
    </form>
</body>
</html>

