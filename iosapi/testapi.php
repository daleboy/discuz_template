<?php
define('APPTYPEID', 2);
define('CURSCRIPT', 'forum');

require '../source/class/class_core.php';
require '../source/function/function_forum.php';

C::app()->init();


isset($_REQUEST['pic']) ? $s = $_REQUEST['pic'] : $res['changeCheck'] = 0;



	file_put_contents('testupload.jpg', $s);



?>
<img src="testupload.jpg"  />