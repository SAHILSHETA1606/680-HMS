<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

require_once './check-login.php';

require_once './helpers/doctors.helper.php';
require_once './helpers/department.helper.php';

// include the header files
$page_title = "Admin - Edit Doctor";
require_once APP_ROOT . '/admin/inc/header.inc.php';
require_once APP_ROOT . '/admin/inc/top-bar.inc.php';

//  set all the value in form

$err = false;
$error = '';

// get list of department
$depar = get_all_department($conn);
if(!$depar) {
    $err = true;
    $error = "Some error occurred !!";
}
// get doctor's details
if (empty($_GET['id'])) {
    $error = "Please provide Id";
    $err = true;
} else {
    $id = $_GET['id'];
    $doc = get_doctor_info($conn, $id);
    if ($doc=== false) {
        $error = "No Patient with this ID";
        $err = true;
    } else {
        // there is no error
        $error = "";
        $err = false;
    }
}

// handle form update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['name']) || empty($_POST['joining']) || empty($_POST['email']) || empty($_POST['contactNumber']) || empty($_POST['department']) || empty($_POST['email'])) {
        print_r($_POST);
        echo $error = "Some Fields are missing";
    } else {
        $name = $_POST["name"];
        $joining = $_POST["joining"];
        $contactNumber = $_POST["contactNumber"];
        $email = $_POST["email"];
        $department = $_POST["department"];

        $res = update_doctor($conn,$name, $email, $contactNumber, $department, $joining, $id);
        if ($res) {
            // Redirect to dashboard after successful record creation

            header('location: doctors.php');
            exit();
        } else {
            $error = "Some Error Occurred !! " . $conn->error;
        }
    }}

?>
<!-- show the UI-->
<?php
if ($err) {
    echo '
        <div class="h-full flex justify-center items-center">
        <div class="bg-red-300 w-2/6 h-1/2 rounded-md flex justify-center items-center ">
            <h4 class="text-lg text-center font-semibold">'.$error.' </h4>
        </div>
    </div>
        ';
} else {
    echo '
    <div class="h-auto flex justify-center  overflow-y-hidden">
    <!-- <div class="h-auto w-2/6"> -->
    <div class="w-2/6 p-2 bg-white rounded-md shadow-md">
        <h1 class="text-xl py-1 text-center text-green-900">Edit Doctor</h1>

        <span class="w-full text-md text-center text-white bg-red-600 rounded-md"><?php echo $error ?></span>

        <form action=""' . htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $doc["id"] . '" method="post">
            <div class="mb-2">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name </label>
                <input type="text" id="fname" name="name" value="' . $doc['doc_name'] . '"  class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
            </div>
            <div class="mb-2">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email"  value="' . $doc['email'] . '"  class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">

            </div>
            <div class="mb-2">
                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone No </label>
                <input type="number" id="phone" name="contactNumber" value="' . $doc['phone'] . '"  class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
            </div>
            <div class="mb-2">
                <label for="department" class="block text-gray-700 text-sm font-bold mb-2">Department </label>
                <select id="select" id="department" name="department" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 border
                focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
 '?>
    <?php
    while ($row = $depar->fetch_assoc()) {
        if ($row['id'] == $doc['dep_id']) {
            echo '<option value="' . $row["id"] . '" selected>' . $row['name'] . '</option>';
        } else {
            echo '<option value="' . $row["id"] . '" >' . $row['name'] . '</option>';
        }
    }
    ?>
    </select>
    </div>
    <?php
    echo '
            <div class="mb-2">
                <label for="joining" class="block text-gray-700 text-sm font-bold mb-2">Joining From </label>
                <input type="date" id="joining" value="' . $doc['joining_date'] . '"  name="joining" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
            </div>
            <div class="mb-2">
                <input type="submit" value="Edit" class="w-full px-3 py-2 bg-green-500 text-lg text-white rounded-md shadow-sm cursor-pointer hover:bg-green-700 transition-all duration-100" />
            </div>

        </form>
    </div>
</div>
   ';
}
?>


<?php
require_once APP_ROOT . '/admin/inc/footer.inc.php';
?>