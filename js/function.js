// JavaScript Document
function del(msg,url,id)
{
	if(confirm(msg))
	{
		window.location=url+"?id="+id;
	}
	else
	{
		return false;	
	}
}



function xiugai_cate(cateId,url)
{

		window.location=url+"?id="+cateId;
}

function postdo(va,ids)
{
	if(va=="del")
	{
		if(confirm('你确定要删除吗?'))
		{
			document.form_work.jobs.value=va;
			document.form_work.submit();
		}
	}
	else if(va=="qk")
	{
		if(confirm('你确定要清空吗?'))
		{
			document.form_work.jobs.value=va;
			document.form_work.submit();
		}
	}
	else
	{
		document.form_work.jobs.value=va;
		document.form_work.tj.value=ids;
		document.form_work.submit();
	}
}
function quanxuan()
{
	var chk=document.getElementsByName("newsID[]");
	for(var i=0;i<chk.length;i++)
	{
		chk[i].checked=true;
	}
}
function fanxuan()
{
	var chk=document.getElementsByName("newsID[]");
	for(var i=0;i<chk.length;i++)
	{
		if(chk[i].checked==true)
		{
			chk[i].checked=false;
		}
		else
		{
			chk[i].checked=true;
		}
	}
}
function delxuan(msg,url,id)
{
	var chk=document.getElementsByName("newsID[]");
	var valueChk="";
	var ck=0;
	if(confirm(msg))
	{
		for (var i=0;i<chk.length;i++)
		{
			if(chk[i].checked==true)
			{
				ck++;
            }
        }

		if(ck!=0)
		{
			for(var i=0;i<chk.length;i++)
			{
				if(chk[i].checked==true)
				{
					if(valueChk=="")
					{
						valueChk=chk[i].value+",";
					}
					else
					{
						valueChk+=chk[i].value+",";
					}
			
				}
				
			}
		}
		else
		{
			alert("请先选择您要删除的内容");
			return false;
		}
	}
	else
	{
		return false;	
	}
	 
	valueChk+=0;
	window.location=url+"?"+id+"="+valueChk;
}

//判断是不是数字
function isNumber(obj){   event.returnValue  = false;  if(event.keyCode==8 || event.keyCode==46 ||event.keyCode>=35 && event.keyCode<=39){      event.returnValue=true;  }  if(event.keyCode==190 && obj.value.indexOf(".")==-1){    event.returnValue=true;  }  if(event.keyCode>=48 && event.keyCode<=57){      event.returnValue=true;  }}


$(document).ready(function(){

	$(".shows").hover(
			function()
			{
				$(".shows").children().hide(); 
				$(this).children().show(); 
			}
			,function()
			{
				$(this).children().hide(); 
			}
	);
});


