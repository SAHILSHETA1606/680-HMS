<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

require_once 'check-login.php';

$page_title="Welcome ".$_SESSION['username'];
require_once APP_ROOT . '/doctor/inc/header.inc.php';
require_once APP_ROOT . '/doctor/inc/top-bar.inc.php';

?>


<div class="container">
    <h1 class="text-3xl text-center">Your ID : <?php echo $_SESSION['docId'] ?></h1>
</div>



<?php
require_once APP_ROOT . '/doctor/inc/footer.inc.php';
?>
