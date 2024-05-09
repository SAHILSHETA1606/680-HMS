<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

require_once 'check-login.php';

$page_title="Chats ".$_SESSION['username'];
require_once APP_ROOT . '/doctor/inc/header.inc.php';
require_once APP_ROOT . '/doctor/inc/top-bar.inc.php';

// This page will show the list of messages

$err = false;
$error = "";
$docId=$_SESSION['docId'];

// check the list of received messages;
//$sql =
$docId=$_SESSION['docId'];
$sql = "SELECT `chats`.`id`, `chats`.`msg`, `chats`.`sender`, `chats`.`time`, `patient`.`id` AS patient_id, `patient`.`username` AS patient_name FROM `chats` LEFT JOIN `patient` ON `chats`.`sender` = `patient`.`id` WHERE `chats`.`reciever` = $docId";
$chats = $conn->query($sql);

?>

<div class="max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-4">Your Messages</h1>
    <div class=" overflow-y-scroll" style="height: 500px;">
        <ul class="divide-y divide-gray-200">

            <?php
                if ($chats->num_rows === 0) {
                    echo '
                        <li class="py-4">
                            <div class="flex space-x-4">
                                <!-- <img src="https://via.placeholder.com/40" alt="User Avatar" class="w-10 h-10 rounded-full"> -->
                                <div class="flex-1">
                                <div class="font-bold">No Chats</div>
                            </div>
                        </li>
                    ';
                } else {
                    while ($row = $chats->fetch_assoc()) {
                        echo '
                    <li class="py-4">
                    <div class="flex space-x-4">
                        <!-- <img src="https://via.placeholder.com/40" alt="User Avatar" class="w-10 h-10 rounded-full"> -->
                        <div class="flex-1">
                            <div class="font-bold">' . $row['patient_name'] . '</div>
                            <div class="text-sm text-gray-600">' . $row['msg'] . '</div>
                            <div class="text-xs text-gray-400">' . $row['time'] . '</div>
                            <a href="chat.php?patientid=' . $row['sender'] . '" class="text-xs text-blue-500">View</a>
                        </div>
                    </div>
                </li>
                    ';
                    }
                }
            ?>
        </ul>
    </div>
</div>




<?php
require_once APP_ROOT . '/doctor/inc/footer.inc.php';
?>
