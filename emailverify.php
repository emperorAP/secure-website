<?php
require "db.php";

if(isset($_GET['email']) && isset($_GET['v_code'])) {
    $email = mysqli_real_escape_string($conn, $_GET['email']);
    $v_code = mysqli_real_escape_string($conn, $_GET['v_code']);
    $sql = "SELECT * FROM `register` WHERE `email`='$email' AND `verification_code`='$v_code'";
    $result = mysqli_query($conn, $sql);
    if($result) {
        if(mysqli_num_rows($result) == 1) {
            $result_fetch = mysqli_fetch_assoc($result);
            if($result_fetch['is_verified'] == 0) {
                $update = "UPDATE `register` SET `is_verified`='1' WHERE `email`='$result_fetch[email]'";
                if(mysqli_query($conn, $update)) {
                    echo "<script>alert('Email Successfully Verified!');
                    window.location.href='index.php';</script>";
                } else {
                    echo "<script>alert('Can\'t run query!');
                    window.location.href='index.php';</script>";
                }
            } else {
                echo "<script>alert('Email already verified!');
                window.location.href='index.php';</script>";
            }
        }
    } else {
        echo "<script>alert('Can\'t run query!');
        window.location.href='index.php';</script>";
    }
}
?>
