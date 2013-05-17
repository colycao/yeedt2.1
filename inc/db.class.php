<?php
	class db
	{
		public $conn;
		public $db,$user,$pwd,$host,$arr;
		
		function db()
		{
			$this->user=USER;
			$this->pwd=PWD;
			$this->host=HOST;
			$this->db=DB;
			$this->conn=mysql_connect($this->host,$this->user,$this->pwd) or die ("系统初始化失败");
			mysql_select_db($this->db);
			mysql_query("set names 'UTF8'");
			
		}
		
		//定义数据库操纵方法
		function query($sql,$type=0)
		{
			
			$result=mysql_query($sql) or die(mysql_error());
			switch($type)
			{
				case 1:$result=mysql_num_rows($result);break;
			/*	mysql_num_rows(mysql_query($sql))用户登录后台  查询密码和用户名匹配的记录集 数量>0 成功*/
				case 2:$result=mysql_affected_rows();break;
				case 3:$result=mysql_insert_id();break;
				
			}
			return $result;	
		}
		
		
		function fetch($sql,$type=1)
		{
			$res=$this->query($sql);
			
			if($type==2)
			{
				while($rs=mysql_fetch_array($res))
				{
					$temp[]=$rs;//将循环出来的值放入一个二维数组中 
				}
				//$temp["row"]=$rs["row"];
//				$temp["res"]=$rs["res"];
				return $temp;
			}
			else
			{
				
				$rs=mysql_fetch_array($res);
				//  mysql_fetch_array(mysql_query($sql))
				return $rs;
			}
		}
		
		//定义取结果集的方法
		function fetch_all($sql)
		{
			$res=$this->query($sql);
			
			while($rs=mysql_fetch_array($res))
			{
				$temp[]=$rs;//将循环出来的值放入一个二维数组中 
			}
			return $temp;
			
		}
		function get_one($sql)
		{
			$res=$this->query($sql);
			$rs=mysql_fetch_array($res);
			//  mysql_fetch_array(mysql_query($sql))
			return $rs;
		}
		function insertSql($table,$array)
		{
			foreach($array AS $key=>$value){
				$sqlDB[]="`{$key}`='$value'";
			}
			$this->query("INSERT INTO ".$table." SET ".implode(",",$sqlDB));
			return $insertID=mysql_insert_id();
		}
		//更新数据
		function updateSql($table,$array,$tiaojian)
		{
			foreach($array AS $key=>$value){
				$sqlDB[]="`{$key}`='$value'";
			}
			$this->query("UPDATE ".$table." SET ".implode(",",$sqlDB)." where ".$tiaojian);
			"UPDATE ".$table." SET ".implode(",",$sqlDB)." where ".$tiaojian;
			return $updateID=mysql_affected_rows();
		}
		
	}
	
	
	class page extends db
	{
		//定义  页面容纳条目  当前页   ，总页 ，   起始条目
		public $pageSize,$curPage,$totalPage,$start;
		//定义翻页标志
		public $flag;
		//定义总记录条目
		public $totalRec;
		function pages($sql,$pageSize=3,$page_len=7,$url="",$flag="page")
		{
			$this->pageSize=$pageSize;
			$this->flag=$flag;
			$res=parent::query($sql,1);
			$this->totalRec=$res;
			$this->totalPage=ceil($this->totalRec/$this->pageSize);
			$page=$_REQUEST[$this->flag];
			$init=1;
			$page_len=$page_len; 
			$max_p=$this->totalPage;
			$pages=$this->totalPage;
			if($page==""||$page<=0)
			{
				$page=1;
			}
			else
			{
				$page>$this->totalPage?$this->curPage=$this->totalPage:$this->curPage=$page;
			}
			
			//$limits=($this->curPage-1)*$this->pageSize.",".$this->pageSize;
			$this->start=($page-1)*$this->pageSize;
			$pageoffset = ($page_len-1)/2;//页码个数左右偏移量
	
			$str='<div class="page">';
			
			if($page>1)
			{
				$str.="<a class='pageOnline' href=\"?page=1".$url."\">第一页</a> ";				//第一页
				$str.="<a class='pageOnline' href=\"?page=".($page-1).$url."\">上一页</a>";	//上一页
			}
			else 
			{
				$str.="<a class='pageOnline' style='cursor:pointer;' onclick='return false;'>第一页</a> ";//第一页
				$str.="<a class='pageOnline' style='cursor:pointer;' onclick='return false;'>上一页</a>";	//上一页
			}
		
			if($this->totalPage>$page_len)//如果总页数大于7
			{
				//如果当前页小于等于左偏移
				if($page<=$pageoffset)//如果当前页面小于等于3
				{
					$init=1;
					$max_p = $page_len;
				}
				else
				{
					//如果当前页大于左偏移
					//如果当前页码右偏移超出最大分页数
					if($page+$pageoffset>=$this->totalPage+1)
					{
						$init = $this->totalPage-$page_len+1;
						$max_p=$this->totalPage;
					}
					else
					{
						//左右偏移都存在时的计算
						$init = $page-$pageoffset;
						$max_p = $page+$pageoffset;
					}
				}
			}
			for($i=$init;$i<=$max_p;$i++)
			{
			
				if($i==$page)
				{
					$str.="&nbsp;&nbsp;&nbsp;<a class='spanOnline1 spanOnline' onclick='return false;'>".$i."</a>";//如果当前页等于init 那么需要的点击 所以不要链接<a>
				} 
				else
				{
					$str.="&nbsp;&nbsp;&nbsp;<a class='pageOnline' href=\"?page=".$i.$url."\">".$i."</a>";
				}
			}
		
			if($page<$pages)
			{
				$str.="&nbsp;&nbsp;&nbsp;<a class='pageOnline' href=\"?page=".($page+1).$url."\">下一页</a> ";//下一页
				$str.="<a class='pageOnline' href=\"?page={$this->totalPage}".$url."\">最后一页</a>";	//最后一页
			}
			else 
			{
				$str.="&nbsp;&nbsp;&nbsp;<a class='pageOnline' style='cursor:pointer;' onclick='return false;'>下一页</a> ";//下一页
				$str.="<a class='pageOnline' style='cursor:pointer;' onclick='return false;'>最后一页</a>";	//最后一页
			}
			$str.='</div>';
			return $str;
		} 
	}
	
	
//购物车的类
?>
