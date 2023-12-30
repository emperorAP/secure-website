
<?php
  require_once "db.php";
  session_start();

  $error_message = "";
  // Registration Here......
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  function sendMail($email, $v_code)
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
      $mail->Subject = 'Email Verification Link';
      $mail->Body = "Thanks for registration! Click the link below to verify your Email: <b><a href='https://localhost/cyberSecLogin/emailverify.php?email=$email&v_code=$v_code'>Click here to verify your Email</a></b>";
        // for normal check use below...
        // $mail->Body = "Thanks for registration! Click the link below to verify your Email: <b><a href='http://localhost/cyberSecLogin/emailverify.php?email=$email&v_code=$v_code'>Click here to verify your Email</a></b>";

      $mail->send();
      return true;
  } catch (Exception $e) {
      return false;
  }
  }

if (isset($_POST['signin'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    
    // password requirements
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    
    $recaptcha_secret_key = '6LdJch8lAAAAAJXJPS1h-I8Qpf5Rv9HPh5Po_tmm';
    $recaptcha_response = $_POST['g-recaptcha-response'];
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_data = array(
        'secret' => $recaptcha_secret_key,
        'response' => $recaptcha_response
    );
    $recaptcha_options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($recaptcha_data)
        )
    );
    $recaptcha_context = stream_context_create($recaptcha_options);
    $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
    $recaptcha_response_data = json_decode($recaptcha_result);
    if (!$recaptcha_response_data->success) {
        
        echo "<script>alert('reCAPTCHA verification failed!'); window.location.href='index.php';</script>";
        
        exit;
    }

    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        echo "<script>alert('Password does not meet the requirements! Include (@#,0-9,A-Z)')</script>";
        // $_SESSION['error'] = "Password does not meet the requirements! Include (@#,0-9,A-Z)";
    } else {

        $token =  bin2hex(random_bytes(15));

        // SQL Injection here......
        $emailquery = "SELECT * FROM `register` WHERE `email`=?";
        $stmt = mysqli_prepare($conn, $emailquery);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $query = mysqli_stmt_get_result($stmt);
        $emailcount = mysqli_num_rows($query);


        if ($emailcount > 0) 
        {
            echo "<script>alert('Email already exists!')</script>";
            // $_SESSION['error']="Email already exists!";
        } else {
            if ($password != $cpassword) 
            {
                echo "<script>alert('Passwords do not match!')</script>";
                // $_SESSION['error']="Passwords do not match!";
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $v_code= bin2hex(random_bytes(16));
               
                $insertquery = "INSERT INTO `register`(`username`, `email`, `password`, `token`, `verification_code`, `is_verified`) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $insertquery);
                $is_verified = 0;
                mysqli_stmt_bind_param($stmt, 'sssssi', $username, $email, $hashed_password, $token, $v_code, $is_verified);
                mysqli_stmt_execute($stmt);


                if($stmt && sendMail($_POST['email'], $v_code)){
                    echo "<script>alert('Registration successful! Check your email for account verification!')</script>";
                    // $_SESSION['success']="Registration successful! Check your email for account verification!";
                }else{
                    die('Query failed: ' . mysqli_error($conn));
                }
            }
        }
    }
} 
?>

<!-- LOGIN STARTS HERE.... -->
<?php
require_once "db.php";


