<?php header("Content-type:text/html;charset=utf-8");
require_once 'global.php';
if($submit)
{
	$arr = array(
		'f_username'=>$username,
		'f_address'=>$address,
		'f_company'=>$company,
		'f_tel'=>$tel,
		'f_title'=>$title,
		'f_phone'=>$phone,
		'f_email'=>$email,
		'yeedt_id'=>$yeedt_id,
		'yeedt_key'=>$yeedt_key,
	);
	$enarr = json_encode($arr);
	$rs = PostHttpRequest($requestUrl."/interface/setMember/","member_info={$enarr}");
	
	$config .=  "<?php
				\$f_username = \"".$username."\";
				\$f_address = \"".$address."\";
				\$f_company = \"".$company."\";
				\$f_tel = \"".$tel."\";
				\$f_title =\"".$title."\";
				\$f_phone =\"".$phone."\";
				\$f_email =\"".$email."\";
				?>
			";
	$fp=fopen("inc/member.inc.php",'w+');
	fputs($fp,$config);
	fclose($fp);
	
	echo "<script>alert('提交成功');window.location='member.php';</script>";
}
else 
{
	include 'tpl/member.htm';
}
?>