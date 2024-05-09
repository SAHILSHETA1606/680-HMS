<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

require_once './check-login.php';
?>

<?php
// include the header files

$page_title = "Patients - Admin";
require_once APP_ROOT . '/admin/inc/header.inc.php';
require_once APP_ROOT . '/admin/inc/top-bar.inc.php';

require_once './helpers/patients.helper.php';

$res = get_all_patients($conn);
?>
<?php
if ($res) {
    echo '
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    First Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Last Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Phone No
                </th>
                <th scope="col" class="px-6 py-3">
                    DOB
                </th>
                <th scope="col" class="px-6 py-3">
                    Gender
                </th>
                <th scope="col" class="px-6 py-3">
                    Doctor
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>' ?>
    <?php
    while ($row = $res->fetch_assoc()) {
        echo '
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    ' . $row['id'] . '
                </th>
                <td class="px-6 py-4">
                    ' . $row['firstname'] . '
                </td>
                <td class="px-6 py-4">
                ' . $row['lastname'] . '
                </td>
                <td class="px-6 py-4">
                ' . $row['email'] . '
                </td>
                <td class="px-6 py-4">
                ' . $row['phone'] . '
                </td>
                <td class="px-6 py-4">
                ' . $row['dob'] . '
                </td>
                <td class="px-6 py-4">
                ' . $row['gender'] . '
                </td>
                <td class="px-6 py-4">
                Dr. ' . $row['doc_name'] . '
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="edit-patient.php?id=' . $row['id'] . '" class="bg-blue-600 text-white font-medium px-3 py-2 rounded-md dark:bg-blue-500 hover:bg-blue-700">Edit</a>
                    <a href="delete-patient.php?delete=' . $row['id'] . '" class="bg-red-600 text-white font-medium px-3 py-2 rounded-md dark:bg-blue-500 hover:bg-red-700">Delete</a>
                </td>
            </tr>
                ';
    }
    ?>
    <?php echo ' </tbody>
    </table>
</div>
    ';
} else {
    echo '
        <div class="flex h-full justify-center items-center">
            <div class="w-2/6 mx-auto py-10 bg-green-300 rounded-md shadow-sm">
                <h2 class="text-2xl text-center font-semibold ">No Record Found !</h2>
            </div>
        </div>
        
        ';
}

?>
    <div class="flex justify-center">
        <a href="add-patient.php" class="px-3 py-2 bg-green-600 hover:bg-green-700 transition-all duration-100 rounded-md shadow-md text-white text-lg"><span class="font-bold">+</span>New Patient</a>
    </div>


<?php
require_once APP_ROOT . '/admin/inc/footer.inc.php';
?>