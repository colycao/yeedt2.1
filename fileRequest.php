<?php 
include 'global.php';

if($_GET['msg'] == 'confirm')
{
	$order_info = json_decode($_REQUEST['order_info'],true);
	
	$sql="select id from yeedt_trans where yeedt_order_id='".$order_info['order_id']."'";
	$rsdb = $db->get_one($sql);
	if($rsdb['id']>0)
	{
		$sql="update yeedt_trans set order_id='".$order_info[proxy_order_number]."',status='".$order_info[status]."',price='".$order_info['price']."',wordCount='".$order_info['word_count']."' where yeedt_order_id='".$order_info['order_id']."'";
		$db->query($sql,2);
	}
	else 
	{
		$sql="insert into yeedt_trans set qualityLevels='".$order_info[qualityLevels]."',languages='".$order_info[languages]."',order_id='".$order_info[proxy_order_number]."',title='".$order_info[document]."',status='".$order_info[status]."',author='".$order_info[type]."',yeedt_order_id='".$order_info['order_id']."',price='".$order_info['price']."',wordCount='".$order_info['word_count']."'";
		$db->query($sql,3);
	}
	
	
	if($order_info[status]=="finish")
	{
		$msg = "订单编号为：".$order_info['order_id']."的翻译订单已翻译完成，<a href='".$requestUrl."/user/download?orderId=".$order_info['order_id']."' target='_blank'>点击下载译文</a>";
	}
	else if($order_info[status]=="translating")
	{
		$msg = "订单编号为：".$order_info['order_id']."的翻译订单正在翻译中";
	}
	else if($order_info[status]=="paid")
	{
		$msg = "订单编号为：".$order_info['order_id']."的翻译订单已付款，正在翻译中";
	}
	else if($order_info[status]=="new")
	{
		$msg = "订单编号为：".$order_info['order_id']."的翻译订单已报价，字数:".$order_info['word_count']."字，报价：".$order_info['price']."元";
	}
	
	$posttime = time();
	$sql="insert into yeedt_msg set msg='".$msg."',posttime='".$posttime."',type='".$_GET['orderStatus']."'";
	$db->query($sql,3);
}
else if($_GET['msg'] == 'ok')
{
	echo "<script>alert('上传成功，客服正在为您统计字数和价格，工作时间10分钟内响应。');window.location='trans.php';</script>";
}
else if($_GET['msg'] == 'paid')
{
	$sql="update yeedt_trans set status='".$_GET['orderStatus']."' where yeedt_order_id='".$_GET['orderId']."'";
	$db->query($sql,2);
	$posttime = time();
	$msg = "订单编号为：".$_GET['orderId']."的翻译订单已付款，正在翻译中";
	$sql="insert into yeedt_msg set msg='".$msg."',posttime='".$posttime."',type='".$_GET['orderStatus']."'";
	$db->query($sql,3);
	
	echo "<script>window.location='index.php'</script>";
}
else if($_GET['msg'] == 'finish')
{
	$order_info = json_decode($_REQUEST['order_info'],true);
	$posttime = time();
	$msg = "订单编号为：".$order_info['order_id']."的翻译订单已翻译完成，请在订单管理中下载译文";
	$sql="insert into yeedt_msg set msg='".$msg."',posttime='".$posttime."',type='".$order_info['orderStatus']."'";
	$db->query($sql,3);
	
	
	$sql="update yeedt_trans set status='".$order_info['status']."',en_title='".$order_info['en_title']."' where yeedt_order_id='".$order_info['order_id']."'";
	$db->query($sql,2);
}

?>