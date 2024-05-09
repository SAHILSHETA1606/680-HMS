<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

require_once 'check-login.php';

$page_title="Change Password";
require_once APP_ROOT . '/doctor/inc/header.inc.php';
require_once APP_ROOT . '/doctor/inc/top-bar.inc.php';
$err = false;
$error = "";
$formErr="";
$id = $_GET['id'];
if ($_GET['id'] === ''){
    $err = true;
    $error = "Please Provide ID";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ((isset($_POST['oldPass']) && $_POST['oldPass'] !== '') && (isset($_POST['newPass']) && $_POST['newPass'] !== '')) {
        $sql = "SELECT password FROM doctors WHERE id=$id";
        $res = $conn->query($sql);
        if ($res) {
            $oldPass = $res->fetch_assoc()['password'];
            if (password_verify($_POST['oldPass'], $oldPass)) {
                $newPass = password_hash($_POST['newPass'], PASSWORD_BCRYPT);
                $sql = "UPDATE `doctors` SET `password` = '$newPass' WHERE `doctors`.`id` = $id";
                $res = $conn->query($sql);
                if ($res) {
                    header('location: logout.php');
                    exit();
                } else {
                    $err = true;
                    $error = "Some Error Occurred !!";
                }
            } else {
                $formErr = "Password don't match !!";
            }
        } else {
            $err = true;
            $error = "Some Error Occurred !!";
        }
    } else {
        $formErr = "Some Fields are Missing !!";
    }
}

?>
<!-- show the UI -->
<?php if ($err) {
    echo '
    <div class="flex h-full justify-center items-center">
    <div class="w-2/6 mx-auto py-10 bg-green-300 rounded-md shadow-sm">
        <h2 class="text-2xl text-center font-semibold ">' . $error . '</h2>
    </div>
</div>

    ';
} else { ?>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id ?>" method="post" class="w-1/3 h-full mx-auto mt-20 bg-white rounded-md shadow-lg flex flex-col justify-center items-center">
        <h2 class="text-red-600"><?= $formErr ?></h2>
        <div class="mb-2">
            <label for="oldPass" class="block text-gray-700 text-sm font-bold mb-2">Old Password </label>
            <input type="password" id="oldPass" name="oldPass" placeholder="Enter your Old Password" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
        </div>
        <div class="mb-2">
            <label for="newPass" class="block text-gray-700 text-sm font-bold mb-2">New Password </label>
            <input type="password" id="newPass" name="newPass" placeholder="Enter your New Password" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
        </div>
        <div class="mb-2">
            <input type="submit" value="Submit" class="w-full px-3 py-2 bg-green-500 text-lg text-white rounded-md shadow-sm cursor-pointer hover:bg-green-700 transition-all duration-100" />
        </div>
    </form>
<?php } ?>



<?php
require_once APP_ROOT . '/doctor/inc/footer.inc.php';
?>
