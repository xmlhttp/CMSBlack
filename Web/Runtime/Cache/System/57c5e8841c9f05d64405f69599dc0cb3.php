<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head >
    <title>Present by Richcomm.com.cn 管理中心 - 回复留言</title>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
    <link href="/Web/System/Public/css/main.css" type="text/css" rel="stylesheet"> 
    <script  src="/Public/jquery.js"></script>
    <script  src="/Public/jquery.form.js"></script>
</head>
<body>
<!--顶部导航开始-->
<div class="topnav">
<a  href="/System.php?s=/System/ManagerPage/BaseInfo.html" class="home">首页</a>><a href="/System.php?s=/System/Feedback">留言列表</a>><a href="javascript:void(0)">回复留言</a>
</div>
<!--顶部导航结束-->
<div class="cont_info">
<div class="tab_txt">
<div class="tab_tit">回复留言</div>
	<form method="post" action="<?php echo U('/System/Feedback/EditSave',array('id'=>I('get.id')));?>" id="form1" enctype="multipart/form-data">
	<table width="100%" border="0" cellpadding="2" cellspacing="0" class="info_tab">   
	
    <tr>
		<td align="right" style="width:25%">留言名称：</td>
		<td align="left"><input type="text" class="input1" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:400px" id="newtitle" name="newtitle" value="<?php echo ($info["newtitle"]); ?>"  /> <span style=" margin-left:5px; color:#F00; display:none" id="newtitle_tip">×留言名称不能为空</span></td>
    </tr> 
    <tr>
		<td align="right">留言账号：</td>
		<td  align="left" style="height:22px"><?php echo ($uname); ?> (<span style="color:#09F"> <?php echo ($info["uid"]); ?> </span>)</td>
    </tr>
    <tr>
		<td align="right">留言时间：</td>
		<td  align="left" style="height:22px"><?php echo ($info["addtime"]); ?></td>
    </tr>
     <tr>
		<td align="right">留言电话：</td>
		<td  align="left" style="height:22px"><?php echo ($info["tel"]); ?></td>
    </tr>
     <tr>
		<td align="right">留言邮箱：</td>
		<td  align="left" style="height:22px"><?php echo ($info["mail"]); ?></td>
    </tr>
    <tr>
		<td align="right">留言信息：</td>
		<td  align="left"><textarea class="input1" id="mark" name="mark" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:543px; height:68px" ><?php echo ($info["mark"]); ?></textarea></td>
    </tr>
	<tr>
		<td align="right">回复内容：</td>
		<td  align="left"><textarea class="input1" id="remark" name="remark" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:543px; height:68px" ><?php echo ($info["remark"]); ?></textarea></td>
    </tr>
    <tr>
      <td align="right">是否显示：</td>
      <td  align="left" style="height:30px">
      	<input type="radio" id="putout1" name="putout" value="1" <?php if($info['putout'] == 1): ?>checked="checked"<?php endif; ?> />是
      	<input type="radio" id="putout2" name="putout" value="0" style="margin-left:20px;"  <?php if($info['putout'] == 0): ?>checked="checked"<?php endif; ?>/>否
      </td>
    </tr>       
    <tr>
      <td align="right" height="50"></td>
      <td  align="left"><input type="button" class="btn" id="addsave" value="回复留言" style=" width:144px; height:30px" /> 
      </td>
    </tr>
  </table>
  </form>
  </div>
<div id="footer" class="info_foot">
	<script>document.write(cmsname)</script>
</div>
</div>

<script>
$("#addsave").click(function(){
	$("#newtitle_tip").hide();
	if($("#newtitle").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
		$("#newtitle_tip").show();
		alert("留言名称不能为空！");
		return false;	
	}
	$("#form1").ajaxSubmit({
		dataType:'json',
		success: function(d) {
			if(d["status"]["err"]==0){
				alert(d["status"]["msg"])
				window.location.href="/System.php?s=/System/Feedback"
			}else if(d["status"]["err"]==1){
				alert(d["status"]["msg"]);
				window.parent.location.href="<?php echo U('/System/Index');?>"
			}else{
				alert(d["status"]["msg"])	
			}
		},
		error:function(xhr){
			alert("保存失败！")
		}
	});
	return false;	
})
	
	
</script>


</body>
</html>