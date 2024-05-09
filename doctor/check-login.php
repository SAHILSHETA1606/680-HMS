<?php
session_start();
// Check if the user is already logged in
if(!(isset($_SESSION['isLoggedIn'])) || $_SESSION['isLoggedIn'] === false) {
    // if user is not logged in
    http_response_code(403);
    header('location: '.ROOT_URL.'/doctor/login.php' );
    exit();
} else {
    // check if user is admin or (patient or doctor) and redirect them to their respective pages
    if ($_SESSION['user'] !== 'doctor') {
        $user = $_SESSION['user'];
        http_response_code(401);
        header('location: '.ROOT_URL.'/'.$user.'/');
        exit();
    }
}