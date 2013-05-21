<?php 
include 'global.php';

if($_GET['orderStatus'] == 'paid')
{
	$arr = json_decode($_REQUEST['p_key'],true);
	$sql="update yeedt_trans set status='".$_GET['orderStatus']."',yeedt_order_id='".$_GET['orderId']."' where order_id='{$_GET['p_number']}'";
	$db->query($sql,2);
	
	$msg = $_GET['p_number']."正在翻译中";
	$posttime = time();
	$sql="insert into yeedt_msg set msg='".$msg."',posttime='".$posttime."',type='".$_GET['orderStatus']."'";
	$db->query($sql,3);
	echo "<script>window.location='index.php';</script>";
}
else if($_GET['orderStatus'] == 'finish')
{
	$arr = json_decode($_REQUEST['order_info'],true);
	var_dump($arr);exit();
//	foreach ($arr['proxy_key'] as $key=>$rs)
//	{
//		$sql="update yeedt_trans set en_title='".$arr['translation'][$key]['title']."',en_content='".$arr['translation'][$key]['content']."',status='".$_GET['orderStatus']."',order_id='".$_GET['orderId']."' where id='{$rs}'";
//		$db->query($sql,2);
//	}

	$sql="update yeedt_trans set en_title='".$arr['translation'][0]['title']."',en_content='".$arr['translation'][0]['content']."',status='".$_GET['orderStatus']."' where order_id='{$_GET['p_number']}'";
	$db->query($sql,2);
	
	$msg = $_GET['p_number']."已翻译完成，可在翻译管理中下载译文";
	$posttime = time();
	$sql="insert into yeedt_msg set msg='".$msg."',posttime='".$posttime."',type='".$_GET['orderStatus']."'";
	$db->query($sql,3);
}

?>