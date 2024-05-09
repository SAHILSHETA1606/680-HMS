<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

require_once 'check-login.php';

$page_title="Welcome ". $_SESSION['username'];
require_once APP_ROOT . '/patient/inc/header.inc.php';
require_once APP_ROOT . '/patient/inc/top-bar.inc.php';

$patientId = $_SESSION['patientId'];
$isErr = false;
$error="";
// get all records
$sql = "SELECT * FROM `patient_records` WHERE patient_id=$patientId";

$res = $conn->query($sql);
if ($res->num_rows === 0) {
    $isErr = true;
    $error = "No Record Found !";
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
} else {
    echo '
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <!-- <th scope="col" class="px-6 py-3">
                    ID
                </th> -->
                <th scope="col" class="px-6 py-3">
                    Filename
                </th>
                <th scope="col" class="px-6 py-3">
                    Uploaded
                </th>
            </tr>
        </thead>
        <tbody>
        ' ?>
    <?php
    while ($row = $res->fetch_assoc()) {
        echo '
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4">
                    <a href="' . $row["report_url"] . '" class="hover:underline">' . $row["filename"] . '</a>
                </td>
                <td class="px-6 py-4">
                ' . $row["uploaded_on"] . '
                </td>
                </tr>
                ';
    };
    ?>
    </tbody>
    </table>
    </div>
<?php }; ?>



<div class="flex justify-center">
    <a href="new-record.php" class="px-3 py-2 bg-green-500 hover:bg-green-600 transition-all duration-100 rounded-md shadow-md text-white text-lg">New Record</a>
</div>





<?php
require_once APP_ROOT . '/patient/inc/footer.inc.php';
?>

