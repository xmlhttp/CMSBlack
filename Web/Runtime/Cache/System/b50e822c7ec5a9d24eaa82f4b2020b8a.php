<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head >
    <title>Present by vmuui.com 管理中心 - 添加消息</title>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
    <link href="/Web/System/Public/css/main.css" type="text/css" rel="stylesheet"> 
    <script  src="/Public/jquery.js"></script>
    <script  src="/Public/jquery.form.js"></script> 
    
    <script type="text/javascript" charset="utf-8" src="/Web/BEditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Web/BEditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/Web/BEditor/lang/zh-cn/zh-cn.js"></script>
    
    
       
</head>
<body>
<!--顶部导航开始-->
<div class="topnav">
<a  href="/System.php?s=/System/ManagerPage/BaseInfo.html" class="home">首页</a>><a href="/System.php?s=/System/SmsAll">推送管理</a>><a href="javascript:void(0)">添加消息</a>
</div>
<!--顶部导航结束-->
<div class="cont_info">
<div class="tab_txt">
<div class="tab_tit">添加消息</div>
	<form method="post" action="<?php echo U('/System/SmsAll/AddSave');?>"  id="form1"  enctype="multipart/form-data">
    <table width="100%" border="0" cellpadding="2" cellspacing="0" class="info_tab">
   
     <tr>
      <td align="right" style="width:25%">信息标题：</td>
      <td  align="left"><input type="text" id="Newtitle" name="Newtitle" class="input1" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:424px; margin-left:5px" />  <span style=" margin-left:5px; color:#F00; display:none" id="Newtitle_tip">×标题不能为空</span>   
      </td>
    </tr>
    
    
    <tr>
      <td align="right">信息简介：</td>
      <td  align="left"><textarea class="input1" id="Newdesc" name="Newdesc" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:424px; height:68px;margin-left:5px" ></textarea><span style="margin-left:15px; color:#F00; display:none" id="Newdesc_tip">×简介不能为空</span>
     
      </td>
    </tr>
    
     <tr>
      <td align="right" style="vertical-align:top; padding-top:5px">信息内容：</td>
      <td  align="left">
      <input type="hidden" id="Newcontent" name="Newcontent" value="" />
		<div style="margin-left:5px; width:555px;" id="editor"></div>      
      </td>
    </tr>
    <tr>
      <td align="right">推送目标：</td>
      <td  align="left">
		<input type="radio" id="targets1" name="targets" checked="checked" value="0"/>全部
      	<input type="radio" id="targets2" name="targets" value="1" style="margin-left:20px;"/>安卓
        <input type="radio" id="targets3" name="targets" value="2" style="margin-left:20px;"/>苹果
      </td>
    </tr>
    
    
    
    <tr>
      <td align="right">是否显示：</td>
      <td  align="left">
		<input type="radio" id="putout1" name="putout" checked="checked" value="1"/>是
      	<input type="radio" id="putout2" name="putout" value="0" style="margin-left:20px;"/>否
      </td>
    </tr>
    <tr>
      <td align="right" height="50"></td>
      <td  align="left"><input type="button" class="btn" value="发布消息" id="addsave" style=" width:144px; height:30px" /> 
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
$(function(){UE.getEditor('editor')})
$("#addsave").click(function(){
	$("#Newtitle_tip,#Newdesc_tip").hide();
	if($("#Newtitle").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
		$("#Newtitle_tip").show()
		return;
	}
	if($("#Newdesc").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
		$("#Newdesc_tip").show()
		return;
	}
	$("#Newcontent").val(UE.getEditor('editor').getContent())
	$("#form1").ajaxSubmit({
		dataType:  'json',
		success: function(data) {
			if(data["status"]["err"]==0){
				window.location.href="<?php echo U('/System/SmsAll');?>";
			}else if(data["status"]["err"]==1){
				alert(data["status"]["msg"]);
				window.parent.location.href="<?php echo U('/System/Index');?>"
			}else{
				alert(data["status"]["msg"])	
			}
		},
		error:function(xhr){
			alert("保存失败！")
		}
	});
	return false;	
});
		

</script>


</body>
</html>