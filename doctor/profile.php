<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

require_once 'check-login.php';

$page_title="Profile - ".$_SESSION['username'];
require_once APP_ROOT . '/doctor/inc/header.inc.php';
require_once APP_ROOT . '/doctor/inc/top-bar.inc.php';

?>

<div class="container w-full h-full lg:w-8/12 mx-auto bg-white shadow-sm">
    <h1 class="text-3xl text-center font-serif">Welcome <?php echo $_SESSION['username'] ?></h1>
</div>




<?php
require_once APP_ROOT . '/doctor/inc/footer.inc.php';
?>
