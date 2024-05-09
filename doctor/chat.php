<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

require_once 'check-login.php';

$page_title="Chats ".$_SESSION['username'];
$patientId = $_GET['patientid'];
$docId = $_SESSION['docId'];

require_once APP_ROOT . '/doctor/inc/header.inc.php';
require_once APP_ROOT . '/doctor/inc/top-bar.inc.php';

//$sql = "SELECT `chats`.`id`, `chats`.`sender`, `chats`.`reciever`, `chats`.`msg`, `chats`.`time`, `patient`.`username`, `patient`.`id` FROM `chats` LEFT JOIN `patient` ON `chats`.`sender` = `patient`.`id` WHERE `chats`.`sender` = $patientId";
$sql = "SELECT * FROM `patient` WHERE id=$patientId";
$res = $conn->query($sql);
$patient = $res->fetch_assoc();

?>

<div class="full flex justify-center">

    <div class="w-full md:w-1/2 border">
        <div id="head" class="w-full bg-blue-600 text-white text-lg font-semibold text-left px-3 py-2 rounded-md">Chat with <?php echo $patient['username'] ?></div>
        <div class="bg-white w-full flex flex-col justify-between" style="height: 400px; overflow-x: hidden;overflow-y: scroll;">
            <div id="date" class="w-full mt-2">
                <div class="bg-gray-300 w-full lg:w-64 mx-auto py-1 rounded-lg text-center" id="lastUpdate">

                </div>
            </div>
            <div id="messages" class="w-full h-full flex flex-col ">
            </div>
        </div>
        <form id="chatForm">
            <input type="text" value="<?php echo $patientId ?>" name="sender" hidden>
            <input type="text" value="<?php echo $doctor['id'] ?>" name="reciever" hidden>
            <div class="relative">
                <input type="search" id="msg" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Message ..." required />
                <button type="button" id="sendBtn" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Send</button>
            </div>
        </form>

    </div>
</div>

<script>
    let sendBtn = document.getElementById('sendBtn');
    let url = 'chat-handler.php';
    sendBtn.addEventListener('click', (e) => {
        e.preventDefault();
        let msgBox = document.getElementById('msg');
        let msg = msgBox.value;
        console.log(msg, <?= $patientId ?>, <?= $patient['id'] ?>);

        const data = new FormData();
        data.append('sender', <?php echo $docId ?>);
        data.append('receiver', <?php echo $patientId ?>);
        data.append('message', msg);
        axios.post(url, data).then(function(response) {
            console.log(response);
            // appendSendMessage(response.data);
            msgBox.value = '';
            // console.log(response.data);
            // appendSendMessage(response.data);
            let data = response.data;
            document.getElementById('lastUpdate').innerText = `Last Chat : ${data.time}`;
        })
            .catch(function(error) {
                console.log(error);
            });
    });


    // get data
    let getMsg = setInterval(getMessages, 1000);
    let docId = <?php echo $docId ?>

        function getMessages() {
            axios.get(url, {
                params: {
                    patientId: docId, // patient
                }
            }).then(function(response) {
                let data = response.data;
                console.log('data', data);
                data.forEach((d) => {
                    if (d.reciever == docId) {
                        appendRecievedMessage(d);
                    } else {
                        appendSendMessage(d);
                    }
                    // update last chat status
                    document.getElementById('lastUpdate').innerText = `Last Chat : ${d.time}`;
                });
            }).catch(function(error) {
                console.log(error);
                console.log(error.message);
            });
        }

    function appendSendMessage(data) {
        if (!document.getElementById(data.id)) {
            let p = document.createElement('p');
            p.classList += "w-full lg:w-6/12 my-1 bg-blue-300 mr-6 px-3 py-2 rounded-lg ml-auto transition-all duration-250 ease-in-out";
            p.id = data.id;
            p.innerText = data.msg
            document.getElementById('messages').appendChild(p);
        }
    }
    function appendRecievedMessage(data) {
        if (!document.getElementById(data.id)) {
            let p = document.createElement('p');
            p.classList += "w-full lg:w-6/12 my-1 h-auto bg-green-300 ml-6 px-3 py-2 rounded-lg transition-all duration-250 ease-in-out";
            p.innerText = data.msg
            p.id = data.id;
            document.getElementById('messages').appendChild(p);
        }
    }
</script>


<?php
require_once APP_ROOT . '/doctor/inc/footer.inc.php';
?>

