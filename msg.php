<?php
require_once 'global.php';


switch ($job)
{
	case 'read':
		$sql = "update yeedt_msg set is_read='1' where msg_id=$msg_id";
		$db->query($sql,2);
		
		$sql = "select * from yeedt_msg where msg_id=$msg_id";
		$rsdb = $db->get_one($sql);
		$posttime = date("Y-m-d H:i:s",$rsdb['posttime']);
		include 'tpl/msg/read.htm';
		break;
	case 'is_read':
		$sql = "update yeedt_msg set is_read='1' where msg_id=$msg_id";
		$db->query($sql,2);
		echo "<script>window.location='?job=';</script>";
		break;
	case 'delete':
			if($msg_id>0)
			{
				$sql = "delete from yeedt_msg where msg_id='$msg_id'";
				$row = $db->query($sql,2);
				if($row>0)
				{
					echo "<script>alert('删除成功');window.location='msg.php';</script>";
				}
				else
				{
					echo "<script>alert('删除失败');window.location='msg.php';</script>";
				}
			}
			else 
			{
				echo "<script>window.location='msg.php';</script>";
			}
		break;
	default:
		$page=new page();			
		$url="&job=".$job;
		if(trim($is_read)!="")
		{
			$where = " and is_read='".$is_read."'";
			$url.="&is_read=".$is_read;
		}
		$sql = "select *,from_unixtime(posttime) as posttime from yeedt_msg where 1 ".$where." order by msg_id desc";
		
		
		$pagehtml=$page->pages($sql,15,7,$url);
		$sql.=" limit $page->start,$page->pageSize";
		$rsdb = $db->fetch_all($sql);
		include 'tpl/msg/index.htm';
	break;

}	
?>