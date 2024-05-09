<?php
require_once dirname(dirname(__FILE__)) . '/config/config.php';
require_once APP_ROOT . '/utils/connect.php';

require_once './check-login.php';
require_once './helpers/patients.helper.php';
require_once './helpers/doctors.helper.php';

// get list of all doctors
$doctors = get_all_doctors($conn);
$err = false;
$error = "";
if (!$doctors) {
    $err = true;
    $error = "Some Error Occurred";
}

// handle new patient
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission to create a new patient record
    if (empty($_POST['firstname']) || empty($_POST['dob']) || empty($_POST['gender']) || empty($_POST['contactNumber']) || empty($_POST['email'])) {
        $err = true;
        $error = "Some Fields are missing";
    } else {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $dob = $_POST["dob"];
        $gender = $_POST["gender"];
        $contactNumber = $_POST["contactNumber"];
        $email = $_POST["email"];
        $doctor = $_POST["doctor"];

        // check for duplicate email
        $sql = "SELECT email FROM `patient_details` WHERE email = '$email'";
        $res = $conn->query($sql);
        // die($sql);
        if ($res->num_rows==0) {
            $sql = "INSERT INTO `patient_details` (`firstname`, `lastname`, `email`, `phone`, `gender`, `dob`, `doctorId`) VALUES ('$firstname', '$lastname', '$email', '$contactNumber', '$gender', '$dob', '$doctor');";
            if ($conn->query($sql) === TRUE) {
                // Redirect to dashboard after successful record creation
                header("Location: patients.php");
                exit();
            } else {
                $error = "Some Error occurred ";
            }
        } else {
            $error = "'".$email . "' is already registered";
        }
        // die();


    }
}

// include the header files
$page_title = "Add Patients - Admin";
require_once APP_ROOT . '/admin/inc/header.inc.php';
require_once APP_ROOT . '/admin/inc/top-bar.inc.php';

?>
<div class="h-auto flex justify-center  overflow-y-hidden">
    <!-- <div class="h-auto w-2/6"> -->
    <div class="w-2/6 p-2 bg-white rounded-md shadow-md">
        <h1 class="text-xl py-1 text-center text-green-900">Add New Patient</h1>

        <span class="w-full text-md text-center italic text-red-600 rounded-md"><?php echo $error ?></span>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="mb-2">
                <label for="fname" class="block text-gray-700 text-sm font-bold mb-2">First Name </label>
                <input type="text" id="fname" name="firstname" placeholder="Enter your First Name" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
            </div>
            <div class="mb-2">
                <label for="lname" class="block text-gray-700 text-sm font-bold mb-2">Last Name </label>
                <input type="text" id="lname" name="lastname" placeholder="Enter your Last Name" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
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
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender:</label>
                <select id="select" name="gender" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 border
                 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="O">Other</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="dob" class="block text-gray-700 text-sm font-bold mb-2">DOB </label>
                <input type="date" id="dob" name="dob" placeholder="Enter your DOB" class="w-full px-3 py-2 border rounded-md text-sm outline-none focus:border-green-500">
            </div>
            <div class="mb-2">
                <label for="doctor" class="block text-gray-700 text-sm font-bold mb-2">Doctor to consult </label>
                <select id="select" id="doctor" name="doctor" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 border
                 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                    <?php
                    while ($row = $doctors->fetch_assoc()) {
                        echo '
                                <option value="' . $row["id"] . '" >' . $row['doc_name'] . ' - ' . $row['dep_name'] . '</option>
                            ';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-2">
                <input type="submit" value="Submit" class="w-full px-3 py-2 bg-green-500 text-lg text-white rounded-md shadow-sm cursor-pointer hover:bg-green-700 transition-all duration-100" />
            </div>
        </form>
    </div>
</div>

<?php
require_once APP_ROOT . '/admin/inc/footer.inc.php';
?>