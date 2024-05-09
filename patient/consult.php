<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

require_once 'check-login.php';

$page_title="Chat ".$_SESSION['username'];
require_once APP_ROOT . '/patient/inc/header.inc.php';
require_once APP_ROOT . '/patient/inc/top-bar.inc.php';

$patientEmail= $_SESSION['email'];
$patientId=$_SESSION['patientId'];
// get doctor Id to chat
$sql = "SELECT `patient_details`.`doctorId`,`doctors`.`id`, `doctors`.`name`, `doctors`.`email` FROM `patient_details` LEFT JOIN `doctors` ON `doctors`.`id`=patient_details.doctorId WHERE patient_details.email='$patientEmail';";
$res = $conn->query($sql);
if ($res->num_rows!==0) {
    $doctor = $res->fetch_assoc();
}
?>


<div class="full flex justify-center">

    <div class="w-full md:w-1/2 border">
        <div id="head" class="w-full bg-blue-600 text-white text-lg font-semibold text-left px-3 py-2 rounded-md">Chat with Dr. <?php echo $doctor['name'] ?></div>
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
    let url = 'consultation-handler.php';
    sendBtn.addEventListener('click', (e) => {
        e.preventDefault();
        let msgBox = document.getElementById('msg');
        let msg = msgBox.value;
        console.log(msg, <?= $patientId ?>, <?= $doctor['id'] ?>);

        const data = new FormData();
        data.append('sender', <?php echo $patientId ?>);
        data.append('receiver', <?php echo $doctor['id'] ?>);
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
    let patientId = <?php echo $patientId ?>

    function getMessages() {
        axios.get(url, {
            params: {
                patientId: patientId, // patient
            }
        }).then(function(response) {
            let data = response.data;
            console.log('data');
            data.forEach((d) => {
                console.log('sender', d.sender , ' ', patientId)
                if (d.sender == patientId) {
                    appendSendMessage(d);
                } else {
                    appendRecievedMessage(d);
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
require_once APP_ROOT . '/patient/inc/footer.inc.php';
?>
