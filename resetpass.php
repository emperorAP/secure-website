<?php
    require("db.php");
    if(isset($_GET['email']) && isset($_GET['reset_token']))
    {
        date_default_timezone_set('Asia/kathmandu');
        $date=date("Y-m-d");

        $sql="SELECT * FROM `register` WHERE `email`='{$_GET['email']}' AND `resettoken`='{$_GET['reset_token']}' AND `resettokenexpire`='$date'";
        $result=mysqli_query($conn, $sql);
        if ($result) 
        {
            if (mysqli_num_rows($result) == 1) 
            {
                if(isset($_POST['submit']))
                {
                    $email = $_GET['email'];
                    $password = mysqli_real_escape_string($conn, $_POST['password']);
                    $confirm_password = mysqli_real_escape_string($conn, $_POST['cpassword']);
                    if($password!=$confirm_password){
                      echo "<script>alert('Passwords not matched!');</script>";

                    }
                    else{

                    
                    if(preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*\W).{8,}$/', $password) && $password == $confirm_password) {
                      $password_hash = password_hash($password, PASSWORD_BCRYPT);
                      $update_query = "UPDATE `register` SET `password`='$password_hash', `resettoken`=NULL, `resettokenexpire`=NULL WHERE `email`='$email'";
                      $result = mysqli_query($conn, $update_query);
                  
                      if($result) {
                          echo "<script>alert('Password Updated Successfully!'); window.location.href='index.php';</script>";
                      } else {
                          echo "<script>alert('Server down!');window.location.href='index.php';</script>";
                      }
                  } else {
                      echo "<script>alert('Password must have 8 characters including one number, one capital letter, one special character!');window.location.href='resetpass.php';</script>";
                      
                      exit();
                  }
                }
                } 
            } else {
                echo "<script>alert('Invalid or expired link!');
                window.location.href='index.php';</script>";
            }
        } else {
            echo "<script>alert('Server down!');
            window.location.href='index.php';</script>";
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
    <title>reset password</title>
  </head>
  <body>
  <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="" method="POST" class="sign-in-form">
            <h2 class="title">change your password</h2>
           
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input id="pass" oninput="checkPasswordStrength()" type="password" placeholder="enter new password" name="password" />
              <br>
              <span style="font-size: 14px; font-weight: bold;" id="PSL"></span>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input id="cpass" oninput="checkPasswordStrength(this)" type="password" placeholder="confirm new password" name="cpassword" />
            </div>
           
            <input name="submit" type="submit" value="verify" class="btn solid" />  
            </div>
          </form>
        </div>
      </div>

      
    <script src="JS/app.js"></script>
    
    <script>
      function checkPasswordStrength() {
  const passwordField = document.getElementById("pass");
  const confirmPasswordField = document.getElementById("cpass");
  const password = passwordField.value;
  const passwordStrengthLabel = document.getElementById(
    "PSL"
  );

  if (document.activeElement !== passwordField && document.activeElement == confirmPasswordField) {
    passwordStrengthLabel.innerHTML = "";
    return;
  }
  else{

    let strength = 0;
    if (password.length >= 8) {
      strength += 1;
    }
    if (password.match(/[a-z]/)) {
      strength += 1;
    }
    if (password.match(/[A-Z]/)) {
      strength += 1;
    }
    if (password.match(/[0-9]/)) {
      strength += 1;
    }
    if (password.match(/[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/)) {
      strength += 1;
    }

    if (password.length === 0) {
      passwordStrengthLabel.innerHTML = "";
    } else if (strength === 1) {
      passwordStrengthLabel.innerHTML = "Weak";
      passwordStrengthLabel.style.color = "red";
    } else if (strength === 2 || strength === 3) {
      passwordStrengthLabel.innerHTML = "Medium";
      passwordStrengthLabel.style.color = "orange";
    } else if (strength >= 4) {
      passwordStrengthLabel.innerHTML = "Strong";
      passwordStrengthLabel.style.color = "green";
    }
  }
}

    </script>
  </body>
</html>
