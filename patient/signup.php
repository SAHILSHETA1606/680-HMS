<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';
session_start();

// Check if the user is already logged in
if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"] === true) {
    header("location: ".ROOT_URL.'/admin/dashboard.php');
    exit();
}

$page_title="Signup";
require_once APP_ROOT . '/patient/inc/header.inc.php';
$error = false; // changes when there is an error
$usernameErr = '';
$emailErr = '';
$passErr = '';
$paIdErr='';
$sqlErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_regenerate_id();
    if (empty($_POST['username'])) {
        $usernameErr = "Username cannot be empty";
        $error = true;
    }
    if (empty($_POST['email'])) {
        $emailErr = "Email cannot be empty";
        $error = true;
    } else {
        // check if email is valid
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid Email !";
            $error = true;
        } else {
            //if email is valid
            // check if email is unique
            $sql = "SELECT * FROM `patient` WHERE `email`='" . $_POST['email'] . "'";
            $result = $conn->query($sql);
            if ($result->num_rows != 0) {
                $emailErr = "This Email already exists.";
                $error = true;
            } else {
                // there is no error
                $emailErr = "";
                $email = $_POST['email'];
                // check if this email is alredy registered in `patient_details`
                $sql = "SELECT * FROM `patient_details` WHERE email = '$email'";
                $res = $conn->query($sql);
                if ( $res -> num_rows === 0 ) {
                    $error = true;
                    $emailErr = 'There is no Patient with this email !!';
                }
            }
        }
    }



    if (empty($_POST['password'])) {
        $passErr = "Password cannot be empty";
        $error = true;
    } else {
        $passErr = "";
        $password = $_POST['password'];
    }
    // if there is no error till now
    if (!$error) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        // add user in admin
        $sql = "INSERT INTO `patient` (`username`, `email`, `password`) VALUES ('$username', '$email', '$hashedPassword');";
//        die($sql);
        $result = $conn->query($sql);

        if ($result) {
            session_regenerate_id();
            header('location: login.php');
            exit;
        } else {
            $sqlErr = "Error : ". $conn->error;
        }
    }
}

?>

<main class="bg-gray-200 w-screen h-screen flex justify-center items-center">
    <div class="bg-white p-8 rounded shadow-md max-w-xs w-full">
        <h2 class="text-2xl font-semibold text-center mb-4">Signup</h2>
        <p class="text-red-500 text-md italic"><?php echo $sqlErr ?></p>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
                <p class="text-red-500 text-xs italic"><?php echo $usernameErr ?></p>

            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email (registered by patient)" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
                <p class="text-red-500 text-xs italic"><?php echo $emailErr ?></p>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
                <p class="text-red-500 text-xs italic"><?php echo $passErr ?></p>
            </div>
            <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded-md font-semibold text-sm hover:bg-green-600 focus:outline-none focus:bg-green-600">Signup</button>
        </form>
        <p class="text-sm text-gray-600 mt-4 text-center">Already have an account? <a href="login.php" class="text-green-500 hover:underline">Login</a></p>
    </div>
</main>


