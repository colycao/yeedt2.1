<?php error_reporting(0);
include 'inc/config.php';
include 'inc/db.class.php';
include 'inc/common.inc.php';
include 'inc/member.inc.php';
include 'inc/function.php';
$db = new db();
if ( !ini_get('register_globals') ) 
{ 
    extract($_POST); 
    extract($_GET); 
    extract($_SERVER); 
    extract($_FILES); 
    extract($_ENV); 
    extract($_COOKIE); 
    
    if ( isset($_SESSION) ) 
    { 
        extract($_SESSION); 
    } 
}
?>