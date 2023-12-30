<?php
  require "db.php";
  session_start();

  // mail sender here...
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  function sendMail($email, $reset_token)
  {
    require('PHPMailer/PHPMailer.php');
    require('PHPMailer/SMTP.php');
    require('PHPMailer/Exception.php');

    $mail = new PHPMailer(true);

    try {
      
      
      $mail->isSMTP();                                            
      $mail->Host       = 'smtp.gmail.com';                     
      $mail->SMTPAuth   = true;                                   
      $mail->Username   = 'iamapofficial7@gmail.com';                    
      $mail->Password   = 'qzkvugzvagcdjimb';                               
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
      $mail->Port       = 465;                                    
      $mail->setFrom('iamapofficial7@gmail.com', 'AP Tech');
      $mail->addAddress($email);    
      $mail->isHTML(true);                                  
      $mail->Subject = 'Password Reset Link';
      $mail->Body = "Click the link below to reset your password: <b><a href='https://localhost/cyberSecLogin/resetpass.php?email=$email&reset_token=$reset_token'>Click here to reset password</a></b>";
      
      // for normal check use below...
      // $mail->Body = "Click the link be low to reset your password: <b><a href='http://localhost/cyberSecLogin/resetpass.php?email=$email&reset_token=$reset_token'>Click here to reset password</a></b>";
        
      $mail->send();
      return true;
  } catch (Exception $e) {
      return false;
  }
  }

  if(isset($_POST['submit']))
  {
    $email = $_POST['email'];
    $sql = "SELECT * FROM `register` WHERE `email`='$email'";
    $result = mysqli_query($conn, $sql);
    if($result){
      if(mysqli_num_rows($result)==1)
      {
        $reset_token = bin2hex(random_bytes(16));
        date_default_timezone_set('Asia/kathmandu');
        $date=date("Y-m-d");
        $sql="UPDATE `register` SET `resettoken`='$reset_token', `resettokenexpire`='$date' WHERE `email`= '$email'";
        if(mysqli_query($conn, $sql) && sendMail($email, $reset_token)){
          echo "<script>alert('reset link sent successfully!'); window.location.href='index.php';</script>";
        }
        else{
          echo "<script>alert('server down!')</script>";
        }
      }
      else{
        echo "<script>alert('invalid email')</script>";
      }
    }
    else{
      echo "<script>alert('something error occured!')</script>";
    }
  }
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="CSS/style.css" />
    <title>Login Form</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="" method="POST" class="sign-in-form">
            <h2 class="title">Confirm Your Email</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="enter your email" name="email" required/>
            </div>
            <input name="submit" type="submit" value="get link" class="btn solid" />
            <input name="cancel" type="button" value="cancel" class="btn solid" onclick="window.location.href='index.php';" />
            
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="JS/app.js"></script>
  </body>
</html>
