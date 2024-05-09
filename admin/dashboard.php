<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once APP_ROOT.'/utils/connect.php';

require_once './check-login.php';
?>

<?php
// include the header files

$page_title = "Dashboard";
require_once APP_ROOT . '/admin/inc/header.inc.php';
require_once APP_ROOT . '/admin/inc/top-bar.inc.php';
?>


<?php
require_once APP_ROOT . '/admin/inc/footer.inc.php';
?>