if (isset($_POST['loggin'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Captcha here...
    $recaptcha_secret_key = '6LdJch8lAAAAAJXJPS1h-I8Qpf5Rv9HPh5Po_tmm';
    $recaptcha_response = $_POST['g-recaptcha-response'];
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_data = array(
        'secret' => $recaptcha_secret_key,
        'response' => $recaptcha_response
    );
    $recaptcha_options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($recaptcha_data)
        )
    );
    $recaptcha_context = stream_context_create($recaptcha_options);
    $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
    $recaptcha_response_data = json_decode($recaptcha_result);
    if (!$recaptcha_response_data->success) {
        // reCAPTCHA verification failed, display an error message
        echo '<script>alert("Verify Captcha Please"); window.location.href="index.php";</script>';

        exit;
    }

    $emailquery = "SELECT * FROM `register` WHERE `email`=?";
    $stmt = mysqli_prepare($conn, $emailquery);
    mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $query = mysqli_stmt_get_result($stmt);
        $emailcount = mysqli_num_rows($query);

    if ($emailcount) {
        $userdata = mysqli_fetch_assoc($query);
       
        if($userdata['is_verified']==1)
        {
          $hashed_password = $userdata['password'];

          if (password_verify($password, $hashed_password)) {
              $_SESSION['username'] = $userdata['username'];
              $_SESSION['email'] = $userdata['email'];
              $_SESSION['token'] = $userdata['token'];

              header('location: home.php');
          } else {
              $error_message = "Invalid password!";
      
          }
        }
        else
        {
          $error_message = "Email Not verified!";
        }
    }
    
    else {
       
        $error_message = "Invalid email!";
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <title>Login Form</title>
  </head>
  <style>
  .container .sign-in-form div.error-message {
  color: red;
  font-weight: bold;
  font-size: 16px;
}

  </style>
    <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="" method="POST" class="sign-in-form">
            <h2 class="title">LOG IN</h2>
            <?php if (!empty($error_message)) { ?>
            <div class="error-message"><?php echo $error_message; ?></div>
            <?php } ?>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="email" name="email" required />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Password" name="password" required />
            </div>
            <div>
              <a style="text-decoration: none; font-size: 16px;" href="forgotpassword.php">forgot password?</a>
            </div>
            <br>
            <div  class="g-recaptcha" data-sitekey="6LdJch8lAAAAAFjLMyHkbE73utJRSMvW78ZLxjHv"></div>
            <input name="loggin" type="submit" value="Login" class="btn solid" />
            <p class="social-text">Or Login With:</p>
            <div class="social-media">
              
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              
            </div>
          </form>
          <script>


	</script>
          <form id="signup-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="sign-up-form">
            <h2 class="title">SIGN UP</h2>
            <?php if (isset($_SESSION['error'])): ?>
            <div style="color: red; font-size: 16px; font-weight: bold;" class="error-message">
           
            <p><?php echo $_SESSION['error']; ?></p>
            </div>
            <?php unset($_SESSION['error']); // unset the session variable after displaying it ?>
            <?php endif; ?>
            <div class="success-message">
              <?php if (isset($_SESSION['success'])): ?>
                <p><?php echo $_SESSION['success']; ?></p>
                <?php unset($_SESSION['success']); // unset the session variable after displaying it ?>
              <?php endif; ?>
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Username" name="username" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" placeholder="Email" name="email" required/>
            </div>
            <div class="input-field">
              <style>
                            .eye {
                padding-right: 40px; /* adjust as needed */
              }

              .toggle-password {
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
              }
                
              </style>
              <i class="fas fa-lock"></i>
              <input class="eye" id="password" type="password" placeholder="Password" name="password" required oninput="checkPasswordStrength()" />
              <i class="fas fa-eye-slash toggle-password" onclick="togglePasswordVisibility('password')"></i>
              <br> <br>
              <span style="font-size: 14px; font-weight: bold;" id="password-strength-label"></span>             
              
            </div>
            
           
          
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input oninput="checkPasswordStrength(this)" id="cpassword" type="password" placeholder="Confirm Password" name="cpassword" required/>   
              <i class="fas fa-eye-slash toggle-password" onclick="togglePasswordVisibility('cpassword')"></i>
            </div>
            <button style="padding: 4px; z-index: 1;" type="button" onclick="generatePassword()">Generate Password</button> 
            
            <div  class="g-recaptcha" data-sitekey="6LdJch8lAAAAAFjLMyHkbE73utJRSMvW78ZLxjHv"></div>
            <input id="captcha" name="signin" type="submit" class="btn" value="Sign up" />
            <p class="social-text">Or Sign Up With:</p>
            <div class="social-media">
            
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              
            </div>
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>New member?</h3>
            <p>
              Just simply click the below button to register into the website.  
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="img/logo.png" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>Already a member?</h3>
            <p>
              If u have already signed in then simply click the button below and login into the website.
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="img/logo.png" class="image" alt="" />
        </div>
      </div>
    </div>
    <script>
function generatePassword() {
  var length = 8,
    charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]:;?><,./-=",
    password = "",
    hasUpperCase = false,
    hasNumber = false,
    hasSpecialChar = false;
  
  for (var i = 0, n = charset.length; i < length; ++i) {
    var c = charset.charAt(Math.floor(Math.random() * n));
    
    if (/[A-Z]/.test(c)) {
      hasUpperCase = true;
    } else if (/\d/.test(c)) {
      hasNumber = true;
    } else if (/[!@#$%^&*()_+~`|}{[\]:;?><,./-]/.test(c)) {
      hasSpecialChar = true;
    }
    
    password += c;
  }
  
  if (!hasUpperCase || !hasNumber || !hasSpecialChar) {
    // If the password doesn't meet the requirements, generate a new one
    return generatePassword();
  }
  
  document.getElementById("password").value = password;
  document.getElementById("cpassword").value = password;
}


function togglePasswordVisibility(inputId) {
    var inputElement = document.getElementById(inputId);
    var iconElement = inputElement.nextElementSibling;
    if (inputElement.type === "password") {
      inputElement.type = "text";
      iconElement.classList.remove("fa-eye-slash");
      iconElement.classList.add("fa-eye");
    } else {
      inputElement.type = "password";
      iconElement.classList.remove("fa-eye");
      iconElement.classList.add("fa-eye-slash");
    }
  }
 
  
  
</script>
    <script src="JS/app.js"></script>
    <script src="JS/checkPass.js"></script>



  </body>
  <script>
    var errorMessage = "<?php echo isset($_POST['loggin']) ? ( $emailcount ? ( $userdata['is_verified'] ? ( password_verify($password, $hashed_password) ? '' : 'Invalid password!' ) : 'Email not verified!' ) : 'Invalid email!' ) : ''; ?>";
    var errorMessageDiv = document.getElementById("error-message");
    errorMessageDiv.innerHTML = errorMessage;
  </script>
</html>
