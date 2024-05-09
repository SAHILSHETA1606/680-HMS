<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

require_once './check-login.php';
require_once './helpers/department.helper.php';
require_once './helpers/doctors.helper.php';
?>

<?php
// include the header files
$page_title = "Admin - Add Doctor";
require_once APP_ROOT . '/admin/inc/header.inc.php';
require_once APP_ROOT . '/admin/inc/top-bar.inc.php';

$isErr = false;
$error = "";

// get list of all departments
$res = get_all_department($conn);
if (!$res) {
    $isErr=true;
    $error="Some Error Occurred !!";
}

?>

<?php
    // handle form
    if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
        if (empty($_POST['name']) || empty($_POST['joining']) || empty($_POST['contactNumber']) || empty($_POST['department']) || empty($_POST['email']) || empty($_POST['iniPass'])) {
            $error = "Some Fields are missing !!";
        } else {
            $name = $_POST["name"];
            $joining = $_POST["joining"];
            $contactNumber = $_POST["contactNumber"];
            $email = $_POST["email"];
            $department = $_POST["department"];
            $iniPass = $_POST['iniPass'];
            $iniPass = password_hash($iniPass, PASSWORD_DEFAULT);

            $sql = "INSERT INTO `doctors` (`name`, `email`, `phone`, `password`, `department`, `joined_on`) VALUES ('$name', '$email', '$contactNumber', '$iniPass','$department', '$joining');";
            if ($conn->query($sql) === TRUE) {
                // Redirect to dashboard after successful record creation
                header("Location: doctors.php");
                exit();
            } else {
                $error = "Some Error occurred ". $conn->error;
            }
        }
    }
?>
    <div class="h-auto flex justify-center  overflow-y-hidden">
        <div class="w-full lg:w-2/6 p-2 bg-white rounded-md shadow-md">
            <h1 class="text-xl py-1 text-center text-green-900">Add Doctor</h1>

            <span class="w-full text-md text-center text-red-600 rounded-md"><?php echo $error ?></span>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <div class="mb-2">
                    <label for="docName" class="block text-gray-700 text-sm font-bold mb-2">Name </label>
                    <input type="text" id="docName" name="name" placeholder="Enter Name" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
                </div>
                <div class="mb-2">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">

                </div>
                <div class="mb-2">
                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone No </label>
                    <input type="number" id="phone" name="contactNumber" placeholder="Enter your Phone" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
                </div>
                <div class="mb-2">
                    <label for="iniPass" class="block text-gray-700 text-sm font-bold mb-2">Set Initial Password </label>
                    <input type="password" id="iniPass" name="iniPass" placeholder="Enter your Phone" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
                </div>
                <div class="mb-2">
                    <label for="department" class="block text-gray-700 text-sm font-bold mb-2">Department </label>
                    <select id="select" id="department" name="department" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 border
                 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                        <?php
                        while ($row = $res->fetch_assoc()) {
                            echo '
                                <option value="'.$row['id'].'">'.$row['name'].'</option>
                            ';
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-2">
                    <label for="joining" class="block text-gray-700 text-sm font-bold mb-2">Joining From </label>
                    <input type="date" id="joining" name="joining" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
                </div>
                <div class="mb-2">
                    <input type="submit" value="Add" class="w-full px-3 py-2 bg-green-500 text-lg text-white rounded-md shadow-sm cursor-pointer hover:bg-green-700 transition-all duration-100" />
                </div>

            </form>
        </div>
    </div>

<?php
require_once APP_ROOT . '/admin/inc/footer.inc.php';
?>