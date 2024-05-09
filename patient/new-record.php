<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

require_once 'check-login.php';

$page_title="Welcome ".$_SESSION['username'];
require_once APP_ROOT . '/patient/inc/header.inc.php';
require_once APP_ROOT . '/patient/inc/top-bar.inc.php';

// Get user session information
$patientId = $_SESSION['patientId'];
$email = $_SESSION["email"];

$isErr=false;
$error="";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {

    // File details
    $file_name = $_FILES["file"]["name"];
    $file_tmp = $_FILES["file"]["tmp_name"];
    // Generate a unique filename incorporating session information
    $unique_id = uniqid($patientId . "_" . $email . "_");
    $new_filename = $unique_id . '_' . $file_name;

    // Move the file to a permanent location with the new filename
    $upload_dir = 'uploads/';
    $target_file = $upload_dir . basename($new_filename);

    if (move_uploaded_file($file_tmp, $target_file)) {
        // Insert file details into database
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $file_link = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/" . $target_file;

        $sql = "INSERT INTO patient_records (patient_id, report_url, filename) VALUES ($patientId, '$file_link', '$new_filename')";
        if ($conn->query($sql) === TRUE) {
            header("Location: records.php");
            exit();
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo $error = "Error uploading file.";
    }

    $conn->close();
}


?>

<?php
if ($isErr) {
    echo '
    <div class="flex h-full justify-center items-center">
    <div class="w-2/6 mx-auto py-10 bg-green-300 rounded-md shadow-sm">
        <h2 class="text-2xl text-center font-semibold ">' . $error . '</h2>
    </div>
</div>

    ';
}
echo '
<div class="flex h-full justify-center items-center">
<div class="w-2/6 mx-auto px-8 py-10 bg-white rounded-md shadow-sm">
    <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post" enctype="multipart/form-data">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="file">
                Choose File:
            </label>
            <input type="file" name="file" id="file" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Upload
            </button>
        </div>
    </form>
</div>
</div>
';
?>





<?php
require_once APP_ROOT . '/patient/inc/footer.inc.php';
?>
