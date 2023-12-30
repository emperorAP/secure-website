AP Tech
AP Tech is a simple login and registration system with the highly secured features that allows users to create an account, log in, and access a protected area of the website.

Installation
To install Project Title, follow these steps:

Download and install XAMPP or a similar web server package on your computer.
Open XAMPP and start Apache and MYSQL server.
Download the code of my website in your PC.
Copy the contents of the downloaded code to the htdocs directory of your XAMPP installation.
Go to the browser and type localhost/phpMyAdmin.
There are two options:
1. Create a new database in phpMyAdmin named cyberlogin and import register.sql file or
2. Import the cyberlogin.sql file located in the database directory into the database.
Update the database credentials in the db.php file located in the includes directory to match your database configuration.


How to Use?
To use the website, follow these steps:

Open your web browser and navigate to http://localhost/cyberseclogin.
Click the "Sign Up" link to create a new account.
Fill in the registration form and submit it.
Log in using the email and password you provided during registration.
Access the protected area of the website.

For Database Connection...
CyberLogin PHP Configuration
This project requires a database connection to work properly. To configure the database connection, please modify the following constants in the config.php file:

DB_HOST: The hostname of your MySQL database server.
DB_USER: The username of your MySQL database user.
DB_PASSWORD: The password of your MySQL database user.
DB_NAME: The name of your MySQL database.
Once you have updated the config.php file with the correct database connection details, you should be able to use the CyberLogin project without any issues.

Please note that if you encounter any issues with the database connection, you may need to check your MySQL server logs for more information. Additionally, if you are running this project on a public-facing server, be sure to secure your database credentials to prevent unauthorized access.


Registration and Email Verification System...
This PHP code provides registration functionality with email verification using PHPMailer library and Google reCAPTCHA.

Getting Started
To use this code, you need to have a web server with PHP and MySQL installed. You also need to create a database and a table named register with columns id, username, email, password, token, verification_code, and is_verified.

Prerequisites
PHP
MySQL
PHPMailer library
Google reCAPTCHA API key
Files
db.php: contains the database connection code.
index.php: contains the registration form and the verification code for Google reCAPTCHA.
emailverify.php: contains the code to verify the email.
PHPMailer: folder contains the PHPMailer library files.
README.md: contains the information about the code.
Configuration
In db.php, update the database credentials.
In index.php and emailverify.php, update the SMTP configuration in sendMail() function with your Gmail account credentials.
In index.php, replace the 6LdJch8lAAAAAJXJPS1h-I8Qpf5Rv9HPh5Po_tmm with your own Google reCAPTCHA secret key.\
To use this system, follow these steps:

Create a MySQL database and name it authentication.
Create a table named register inside the authentication database with the following columns:
id (int, primary key, auto-increment)
username (varchar(255))
email (varchar(255))
password (varchar(255))
verification_code (varchar(255))
is_verified (tinyint(1))
token (varchar(255))
Change the database credentials in the db.php file to match your own MySQL credentials.
Upload both register.php and login.php files to your web server.
Usage
Run index.php file in your web server.
Fill up the registration form and click on Sign Up.
If the reCAPTCHA verification succeeds, an email with a verification link will be sent to the registered email.
Click on the verification link to verify the email.
After email verification, the user will be redirected to the login page.



LOGIN...
This PHP script is used for user login authentication. It includes a reCAPTCHA verification step to prevent spam and automated attacks.

To use this script, you will need to modify the $recaptcha_secret_key variable to use your own reCAPTCHA secret key. You will also need to have a database set up with a register table that contains the user email, password (hashed), username, and verification token information.

When a user attempts to log in, the script will check their email and password against the database. If the email is invalid, the script will return an error message saying "Invalid email!". If the email is valid but the account has not been verified, the script will return an error message saying "Email not verified!". If the email is valid and the account has been verified, the script will check the password against the hashed password stored in the database. If the password is correct, the user will be redirected to the home page, and their username, email, and token will be stored in the session. If the password is incorrect, the script will return an error message saying "Invalid password!".

If the reCAPTCHA verification fails, the script will return an error message saying "Verify Captcha Please" and redirect the user to the login page.

Credits
AP Tech was created by Aashish Panthi. If you have any questions or feedback, please contact me at panthiaaashish@gmail.com.

License
AP Tech is released under the MIT License.
