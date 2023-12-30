<?php
    session_start();

    if (!isset($_SESSION['email']) ) {

        header("Location: index.php");
       
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Website</title>
    <link rel="stylesheet" href="CSS/styleHome.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">AP TECH</div>
            <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
            <div class="user">
                <div class="svg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                        <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                        <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"></path>
                    </svg>
                </div>
                <?php echo $_SESSION['username']; ?>
            </div>
            <li class="logout">
                <a href="logout.php">
               
                    Log out
                </a>
            </li>
            </ul>
        </nav>


        <div class="header-content">
            <h1>Welcome, <?php echo $_SESSION['username']; ?> to our AP TECH</h1>
            <p style="margin: auto;">We provide top-notch security solutions for businesses and individuals.</p>
            <br>    
            <a href="#" class="btn">Learn More</a>
        </div>
    </header>

    <section class="services">
        <h2>Our Services</h2>
        <div class="service-items">
            <div class="service-item">
                <img src="https://www.springboard.com/blog/wp-content/uploads/2022/02/is-cybersecurity-hard-scaled.jpg" alt="Secured Website">
                <h3>Secured Website</h3>
                <p></p>
            </div>
            <div class="service-item">
                <img src="https://futureskillsprime.in/sites/default/files/inline-images/iStock-1174366497.jpg" alt="Secured Database">
                <h3>Secured Database</h3>
                <p></p>
            </div>
            
        </div>
    </section>

    <section class="about">
        <h2>About Us</h2>
        <p>We are a team of security experts with years of experience in providing security solutions for businesses and individuals.</p>
        <br>
        <a href="#" class="btn">Contact Us</a>
    </section>

    <footer>
        <p>&copy; 2023 AP TECH. All Rights Reserved.</p>
    </footer>

</body>
</html>
