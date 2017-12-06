<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head >
    <title>Present by vmuui.com 管理中心 - 目录结构修改</title>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
    <link href="/Web/System/Public/css/main.css" type="text/css" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="/Web/System/Public/Tool/codebase/dhtmlxtree.css">
    <script  src="/Public/jquery.js"></script>
    <script  src="/Public/jquery.form.js"></script>
    <script type="text/javascript" src="/Web/System/Public/js/vmupload.js"></script>
</head>
<body>
<!--顶部导航开始-->
<div class="topnav">
<a  href="/System.php?s=/System/ManagerPage/BaseInfo.html" class="home">首页</a>><a href="javascript:void(0)">目录结构修改</a>
</div>
<!--顶部导航结束-->
<div class="cont_info">
<div class="tab_txt">
<div class="tab_tit">目录结构修改</div>
	<form method="post" action="<?php echo U('/System/ManagerPage/EditSave',array('id'=>I('get.id')));?>" id="form1" enctype="multipart/form-data">
	<table width="100%" border="0" cellpadding="2" cellspacing="0" class="info_tab">   
	<tr>
		<td align="right" style="width:25%">目录编号：</td>
		<td align="left"><?php echo ($xtree["id"]); ?></td>
    </tr>
    <tr>
		<td align="right">目录名称：</td>
		<td align="left"><input type="text" class="input1" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:240px;" id="content" name="content" value="<?php echo ($xtree["content"]); ?>" /> <span style=" margin-left:5px; color:#F00; display:none" id="content_tip">×不能为空</span></td>
    </tr> 
     <tr <?php if(strpos(',0,',','.I('get.id').',')!== false): ?>style="display:none"<?php endif; ?> >
		<td align="right">目录图片：</td>
		<td  align="left" style="height:86px">
        <div class="vmupload" style="<?php if(empty($xtree['top_img'])): else: ?>background:none<?php endif; ?>">
        <?php if(empty($xtree['top_img'])): ?><img class="vmupimg" src="" />
        <?php else: ?>
        	<img class="vmupimg" src="<?php echo ($xtree['top_img']); ?>" style="display:block" /><?php endif; ?>
            <div class="vmsame">
        	<div class="vmuptxt">
            	<div class="vmuptxtbg"></div>
                <div class="vmupname">目录图片</div>
                <div class="vmupsize">大小:450*310</div>
			</div>
            <input type="file" id="img" name="img" />
            </div>
            <img src="/Web/System/Public/images/swfupload/fancy_close.png" class="vmupclose" <?php if(empty($xtree['top_img'])): else: ?> style=" display:block"<?php endif; ?> />
        </div>
        
        </if>
         <div class="vmimgdesc">1、图片为通用目录图片，大小：450*310<br>2、前台显示的效果是预览框的等比缩放图<br>3、推荐上传指定大小的图片</div> 
        
		</td>
    </tr>       
    <tr>
		<td align="right">页面标题：</td>
		<td  align="left"><input type="text" class="input1" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:424px" id="page_tit" name="page_tit" value="<?php echo ($xtree["page_tit"]); ?>" /></td>
    </tr>
	<tr>
		<td align="right">页面关键字：</td>
		<td  align="left"><textarea class="input1" id="page_key" name="page_key" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:424px; height:53px" ><?php echo ($xtree["page_key"]); ?></textarea></td>
    </tr>
	<tr>
		<td align="right">页面描述：</td>
		<td  align="left"><textarea class="input1" id="page_des" name="page_des" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:424px; height:73px" ><?php echo ($xtree["page_des"]); ?></textarea></td>
	</tr>
    <tr>
      <td align="right" height="50"></td>
      <td  align="left"><input type="button" class="btn" id="addsave" value="修改信息" style=" width:144px; height:30px" /> 
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
	$("#content_tip").hide();
	if($("#content").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
		$("#content_tip").show();
		return false;	
	}
	$("#form1").ajaxSubmit({
		dataType:'json',
		success: function(d) {
			if(d["status"]["err"]==0){
				alert(d["status"]["msg"])
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