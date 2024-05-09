<?php
session_start();
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) {
    // if user is isLoggedIn then logout the user
    session_unset();
    session_destroy();
}
header('location: login.php');
exit();
