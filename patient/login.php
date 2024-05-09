<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

session_start();

// Check if the user is already logged in
if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"] === true) {
    header("location: ".ROOT_URL.'/patient');
    exit();
}

// include header files

$page_title = "Login";
require_once APP_ROOT . '/admin/inc/header.inc.php';
?>

<?php
$isErr=false;
$error="";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error = "Missing fields !!";
        $isErr = true;
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $isErr=false;
        $error = "";
        $sql = "SELECT * FROM `patient` WHERE `email`='" . $email . "'";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            $error = "Email  not found !!";
        } else {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                // if password matches
                session_regenerate_id();
                $_SESSION['user'] = 'patient';
                $_SESSION['patientId'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['isLoggedIn'] = true;
                header('location: index.php');
                exit;
            } else {
                $error = "Incorrect password !!";
            }
        }
    }
}
?>

<!-- Login Form -->
<main class="bg-gray-200 w-screen h-screen flex justify-center items-center">
    <div class="bg-white p-8 rounded shadow-md max-w-xs w-full">
        <h2 class="text-2xl font-semibold text-center mb-4">Patient Login</h2>
        <p class="text-red-500 text-md italic"><?php echo $error ?></p>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your Email(used to register the patient)" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
            </div>
            <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded-md font-semibold text-sm hover:bg-green-600 focus:outline-none focus:bg-green-600">Login</button>
        </form>
        <p class="text-sm text-gray-600 mt-4 text-center">Don't have an account? <a href="signup.php" class="text-green-500 hover:underline">Sign Up</a></p>
    </div>
</main>

</body>
</html>