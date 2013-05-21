<?php header("Content-type:text/html;charset=utf-8");
require_once 'global.php';

switch ($job)
{
	case 'trans':
			//$qualityLevels = json_decode(PostHttpRequest($requestUrl."/interface/getQualityLevels"),true);
			//$translateLanguages = json_decode(PostHttpRequest($requestUrl."/interface/getTranslateLanguages"),true);
			
			include 'tpl/trans/trans.htm';
		break;
	
	case 'file':
			//$qualityLevels = json_decode(PostHttpRequest($requestUrl."/interface/getQualityLevels"),true);
			//$translateLanguages = json_decode(PostHttpRequest($requestUrl."/interface/getTranslateLanguages"),true);
			
			include 'tpl/trans/file.htm';
		break;
		
	case 'confirm':
			$translateLanguages = $translateLanguages ? $translateLanguages : "中文->英文";
			$qualityLevels = $qualityLevels ? $qualityLevels : "标准";
			$title = ("标题可不填" == $title) ? "" : $title;
			$content = addslashes($content);
			$sql="insert into yeedt_trans set languages_key='$translateLanguages',qualityLevels_key='$qualityLevels',title='$title',content='$content'";
			$row = $db->query($sql,3);
			if($row)
			{
				$order_id = $yeedt_id."-".rand(10000, 99999)."-P".$row;
				$sql="update yeedt_trans set order_id='$order_id' where id='$row'";
				$db->query($sql,2);
			}
			else
			{
				echo "<script>alert('翻译内容提交失败');history.go(-1);</script>";
			}
			
			$transArr = array(
				array(
					'title'=>$title,
					'content'=>$content,
				),
			);
			
			$strContent = json_encode($transArr);
			
			$jsonArr['yeedt_id'] = $yeedt_id;
			$jsonArr['yeedt_key'] = $yeedt_key;
			$jsonArr['contentArr'] = $strContent;
			$jsonArr['qualityLevels'] = $qualityLevels;
			$jsonArr['translateLanguages'] = $translateLanguages;
			
			
			$proxy_key = json_encode(array($row));
			
			$enarr = json_encode($jsonArr);
			
			$a =PostHttpRequest($requestUrl."/interface/getWordCount","info={$enarr}");
			$data = json_decode($a,true);
			
			if($data['errcode']=='001')
			{
				echo "<script>alert('yeedt_id和yeedt_key验证未通过');history.go(-1);</script>";
			}
			else if($data['errcode']=='002')
			{
				echo "<script>alert('提交的语种验证错误');history.go(-1);</script>";
			}
			else if($data['errcode']=='003')
			{
				echo "<script>alert('提交的级别验证错误');history.go(-1);</script>";
			}
			else if($data['errcode']=='004')
			{
				echo "<script>alert('提交的内容为空');history.go(-1);</script>";
			}
			else if($data['errcode']=='005')
			{
				echo "<script>alert('提交的内容不是二维数组的JSON格式');history.go(-1);</script>";
			}		
			$dataInfo = $data['info'];
			
			
			
			$sql="update yeedt_trans set languages='$dataInfo[translateLanguages]',qualityLevels='$dataInfo[qualityLevels]',wordCount='$dataInfo[wordCount]',price='$dataInfo[price]' where id='$row'";
			$db->query($sql,2);
			
			include 'tpl/trans/confirm.htm';
		break;
	
	case 'read':
			$sql = "select * from yeedt_trans where id='$id'";
			$rsdb = $db->get_one($sql);
			include 'tpl/trans/read.htm';
		break;

	case 'getPayStatus':
			$sql = "select * from yeedt_trans where id='$id'";
			$rsdb = $db->get_one($sql);
			
			$payStatus = PostHttpRequest($requestUrl."/interface/getPayStatus/?proxy_order_number=".$rsdb['order_id']."&yeedt_order_id=".$rsdb['yeedt_order_id'],"order_info={$enarr}");
			
			$payRs = explode(',', $payStatus);
		
			
			$sql="update yeedt_trans set yeedt_order_id='$payRs[0]',status='$payRs[1]' where id='$id'";
			$db->query($sql,2);
			echo "<script>window.location='trans.php';</script>";
			
		break;
	
	case 'original':
			$sql = "select * from yeedt_trans where id='$id'";
			$rsdb = $db->get_one($sql);
			include 'tpl/trans/original.htm';
		break;
		
	case 'translation':
			$sql = "select * from yeedt_trans where id='$id'";
			$rsdb = $db->get_one($sql);
			include 'tpl/trans/translation.htm';
		break;
	case 'delete':
			if($id>0)
			{
				$sql = "delete from yeedt_trans where id='$id'";
				$row = $db->query($sql,2);
				if($row>0)
				{
					echo "<script>alert('删除成功');window.location='trans.php';</script>";
				}
				else
				{
					echo "<script>alert('删除失败');window.location='trans.php';</script>";
				}
			}
			else 
			{
				echo "<script>window.location='trans.php';</script>";
			}
		break;

	case 'pay':
			if($id>0)
			{
				$sql = "select * from yeedt_trans where id='$id' ";
				$rs=$db->get_one($sql);
				
				if($rs[status] == 'new'||$rs[status] == '')
				{
					$transArr = array(
					array(
						'title'=>$rs['title'],
						'content'=>$rs['content'],
						),
					);
					
					$strContent = json_encode($transArr);
					
					$proxy_key = json_encode(array($id));
					
					
					echo "
					<html>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
					<body onload='document.form1.submit();'>
					<form name='form1' method='post' action='".$requestUrl."/interface/webtrans' target='_parent _blank'>
					<input type='hidden' name='content'		value='".$strContent."'>
					<input type='hidden' name='language'	value='".$rs[languages_key]."'>
					<input type='hidden' name='qualityLevels'	value='".$rs[qualityLevels_key]."'>
					<input type='hidden' name='yeedt_id'	value='".$yeedt_id."'>
					<input type='hidden' name='yeedt_key'	value='".$yeedt_key."'>
					<input type='hidden' name='proxy_key'	value='".$proxy_key."'>
					<input type='hidden' name='order_number' value='".$rs[order_id]."'>
					<input type='hidden' name='returnUrl'	value='".$returnUrl."/request.php'>
					<input type='hidden' name='f_username'	value='".$f_username."'>
					<input type='hidden' name='f_address'	value='".$f_address."'>
					<input type='hidden' name='f_company'	value='".$f_company."'>
					<input type='hidden' name='f_tel'	value='".$f_tel."'>
					<input type='hidden' name='f_title'	value='".$f_title."'>
					<input type='hidden' name='f_phone'	value='".$f_phone."'>
					<input type='hidden' name='proxyUrl'	value='".$proxyUrl."'>
					<input type='hidden' name='f_email'	value='".$f_email."'>
					</body>
					</html>
					";
				
				}
				else
				{
					echo "<script>alert('该订单已经支付');window.location='trans.php';</script>";
				}
			}
		break;	
	
	case 'filePay':
			if($id>0)
			{
				$sql = "select * from yeedt_trans where id='$id' ";
				$rs=$db->get_one($sql);
				
				if($rs[status] == 'new'||$rs[status] == '')
				{
					echo "
					<html>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
					<body onload='document.form1.submit();'>
					<form name='form1' method='post' action='".$requestUrl."/interface/filetrans' target='_parent _blank'>
					<input type='hidden' name='yeedt_id'	value='".$yeedt_id."'>
					<input type='hidden' name='yeedt_key'	value='".$yeedt_key."'>
					<input type='hidden' name='yeedt_order_id' value='".$rs[yeedt_order_id]."'>
					<input type='hidden' name='f_username'	value='".$f_username."'>
					<input type='hidden' name='f_address'	value='".$f_address."'>
					<input type='hidden' name='f_company'	value='".$f_company."'>
					<input type='hidden' name='f_tel'	value='".$f_tel."'>
					<input type='hidden' name='f_title'	value='".$f_title."'>
					<input type='hidden' name='f_phone'	value='".$f_phone."'>
					<input type='hidden' name='proxyUrl'	value='".$proxyUrl."'>
					<input type='hidden' name='f_email'	value='".$f_email."'>
					</body>
					</html>
					";
				
				}
				else
				{
					echo "<script>alert('该订单已经支付');window.location='trans.php';</script>";
				}
			}
		break;	
		
	default:
			$sql = "select count(msg_id) as count from yeedt_msg where is_read='0'";
			$msgRs = $db->get_one($sql);
			
			$page=new page();			
			$url="&job=".$job;
			$sql = "select * from yeedt_trans order by id desc";
			
			$pagehtml=$page->pages($sql,10,7,$url);
			$sql.=" limit $page->start,$page->pageSize";
			
			$newsRs = $db->fetch_all($sql);
			include 'tpl/trans/index.htm';
		break;
}

?>