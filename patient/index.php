<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

require_once 'check-login.php';

$page_title="Welcome ".$_SESSION['username'];
require_once APP_ROOT . '/patient/inc/header.inc.php';
require_once APP_ROOT . '/patient/inc/top-bar.inc.php';

?>






<?php
require_once APP_ROOT . '/patient/inc/footer.inc.php';
?>
