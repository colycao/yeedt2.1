<?php  error_reporting(0);
if(!file_exists('./inc/install.lock')){
	if(file_exists('./install/index.php')){
		header("location:./install/index.php");exit;
	}
}
	

include 'tpl/trans/trans.htm';
?>