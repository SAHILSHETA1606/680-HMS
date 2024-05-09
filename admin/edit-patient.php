<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

require_once './check-login.php';
require_once './helpers/patients.helper.php';
require_once './helpers/doctors.helper.php';

// get list of all doctors
$doctors = get_all_doctors($conn);
$err=false;
$error="";
if(!$doctors) {
    $err=true;
    $error= "Some Error Occurred";
}

//  set all the value in form
if (empty($_GET['id'])) {
    $error = "Please provide Id";
    $err = true;
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `patient_details` WHERE `id`=" . $id;
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $error = "No Patient with this ID";
        $err = true;
    } else {
        // there is no error
        $error = "";
        $err = false;
        $row = $result->fetch_assoc();
    }
}

// handle form update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['firstname']) || empty($_POST['dob']) || empty($_POST['gender']) || empty($_POST['contactNumber']) || empty($_POST['email'])) {
        $error = "Some Fields are missing";
    } else {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $dob = $_POST["dob"];
        $gender = $_POST["gender"];
        $contactNumber = $_POST["contactNumber"];
        $email = $_POST["email"];
        $id=$_GET['id'];

        $res = update_patient($conn, $firstname, $lastname, $email, $dob, $gender, $contactNumber, $id);
        if ($res === true) {
            // Redirect to dashboard after successful record creation
            header("Location: patients.php");
            exit();
        } else {
            $error = "Some Error occurred " . $conn->error;
        }
    }
}

// include the header files
$page_title = "Add Patients - Admin";
require_once APP_ROOT . '/admin/inc/header.inc.php';
require_once APP_ROOT . '/admin/inc/top-bar.inc.php';

?>

<?php
if ($err) {
    echo '
        <div class="h-full flex justify-center items-center">
        <div class="bg-red-300 w-2/6 h-1/2 rounded-md flex justify-center items-center ">
            <h4 class="text-lg text-center font-semibold">Error : </h4>
        </div>
    </div>
        ';
} else {
    echo '
    <div class="h-auto flex justify-center overflow-y-hidden">
    <div class="w-2/6 p-2 bg-white rounded-md shadow-md">
        <h1 class="text-xl py-1 text-center text-green-900">Edit Patient</h1>
        
        <span class="w-full text-md text-center text-white bg-red-600 rounded-md"><?php echo $error ?></span>

        <form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $row["id"] . '" method="post">
            <div class="mb-2">
                <label for="fname" class="block text-gray-700 text-sm font-bold mb-2">First Name </label>
                <input type="fname" id="fname" name="firstname" value="' . $row['firstname'] . '" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
            </div>
            <div class="mb-2">
                <label for="lname" class="block text-gray-700 text-sm font-bold mb-2">Last Name </label>
                <input type="lname" id="lname" name="lastname" value="' . $row['lastname'] . '" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
            </div>
            <div class="mb-2">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" value="' . $row['email'] . '" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">

            </div>
            <div class="mb-2">
                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone No </label>
                <input type="number" id="phone" name="contactNumber" value="' . $row['phone'] . '" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">

            </div>
            <div class="mb-2">
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender:</label>
                <select id="select" name="gender" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 border
                 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                 ' ?><?php

    if ($row['gender'] === 'M') {
        echo '
<option value="M" selected>Male</option>
<option value="F">Female</option>
<option value="O">Other</option>
';
    } elseif ($row['gender'] === 'F') {
        echo '
<option value="M">Male</option>
<option value="F" selected>Female</option>
<option value="O">Other</option>
';
    } else {
        echo '
<option value="M">Male</option>
<option value="F">Female</option>
<option value="O">Other</option>
';
    }
    ?>
    </select>
    <div class="mb-2">
        <label for="doctor" class="block text-gray-700 text-sm font-bold mb-2">Doctor to consult </label>
        <select id="select" id="doctor" name="doctor" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 border
    focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
            <?php
            while ($detail = $doctors->fetch_assoc()) {
                if ($row['doctor'] == $detail['doc_id']) {
                    echo '<option value="' . $detail["id"] . '" selected>' . $detail['doc_name'] . ' - ' . $detail['dep_name'] . '</option>';
                } else {
                    echo '<option value="' . $detail["id"] . '" >' . $detail['doc_name'] . ' - ' . $detail['dep_name'] . '</option>';
                }
            }
            ?>
        </select>
    </div>
    <?php
    echo '
</div>
<div class="mb-2">
    <label for="dob" class="block text-gray-700 text-sm font-bold mb-2">Phone No </label>
    <input type="date" id="dob" name="dob" value="' . $row['dob'] . '" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
</div>
<div class="mb-2">
    <input type="submit" value="Submit" class="w-full px-3 py-2 bg-green-500 text-lg text-white rounded-md shadow-sm cursor-pointer hover:bg-green-700 transition-all duration-100" />
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
