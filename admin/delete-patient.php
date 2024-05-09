<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';
require_once './check-login.php';
require_once './helpers/patients.helper.php';


$err = false;
$error = '';
if (empty($_GET['id'])) {
    $error = "Please provide Id";
    $err = true;
}

// Check if a record should be deleted
$msg = "";
if (isset($_GET['delete'])) {
    $deleteID = $_GET['delete'];
    $res = delete_patient($conn, $deleteID);

    if ($res) {
        header('location: patients.php');
    } else {
        $msg = "Error deleting record: " . $conn->error;
        $err = true;
    }
}
?>
<?php
$page_title = "Delete Patient";
require_once APP_ROOT . '/admin/inc/header.inc.php';
?>
<?php
if ($err) {
    echo '
        <div class="h-full flex justify-center items-center">
        <div class="bg-red-300 w-2/6 h-1/2 rounded-md flex justify-center items-center ">
            <h4 class="text-lg text-center font-semibold">Error :' . $error . ' </h4>
        </div>
    </div>
        ';
} else {
    echo '
    <div class="w-screen h-screen flex justify-center items-center">
    <form class="w-1/4 h-1/4 bg-red-300 rounded-lg"  action="' . htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $_GET['id'] . '" method="post">
        <h1 class="text-3xl text-center my-3">Are you sure you want to delete ?</h1>
        <div class="w-full flex justify-center my-2">
            <input type="submit" value="Yes, Delete!" class="px-3 py-2 bg-red-600 hover:bg-red-800 text-white cursor-pointer transition-all duration-100  rounded-lg shadow-sm mx-2" />
            <a href="dashboard.php" class="px-3 py-2 bg-blue-600 hover:bg-blue-800 text-white cursor-pointer transition-all duration-100 rounded-lg shadow-sm mx-2">No, Go Back!</a>
        </div>
    </form>
</div>
    ';
}
?>
