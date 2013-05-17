<?php session_start();
header("Content-type: text/html;charset=utf-8");

if(file_exists('../inc/install.lock')){
	header("location:../index.php");exit;
}

include '../inc/common.inc.php';
	

error_reporting(0);

$action = $_REQUEST['action'];
switch ($action)
{
	case 'inspect':
	{
		$mysql_support = (function_exists( 'mysql_connect')) ? ON : OFF;
		if(function_exists( 'mysql_connect')){
			$mysql_support  = 'ON';
			$mysql_ver_class ='OK';
		}else {
			$mysql_support  = 'OFF';
			$mysql_ver_class ='WARN';
		}
		if(PHP_VERSION<'5.0.0'){
			$ver_class = 'WARN';
			$errormsg['version']='php 版本过低';
		}else {
			$ver_class = 'OK';
			$check=1;
		}
		$function='OK';
		if(!function_exists('file_put_contents')){
			$function='WARN';
			$fstr.="<li class='WARN'>空间不支持file_put_contents函数，系统无法写文件。</li>";
		}
		if(!function_exists('curl_init')){
			$function='WARN';
			$fstr="<li class='WARN'>空间不支持php_curl函数，请开启，否则程序无法正常运行。</li>";
		}
		
		
		if(!function_exists('fsockopen')&&!function_exists('pfsockopen')&&!function_exists('stream_socket_client')){
			$function='WARN';
			$fstr.="<li class='WARN'>空间不支持fsockopen，pfsockopen,stream_socket_client函数，系统邮件功能不能使用。请至少开启其中一个。</li>";
		}
		if(!function_exists('copy')){
			$function='WARN';
			$fstr.="<li class='WARN'>空间不支持copy函数，无法上传文件。</li>";
		}
		if(!function_exists('fsockopen')&&!function_exists('pfsockopen')&&(!get_extension_funcs('curl')||!function_exists('curl_init')||!function_exists('curl_setopt')||!function_exists('curl_exec')||!function_exists('curl_close'))){
				$function='WARN';
				$fstr.="<li class='WARN'>空间不支持fsockopen，pfsockopen函数，curl模块(需同时开启curl_init,curl_setopt,curl_exec,curl_close)，系统在线更新，短信发送功能无法使用。请至少开启其中一个。</li>";
		}
		if(!get_extension_funcs('gd')){
			$function='WARN';
			$fstr.="<li class='WARN'>空间不支持gd模块，图片打水印和缩略生成功能无法使用。</li>";
		}
		$w_check=array(
		'../',
		'../inc',
		'../tpl',
		'../images',
		'../js',
		);
		$class_chcek=array();
		$check_msg = array();
		$count=count($w_check);
		for($i=0; $i<$count; $i++){
			if(!file_exists($w_check[$i])){
				$check_msg[$i].= '文件或文件夹不存在请上传';$check=0;
				$class_chcek[$i] = 'WARN';
			} elseif(is_writable($w_check[$i])){
				$check_msg[$i].= '通 过';
				$class_chcek[$i] = 'OK';
				$check=1;
			} else{
				$check_msg[$i].='777属性检测不通过'; $check=0;
				$class_chcek[$i] = 'WARN';
			}
			if($check!=1 and $disabled!='disabled'){$disabled = 'disabled';}
		}
		include 'tpl/inspect.htm';
		break;
	}
	
	
	case 'db_setup':
	{
		if($_REQUEST['setup']==1){
			
			$db_prefix = $_SESSION['db_prefix'] = $_POST['db_prefix'];
			$db_host = $_SESSION['db_host'] = $_POST['db_host'];
			$db_username = $_SESSION['db_username'] = $_POST['db_username'];
			$db_pass = $_SESSION['db_pass'] = $_POST['db_pass'];
			$db_name = $_SESSION['db_name'] = $_POST['db_name'];
			
			$_SESSION['reg_url'] = $_POST['reg_url'] ? $_POST['reg_url'] : $requestUrl . "/reg";
			
			$db_prefix      = trim(strip_tags($db_prefix));
			$db_host        = trim(strip_tags($db_host));
			$db_username    = trim(strip_tags($db_username));
			$db_pass        = trim(strip_tags($db_pass));
			$db_name        = trim(strip_tags($db_name));
			$config="<?php
					define(\"HOST\",\"$db_host\");  
					define(\"PWD\",\"$db_pass\");
					define(\"USER\",\"$db_username\");
					define(\"DB\",\"$db_name\");
                  ?>";

			$fp=fopen("../inc/config.php",'w+');
			fputs($fp,$config);
			fclose($fp);
			$db = mysql_connect($db_host,$db_username,$db_pass) or die('连接数据库失败: ' . mysql_error());
			if(!@mysql_select_db($db_name)){
				mysql_query("CREATE DATABASE $db_name ") or die('创建数据库失败'.mysql_error());
			}
			mysql_select_db($db_name);
			//
			if(mysql_get_server_info()>='4.1'){
				mysql_query("set names utf8"); 
				$content=readover("sql.sql");
				$content=preg_replace("/{#(.+?)}/eis",'$lang[\\1]',$content);	
				$installinfo=creat_table($content);		
			}else {
				echo "<SCRIPT language=JavaScript>alert('您的mysql版本过低，请确保你的数据库编码为utf-8,官方建议您升级到mysql4.1.0以上');</SCRIPT>";
				die();
				$content=readover("sql.sql");
				$content=str_replace('ENGINE=MyISAM DEFAULT CHARSET=utf8','TYPE=MyISAM',$content);
			}
			
			header("location:index.php?action=adminsetup");exit;
		}else {
			include 'tpl/databasesetup.htm';
		}
		break;
	}
	
	
	case 'adminsetup':
	{
		if($_REQUEST['setup']==1){
			$yeedt_id = $_POST["yeedt_id"];
			$yeedt_key = md5($_POST["yeedt_key"]);
			$email = $_POST["email"];
			$tel = $_POST["tel"];
			$proxy_url = $_POST["proxy_url"];
			if($yeedt_id=='' || $yeedt_key==''){
				echo("<script type='text/javascript'> alert('请填写译典通ID和key！'); history.go(-1); </script>");
			}
			$config="<?php
					define(\"HOST\",\"$_SESSION[db_host]\");  
					define(\"PWD\",\"$_SESSION[db_pass]\");
					define(\"USER\",\"$_SESSION[db_username]\");
					define(\"DB\",\"$_SESSION[db_name]\");
                  ";

			$localurl="http://";
			$localurl.=$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"];
			$localurl_a=explode("/",$localurl);
			$localurl_count=count($localurl_a);
			$localurl_admin=$localurl_a[$localurl_count-2];
			$localurl_admin=$localurl_admin;
			$localurl_real=explode($localurl_admin,$localurl);
			$localurl=$localurl_real[0];
			
			$config .=  "
				\$yeedt_id = \"".$yeedt_id."\";
				\$yeedt_key = \"".$yeedt_key."\";
				\$email = \"".$email."\";
				\$tel = \"".$tel."\";
				\$returnUrl =\"".$localurl."\";
				\$proxyUrl =\"".$proxy_url."\";
			";
			
			$config .=  "?>";
			$fp=fopen("../inc/config.php",'w+');
			fputs($fp,$config);
			fclose($fp);
			
			
			
			
			
			header("location:index.php?action=finished");exit;
		}
		else
		{
			$reg_url = $_SESSION['reg_url'];
			include 'tpl/adminsetup.htm';
		}
		break;
	}
	
	case 'finished':
	{
		$fp  = fopen('../inc/install.lock', 'w');
		fwrite($fp," ");
		fclose($fp);
		include 'tpl/finished.htm';
		break;
	}
	
	default:
			include 'tpl/index.html';
	break;
}

function readover($filename,$method="rb"){
	if($handle=@fopen($filename,$method)){
		flock($handle,LOCK_SH);
		$filedata=@fread($handle,filesize($filename));
		fclose($handle);
	}
	return $filedata;
}
function creat_table($content) {
	global $installinfo,$db_prefix,$db_setup;
	$sql=explode("\n",$content);
	$query='';
	$j=0;
	foreach($sql as $key => $value){
		$value=trim($value);
		if(!$value || $value[0]=='#') continue;
		if(eregi("\;$",$value)){
			$query.=$value;
			if(eregi("^CREATE",$query)){
				$name=substr($query,13,strpos($query,'(')-13);
				$c_name=str_replace('met_',$db_prefix,$name);
				$i++;
			}
			$query = str_replace('met_',$db_prefix,$query);
			$query = str_replace('metconfig_','met_',$query);
			//echo $query;
			if(!mysql_query($query)){
				$db_setup=0;
				if($j!='0'){
				echo '<li class="WARN">出错：'.mysql_error().'<br/>sql:'.$query.'</li>';
				}
			}else {
			     
				if(eregi("^CREATE",$query)){
					$installinfo=$installinfo.'<li class="OK"><font color="#0000EE">建立数据表'.$i.'</font>'.$c_name.' ... <font color="#0000EE">完成</font></li>';
				}
				$db_setup=1;
			}
			$query='';
		} else{
			$query.=$value;
		}
		$j++;
	}
	return $installinfo;
}
?>