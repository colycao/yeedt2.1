var xmlHttp;
function S_xmlHttprequest()
{
	if(window.ActiveXObject)
	{
		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");		
	}
	else if(window.XMLHttpRequest)
	{
		xmlHttp=new XMLHttpRequest();
	}
}
function yanzhengma()
{
	
	document.getElementById("yanzhengmaimg").src="inc/image.php?"+new Date().getSeconds();;//这里必须加入随机数不然地址相同会重新加载
	S_xmlHttprequest();
	xmlHttp.open("GET","code.php",true);//打开链接 这里的url 比如在html页面中 onclick=funphp100(a) a的值就是url  在以GET传到 php文件中执行
	xmlHttp.onreadystatechange=code1;//准备就绪  要执行的内容 内容多的话 直接用函数方法来做
	xmlHttp.send(null);
}
function a()
{
	S_xmlHttprequest();
	xmlHttp.open("GET","code.php",true);//打开链接 这里的url 比如在html页面中 onclick=funphp100(a) a的值就是url  在以GET传到 php文件中执行
	xmlHttp.onreadystatechange=code1;//准备就绪  要执行的内容 内容多的话 直接用函数方法来做
	xmlHttp.send(null);
}
function code1()
{
	if(xmlHttp.readyState==4)
	{
		if(xmlHttp.status==200)
		{
			var byphp100=xmlHttp.responseText;
			if(byphp100=="")
			{
				a();	
			}
			document.getElementById("yanzheng1").value=byphp100;
			
		}
	}
	
}
function check1()
{
	document.getElementById("userNameDiv").innerHTML="不能有空格，可以是中文，长度控制在6~15个字节以内，不区分大小写";
	userNameDiv.style.background="#FFF";
}
function check2()
{
	var userNameDiv=document.getElementById("userNameDiv");
	var userName=document.getElementById("userName");
	var myreg1 = /[\#\$\%\^\&\*\(\)\@\!\-\+]/;
	if(!myreg1.test(userName.value))
	{
		if(userName.value.length<5||userName.value.length>15)
		{
			if(userName.value.length==0)
			{
				document.getElementById("userNameDiv").innerHTML="不能有空格，可以是中文，长度控制在5~15个字节以内，不区分大小写";
				userNameDiv.style.background="#FFF";
				return false;	
			}
			else
			{
				userNameDiv.style.background="#FFC1C1";
				userNameDiv.innerHTML="<div style='width:18px; height:17px; float:left;'><img src=\"images/200822810954_15_mb5u_com.gif\" style='width:18px; height:17px;' /></div><div style='float:left;padding-top:2px; padding-left:5px;color:#D20F0F;'>用户名长度错误！</div>";
				return false;	
			}
		}
		else
		{
			document.getElementById("userNameDiv").innerHTML="loading.....";
			$.post("ckcJson.php",{username:userName.value}, function(data){
				document.getElementById("userNameDiv").innerHTML=data.a;
				document.getElementById("codeuser").value=data.b;
			},'json'); 
			
			return true;
		}
	}
	else
	{
			userNameDiv.style.background="#FFC1C1";
				userNameDiv.innerHTML="<div style='width:18px; height:17px; float:left;'><img src=\"images/200822810954_15_mb5u_com.gif\" style='width:18px; height:17px;' /></div><div style='float:left;padding-top:2px; padding-left:5px;color:#D20F0F;'>您填入的用户名有非法字符！</div>";
				return false;	
	}
	
}

function userAlias1()
{
	if(xmlHttp.readyState==1)
	{
		document.getElementById("userNameDivq").innerHTML="loading.....";
	}
	else if(xmlHttp.readyState==4)
	{
		if(xmlHttp.status==200)
		{
			var byphp100=xmlHttp.responseText;
			document.getElementById("userNameDivq").innerHTML=byphp100;
		}
	}
	
	
}
function check3()
{
	document.getElementById("userNameDiv1").innerHTML="长度控制在6~16个字节以内";
	document.getElementById("userNameDiv1").style.background="#FFF";
}
function check4()
{
	var userNameDiv1=document.getElementById("userNameDiv1");
	var userPwd=document.getElementById("userPwd");
	if(userPwd.value.length<6||userPwd.value.length>15)
	{
		if(userPwd.value.length==0)
		{
			document.getElementById("userNameDiv1").innerHTML="长度控制在6~16个字节以内";
			userNameDiv1.style.background="#FFF";
			return false;	
		}
		else
		{
			if(userPwd.value.length<6)
			{
				userNameDiv1.style.background="#FFC1C1";
				userNameDiv1.innerHTML="<div style='width:18px; height:17px; float:left;'><img src=\"images/200822810954_15_mb5u_com.gif\" style='width:18px; height:17px;' /></div><div style='float:left;padding-top:2px; padding-left:5px;color:#D20F0F;'>密码设置错误，密码长度过小！</div>";
				return false;	
			}
			else if(userPwd.value.length>15)
			{
				userNameDiv1.style.background="#FFC1C1";
				userNameDiv1.innerHTML="<div style='width:18px; height:17px; float:left;'><img src=\"images/200822810954_15_mb5u_com.gif\" style='width:18px; height:17px;' /></div><div style='float:left;padding-top:2px; padding-left:5px;color:#D20F0F;'>密码设置错误，密码长度过长！</div>";
				return false;	
			}
		}
	}
	else
	{
		document.getElementById("userNameDiv1").innerHTML="<div style='width:18px; height:17px; float:left;'><img src=\"images/001_06.png\" style='width:18px; height:17px;' /></div>";
		userNameDiv1.style.background="#FFF";
		return true;
	}
}

function check5()
{
	document.getElementById("userNameDiv2").innerHTML="请再次输一遍您上面所填写的密码";
	document.getElementById("userNameDiv2").style.background="#FFF";
}
function check6()
{
	var userNameDiv2=document.getElementById("userNameDiv2");
	var userPwd=document.getElementById("userPwd");
	var userPwdConf=document.getElementById("userPwdConf");
	if(userPwdConf.value==userPwd.value)
	{
		document.getElementById("userNameDiv2").innerHTML="<div style='width:18px; height:17px; float:left;'><img src=\"images/001_06.png\" style='width:18px; height:17px;' /></div>";
		userNameDiv2.style.background="#FFF";
		return true;
	}
	else
	{
		userNameDiv2.style.background="#FFC1C1";
		userNameDiv2.innerHTML="<div style='width:18px; height:17px; float:left;'><img src=\"images/200822810954_15_mb5u_com.gif\" style='width:18px; height:17px;' /></div><div style='float:left;padding-top:2px; padding-left:5px;color:#D20F0F;'>您两次输入的密码不一致,请再次输入您上面的密码！</div>";
		return false;	
	}
}


function check7()
{
	document.getElementById("userNameDiv3").innerHTML="请选择性别";
	document.getElementById("userNameDiv3").style.background="#FFF";
}

function check9()
{
	document.getElementById("userNameDiv6").innerHTML="请输入图片中的字符";
	document.getElementById("userNameDiv6").style.background="#FFF";
}
function check10()
{
	var userNameDiv6=document.getElementById("userNameDiv6");
	var yanzheng1=document.getElementById("yanzheng1");
	var yanzheng=document.getElementById("yanzheng");
	if(yanzheng.value.length==0)
	{
		document.getElementById("userNameDiv6").innerHTML="请输入图片中的字符";
		document.getElementById("userNameDiv6").style.background="#FFF";
		return false;
	}
	else if(yanzheng.value!=yanzheng1.value)
	{
		userNameDiv6.style.background="#FFC1C1";
		userNameDiv6.innerHTML="<div style='width:18px; height:17px; float:left;'><img src=\"images/200822810954_15_mb5u_com.gif\" style='width:18px; height:17px;' /></div><div style='float:left;padding-top:2px; padding-left:5px;color:#D20F0F;'>请输入与图片中匹配的字符！</div>";
		return false;
	}
	else
	{
		document.getElementById("userNameDiv6").innerHTML="<div style='width:18px; height:17px; float:left;'><img src=\"images/001_06.png\" style='width:18px; height:17px;' /></div>";
		userNameDiv3.style.background="#FFF";
		return true;
	}
}


function check10()
{
	var userNameDiv6=document.getElementById("userNameDiv6");
	var yanzheng1=document.getElementById("yanzheng1");
	var yanzheng=document.getElementById("yanzheng");
	if(yanzheng.value.length==0)
	{
		document.getElementById("userNameDiv6").innerHTML="请输入图片中的字符";
		document.getElementById("userNameDiv6").style.background="#FFF";
		return false;
	}
	else if(yanzheng.value!=yanzheng1.value)
	{
		userNameDiv6.style.background="#FFC1C1";
		userNameDiv6.innerHTML="<div style='width:18px; height:17px; float:left;'><img src=\"images/200822810954_15_mb5u_com.gif\" style='width:18px; height:17px;' /></div><div style='float:left;padding-top:2px; padding-left:5px;color:#D20F0F;'>请输入与图片中匹配的字符！</div>";
		return false;
	}
	else
	{
		document.getElementById("userNameDiv6").innerHTML="<div style='width:18px; height:17px; float:left;'><img src=\"images/001_06.png\" style='width:18px; height:17px;' /></div>";
		userNameDiv3.style.background="#FFF";
		return true;
	}
}

function insert()
{
	var userName=$("#userName").val();
	var codeuser=$("#codeuser").val();
	var userPwd=$("#userPwd").val();
	var userPwdConf=$("#userPwdConf").val();
	var userNameDiv=document.getElementById("userNameDiv");
	var userNameDiv2=document.getElementById("userNameDiv2");
	var myreg1 = /[\#\$\%\^\&\*\(\)\@\!\-\+]/;
	if(!myreg1.test(userName))
	{
		if(userName<5||userName>15)
		{
			if(userName==0)
			{
				document.getElementById("userNameDiv").innerHTML="<div style='float:left;padding-top:2px; padding-left:5px;color:#D20F0F;'>不能有空格，可以是中文，长度控制在5~15个字节以内，不区分大小写</a>";
				userNameDiv.style.background="#FFF";
				return false;	
			}
			else
			{
				userNameDiv.style.background="#FFC1C1";
				userNameDiv.innerHTML="<div style='width:18px; height:17px; float:left;'><img src=\"images/200822810954_15_mb5u_com.gif\" style='width:18px; height:17px;' /></div><div style='float:left;padding-top:2px; padding-left:5px;color:#D20F0F;'>用户名长度错误！</div>";
				return false;	
			}
		}
		
	}
	if(codeuser==1)
	{
		userNameDiv.style.background="#FFC1C1";
		userNameDiv.innerHTML="<div style='width:18px; height:17px; float:left;'><img src=\"images/200822810954_15_mb5u_com.gif\" style='width:18px; height:17px;' /></div><div style='float:left;padding-top:2px; padding-left:5px;color:#D20F0F;'>用户名已存在！</div>";
		return false;		
	}
	if(userPwdConf!=userPwd)
	{
		userNameDiv2.style.background="#FFC1C1";
		userNameDiv2.innerHTML="<div style='width:18px; height:17px; float:left;'><img src=\"images/200822810954_15_mb5u_com.gif\" style='width:18px; height:17px;' /></div><div style='float:left;padding-top:2px; padding-left:5px;color:#D20F0F;'>您两次输入的密码不一致,请再次输入您上面的密码！</div>";
		return false;	
	}
	var userNameDiv1=document.getElementById("userNameDiv1");
	if(userPwd<6||userPwd>15)
	{
		if(userPwd==0)
		{
			document.getElementById("userNameDiv1").innerHTML="<div style='float:left;padding-top:2px; padding-left:5px;color:#D20F0F;'>长度控制在6~16个字节以内</a>";
			userNameDiv1.style.background="#FFF";
			return false;	
		}
		else
		{
			if(userPwd<6)
			{
				userNameDiv1.style.background="#FFC1C1";
				userNameDiv1.innerHTML="<div style='width:18px; height:17px; float:left;'><img src=\"images/200822810954_15_mb5u_com.gif\" style='width:18px; height:17px;' /></div><div style='float:left;padding-top:2px; padding-left:5px;color:#D20F0F;'>密码设置错误，密码长度过小！</div>";
				return false;	
			}
			else if(userPwd>15)
			{
				userNameDiv1.style.background="#FFC1C1";
				userNameDiv1.innerHTML="<div style='width:18px; height:17px; float:left;'><img src=\"images/200822810954_15_mb5u_com.gif\" style='width:18px; height:17px;' /></div><div style='float:left;padding-top:2px; padding-left:5px;color:#D20F0F;'>密码设置错误，密码长度过长！</div>";
				return false;	
			}
		}
	}
	
	document.form1.submit();
}
