<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head >
    <title>Present by Richcomm.com.cn 管理中心 -修改用户</title>
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
<a  href="/System.php?s=/System/ManagerPage/BaseInfo.html" class="home">首页</a>><a href="/System.php?s=/System/userAll">会员信息</a>><a href="javascript:void(0)">添加消息</a>
</div>
<!--顶部导航结束-->
<div class="cont_info">
<div class="tab_txt">
<div class="tab_tit">添加消息</div>
	<form method="post" action="<?php echo U('/System/SmsAll/EditSave',array('id'=>I('get.id')));?>"  id="form1"  enctype="multipart/form-data">
    <table width="100%" border="0" cellpadding="2" cellspacing="0" class="info_tab">
   
     <tr>
      <td align="right" style="width:25%">信息标题：</td>
      <td  align="left"><input type="text" id="Newtitle" name="Newtitle" class="input1" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  disabled="disabled" style="width:424px; margin-left:5px" value="<?php echo ($sms["Newtitle"]); ?>" />
      </td>
    </tr>
    
    
    <tr>
      <td align="right">信息简介：</td>
      <td  align="left"><textarea class="input1" id="Newdesc" name="Newdesc" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:424px; height:68px;margin-left:5px"  disabled="disabled" ><?php echo ($sms["Newdesc"]); ?></textarea>
     
      </td>
    </tr>
    
     <tr>
      <td align="right" style="vertical-align:top; padding-top:5px">信息内容：</td>
      <td  align="left">
      <input type="hidden" id="Newcontent" name="Newcontent" />
		<div style="margin-left:5px; width:555px;" id="editor"></div>      
      </td>
    </tr>
    
    <tr>
      <td align="right">是否显示：</td>
      <td  align="left">
		<input type="radio" id="putout1" name="putout" value="1"  <?php if($sms["putout"] == 1): ?>checked="checked"<?php endif; ?>/>是
      	<input type="radio" id="putout2" name="putout" value="0" style="margin-left:20px;"  <?php if($sms["putout"] == 0): ?>checked="checked"<?php endif; ?>/>否
      </td>
    </tr>
    <tr>
      <td align="right" height="50"></td>
      <td  align="left"><input type="button" class="btn" value="修改消息" id="addsave" style=" width:144px; height:30px" /> 
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
$(function(){
	UE.getEditor('editor').addListener("ready", function () {
      	this.setContent('<?php echo ($sms["Newcontent"]); ?>')
	});
})

$("#addsave").click(function(){
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