<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Present by vmuui.com 管理中心 - 邮箱设置</title>
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="/Web/System/Public/css/main.css" type=text/css rel=stylesheet>
<script  src="/Public/jquery.js"></script>
</head>
<body>
    <!--顶部导航开始-->
<div class="topnav">
<a href="<?php echo U('/System/ManagerPage/BaseInfo');?>" class="home">首页</a>><a href="<?php echo U('/System/ManagerPage/sitesetup');?>">系统管理</a>><a href="javascript:void(0)">邮箱设置</a>
</div>
<!--顶部导航结束-->
<div class="cont_info">

<div class="tab_txt">
<div class="tab_tit">邮箱设置</div>
<form  method="post"  id="form1" action="<?php echo U('/System/ManagerPage/MailSet_updata');?>" >
    <table width="100%" border="0" cellpadding="2" cellspacing="0"  class="siteup_tab">
        
        
        <tr>
          <td width="30%"  align="right" >SMTP服务器：</td>
          <td align="left"><input type="text" class="input1" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:240px" id="smtp" name="smtp" value="<?php echo ($Site["smtp"]); ?>" /> <span style=" margin-left:5px; color:#F00; display:none" id="smtp_tip">×不能为空</span>
          </td>
        </tr>
       
       
        <tr>
          <td align="right">账户：</td>
          <td align="left"><input type="text" class="input1" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:240px" id="mail" name="mail" value="<?php echo ($Site["mail"]); ?>" /><span style=" margin-left:5px; color:#F00; display:none" id="mail_tip">×不能为空</span>
			</td>
        </tr>
		<tr>
          <td align="right">密码：</td>
          <td align="left"><input type="password" class="input1" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:240px" id="mailpwd" name="mailpwd" value="<?php echo ($Site["mailpwd"]); ?>" maxlength="20" /><span style=" margin-left:5px; color:#F00; display:none" id="mailpwd_tip">×不能为空</span></td>
        </tr>
          
         <tr>
          <td align="right">收信人地址：</td>
          <td align="left"><input type="text" class="input1" onFocus="this.className='input1-bor'" onBlur="this.className='input1'" id="sadd" name="sadd" style="width:240px" value="<?php echo ($Site["mail"]); ?>" /><span style=" margin-left:5px; color:#F00; display:none" id="sadd_tip">×不能为空</span>		</td>
        </tr> 
          
         <tr>
          <td align="right">邮件文本模式：</td>
          <td align="left"><input type="radio" id="htmlmode_0" name="htmlmode" value="1" />纯文本模式	<input type="radio" id="htmlmode_1" name="htmlmode" value="0" style="margin-left:20px;" checked="checked" />HTML文本模式</td>
        </tr>
          
         <tr>
          <td align="right">其他帮助信息：</td>
          <td align="left" style="padding-top:10px; padding-bottom:10px">
          1. 在邮件标题和内容中，可采用#name 来转换为该用户的用户名。<br>2. 在检测SMTP的设置时最好先保存设置然后检测。
          
          
          </td>
        </tr> 

                 
        <tr>
          <td height="50" width="20%"></td>
          <td align="left"><input type="button" id="addsave" class="btn" value="保存参数" style=" width:144px; height:35px" /><input type="button" id="chkset" class="btn" value="检测SMTP设置" style=" width:144px; height:35px; margin-left:20px" />
          </td>
        </tr>
        
      </table>
      </form>
   </DIV>
<div id="footer" class="info_foot">
   <script>document.write(cmsname)</script>
</div>
</div>
<script>

$("#addsave").click(function(){
	$("#smtp_tip,#mail_tip,#mailpwd_tip,#sadd_tip").hide();
	if($("#smtp").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
		$("#smtp_tip").show();
		return false;	
	}
	if($("#mail").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
		$("#mail_tip").show();
		return false;	
	}
	if($("#mailpwd").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
		$("#mailpwd_tip").show();
		return false;	
	}
	var postdata=$("#form1").serialize();
	var url=$("#form1").attr("action");
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data:postdata
	}).done(function(d) {
		if(d["status"]["err"]==0){
			$("#sadd").val($("#mail").val())
			alert("修改成功！");
		}else if(d["status"]["err"]==1){
			alert(d["status"]["msg"]);
			window.parent.location.href="<?php echo U('/System/Index');?>"
		}else{
			alert(d["status"]["msg"])	
		}
	}).fail(function() {
		alert("网络连接错误，请稍后再试！")
	})
	return false
})

$("#chkset").click(function(){
	$("#smtp_tip,#mail_tip,#mailpwd_tip,#sadd_tip").hide();
	if($("#smtp").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
		$("#smtp_tip").show();
		return false;	
	}
	if($("#mail").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
		$("#mail_tip").show();
		return false;	
	}
	if($("#mailpwd").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
		$("#mailpwd_tip").show();
		return false;	
	}
	if($("#sadd").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
		$("#sadd_tip").show();
		return false;	
	}
	
	var postdata=$("#form1").serialize();
	var url="<?php echo U('/System/ManagerPage/MailSet_chk');?>";
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data:postdata
	}).done(function(d) {
		if(d["status"]["err"]==0){
			alert("邮箱检测成功！");
		}else if(d["status"]["err"]==1){
			alert(d["status"]["msg"]);
			window.parent.location.href="<?php echo U('/System/Index');?>"
		}else{
			alert(d["status"]["msg"])	
		}
	}).fail(function() {
		alert("网络连接错误，请稍后再试！")
	})
	return false
})



</script>
</body>
</html>