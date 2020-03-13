<?php
require 'includes/config.php';
if (isset($_POST['semail'])) {
    $email = $_POST['email'];
    
    $sql = "SELECT * FROM users WHERE = '$email'";
    $res = mysqli_query($conn, $sql);
    $r = mysqli_fetch_assoc($res);
    if ($res) {
        $sqlreset = "UPDATE users SET password='project2020' WHERE email= '$email'";
        $check = mysqli_query($conn, $sqlreset);

        if ($check) {
            $password =md5('project2020');
            $to = $r['email'];
            $subject = "Your Recovered Password";

            $message = "Please use this password to login " . $password;
            $headers = "From : onchuru98@gmail.com";
            if (mail($to, $subject, $message, $headers)) {
                header('Location:forgotpassword.php?success');
            } else {
                header('Location:forgotpassword.php?errorreset?');
            }
            
        } else {
            header('Location:forgotpassword.php?couldnotreset?');
        }
    } else {
        header('Location:forgotpassword.php?fatalerror?');
    }
}
?>