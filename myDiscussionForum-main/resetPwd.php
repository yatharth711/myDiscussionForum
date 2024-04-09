<?php
session_start();
require 'connectionDB.php';
$action = "input_email";
if(isset($_GET['action'])) {
    $action = $_GET['action'];
}

if(count($_POST) > 0) {
    switch($action) {
        case "input_email":
        $email = $_POST['email'];
      //users table
      if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $error[] = "Please enter a valid email !";
      }elseif(!valid_email($email)){
        $error[] = "That email was not found !";
      }else{
        $_SESSION['forgot']['email'] = $email;
        send_email($email);
        header("Location: resetPwd.php?mode=enter_code");
        die;
      }
      break;

        case 'enter_code':
        // temp_id table
        $code = $_POST['code'];
        $result = is_code_correct($code);  
        if($result == "The temp matched successfully") {  
          $_SESSION['forgot']['code'] = $code;
          header("Location: resetPwd.php?mode=enter_password");
          die;
        }else{
          $error[] = $result;
        }
        break;
        case 'enter_password':            
            $password = $_POST['password'];
            $password2 = $_POST['password2'];      
            if($password !== $password2){
              $error[] = "Passwords do not match";
            }elseif(!isset($_SESSION['forgot']['email']) || !isset($_SESSION['forgot']['code'])){
              header("Location: resetPwd.php");
              die;
            }else{              
              save_password($password);
              if(isset($_SESSION['forgot'])){
                unset($_SESSION['forgot']);
              }      
              header("Location: login.php");
              die;
            }
            break;
          
          default:
            
            break;
    }

}
function send_email($email){
    global $conn;
    $end = time() + (120 * 1);
    $code = rand(1000,9999);
    $email = addslashes($email);
  
    $sql = "insert into temp_id (email,code,end) value ('$email','$code','$end')";
    mysqli_prepare($conn,$sql);
  
     $to = $email;
     $subject = 'Password reset for Forum website';
     $message = 'Your Password reset code is ' . $code;
     $headers = 'From: webmaster@example.com' . "\r\n" .
       'Reply-To: webmaster@example.com' . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
   
     mail($to, $subject, $message, $headers);
    
  }
  function save_password($password){ 
    global $conn;  
    $password = password_hash($password, PASSWORD_DEFAULT);
    $email = addslashes($_SESSION['forgot']['email']);  
    $sql = "update users set password = '$password' where email = '$email' limit 1";
    mysqli_prepare($conn,$sql);
  
  }
  function valid_email($email){
    global $conn;  
    $email = addslashes($email);  
    $query = "select * from users where email = '$email' limit 1";		
    $result = mysqli_query($conn,$query);
    if($result){
      if(mysqli_num_rows($result) > 0)
      {
        return true;
       }
    }
  
    return false;
  
  }
  function is_code_correct($code){
    global $conn;
  
    $code = addslashes($code);
    $expire = time();
    $email = addslashes($_SESSION['forgot']['email']);
  
    $query = "select * from temp_id where code = '$code' && email = '$email' order by id desc limit 1";
    $result = mysqli_query($conn,$query);
    if($result){
      if(mysqli_num_rows($result) > 0)
      {
        $row = mysqli_fetch_assoc($result);
        if($row['expire'] > $expire){
  
          return "The temp matched successfully";
        }else{
          return "Expired code";
        }
      }else{
        return "Incorrect code";
      }
    }
  
    return "Code is not valid";
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
        
  </head>
  <body>
        <!-- Edit the reset password php , css and html here -->
        <div class="conntainer">
      <h2>Forgot Password</h2>
      
    
    <?php 

switch ($mode) {
  case 'enter_email':
    // code...
    ?>
      <form method = "POST" action="resetPwd.php?mode=enter_email">
        <label for="email">Email:</label>
        <span style="font-size: 12px;color:red;">
							<?php 
								foreach ($error as $err) {
									// code...
									echo $err . "<br>";
								}
							?>
							</span>
        <input type="email" id="email" name="email" placeholder="Enter your email address">
        <input type="submit" value="Reset Password">
      </form>
      <?php				
					break;

				case 'enter_code':
					// code...
					?>
						<form method="post" action="resetPwd.php?mode=enter_code"> 
							
							<h3>Enter your the code sent to your email</h3>
							<span style="font-size: 12px;color:red;">
							<?php 
								foreach ($error as $err) {
									// code...
									echo $err . "<br>";
								}
							?>
							</span>

							<input class="textbox" type="text" name="code" placeholder="12345"><br>
							<br style="clear: both;">
							<input type="submit" value="Next &#187;">
							<a href="resetPwd.php">
								<input type="button" value="Start Over" style = "width:25%;">
							</a>
							<br><br>
						</form>
					<?php
					break;

				case 'enter_password':
					// code...
					?>
						<form method="post" action="resetPwd.php?mode=enter_password"> 
							<h3>Enter your new password</h3>
							<span style="font-size: 12px;color:red;">
							<?php 
								foreach ($error as $err) {
									// code...
									echo $err . "<br>";
								}
							?>
							</span>

							<input class="textbox" type="text" name="password" placeholder="Password"><br>
							<input class="textbox" type="text" name="password2" placeholder="Retype Password"><br>
							<br style="clear: both;">
							<input type="submit" value="Next" style="float: right;">
							<a href="resetPwd.php">
								<input type="button" value="Start Over">
							</a>
							<br><br>
						</form>
					<?php
					break;
				
				default:
					
					break;
			}

		?>


    </div>
    
  </body>
</html>

