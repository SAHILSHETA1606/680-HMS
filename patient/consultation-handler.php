<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ((isset($_POST['sender']) && $_POST['sender'] != '') && (isset($_POST['receiver']) && $_POST['receiver'] != '')) {
        if (isset($_POST['message'])) {
            $sender = intval($_POST['sender']);
            $receiver = intval($_POST['receiver']);
            $message = nl2br(htmlspecialchars($_POST['message']));

            $sql = "INSERT INTO `chats` (`sender`, `reciever`, `msg`) VALUES ($sender, $receiver, '$message');";
            $res = $conn->query($sql);
            if ($res) {
                $msgId = $conn->insert_id; // gives the id of latest inserted query
                $sql = "SELECT time FROM chats WHERE id=$msgId";
                $result=$conn->query($sql);
                $created_at = $result->fetch_assoc()['time'];
                http_response_code(200);
                echo json_encode(array("msg" => $message, 'time' => $created_at));
            } else {
                // http_response_code(500);
                echo json_encode(array("error" => "Error sending message" . $conn->error));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("msg" => "You don't have any message."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("msg" => "Something wrong!"));
    }
    die();
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['patientId'])) {
        $patientId = $_GET["patientId"];
        $sql = "SELECT * FROM chats WHERE sender=$patientId or reciever=$patientId";
        $res = $conn->query($sql);
        if ($res->num_rows === 0) {
            echo json_encode(array('msg' => 'No Message Found', "status" => 404));
        } else {
            while ($row = $res->fetch_assoc()) {
                $data[] = $row;
            }
            // print_r($data);
            // die();
            echo json_encode($data);
        }
    } else {
        http_response_code(400);
        echo json_encode(array("msg" => "Something wrong!"));
    }
} else {
    http_response_code(405); // Method Not Allowed
}