<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

require_once './check-login.php';
require_once './helpers/department.helper.php';
require_once './helpers/doctors.helper.php';
?>

<?php
// include the header files
$page_title = "Admin - Add Department";
require_once APP_ROOT . '/admin/inc/header.inc.php';
require_once APP_ROOT . '/admin/inc/top-bar.inc.php';

$isErr = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(empty($_POST['department'])) {
        $isErr = true;
        $error = "Department is required.";
    } else {
        $dep = $_POST['department'];
        $sql = "INSERT INTO `departments` (name) VALUES ('$dep')";
        $res = $conn->query($sql);
        if($res) {
            header('location: departments.php');
            exit();
        } else {
            $isErr = true;
            $error = "Some error occured";
        }
    }
}

?>

<!-- Login Form -->
<main class="bg- w-full h-full flex justify-center items-center">
    <div class="bg-white p-8 rounded shadow-md max-w-xs w-full">
        <h2 class="text-2xl font-semibold text-center mb-4">Login</h2>
        <p class="text-red-500 text-md italic"><?php echo $error ?></p>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="mb-4">
                <label for="department" class="block text-gray-700 text-sm font-bold mb-2">Department</label>
                <input type="text" id="department" name="department" placeholder="Enter department name" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
            </div>
            <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded-md font-semibold text-sm hover:bg-green-600 focus:outline-none focus:bg-green-600">Add</button>
        </form>
    </div>
</main>

<?php
require_once APP_ROOT . '/admin/inc/footer.inc.php';
?>