<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head >
    <title>Present by Richcomm.com.cn 管理中心 - 添加管理员</title>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
    <link href="/Web/System/Public/css/main.css" type="text/css" rel="stylesheet"> 
    <script>var swfu,maxnum=5,webpath="/System.php?s=/System/SiteListAll/";</script>
    <script  src="/Public/jquery.js"></script>
    <script  src="/Public/jquery.form.js"></script>
	<script type="text/javascript" src="/Web/System/Public/js/swfupload.js"></script>
	<script type="text/javascript" src="/Web/System/Public/js/handlers.js"></script>
</head>
<body>
<!--顶部导航开始-->
<div class="topnav">
<a  href="/System.php?s=/System/ManagerPage/BaseInfo.html" class="home">首页</a>><a href="/System.php?s=/System/AdminAll">运营信息</a>><a href="javascript:void(0)">添加站点</a>
</div>
<!--顶部导航结束-->
<div class="cont_info">
<div class="tab_txt">
<div class="tab_tit">添加站点</div>
	<form method="post"  id="form1" action="<?php echo U('/System/SiteListAll/AddSave');?>"  enctype="multipart/form-data">
    <table width="100%" border="0" cellpadding="2" cellspacing="0" class="info_tab">
    
    <tr>
      <td align="right" style="width:28%">站点名称：</td>
      <td align="left"><input type="text" id="sitename" name="sitename" class="input1" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:240px"  /><span style=" margin-left:5px; color:#F00; display:none" id="sitename_tip">×站点名称不能为空</span>
        </td>
    </tr>
    
    <tr>
      <td align="right">站点简要地址：</td>
      <td  align="left"><input type="text" id="siteadd" name="siteadd" class="input1" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:424px"  /><span style=" margin-left:5px; color:#F00; display:none" id="siteadd_tip">×站点简要地址不能为空</span>
     
      </td>
    </tr>
     <tr>
      <td align="right">站点详细地址：</td>
      <td  align="left">
     <textarea class="input1" id="siteinfoadd" name="siteinfoadd" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:424px; height:36px" ></textarea><span style=" margin-left:5px; color:#F00; display:none" id="siteinfoadd_tip">×站点详细地址不能为空</span>
      </td>
    </tr>
    
     <tr>
      <td align="right">联系电话：</td>
      <td  align="left"><input type="text" id="sitetel" name="sitetel" class="input1" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:424px"  /><span style=" margin-left:5px; color:#F00; display:none" id="sitetel_tip">×联系电话不能为空</span>
      </td>
	</tr>
      
	<tr>
		<td align="right">站点图片：</td>
		<td  align="left" style="height:30px"><input type="file" id="siteimg" name="siteimg" style=" height:30px;float:left" /><div style=" margin-left:5px; color:#F00; height:30px; line-height:30px; float:left; display:none" id="siteimg_tip">×站点图片不能为空</div>
		</td>
    </tr>
    
	<tr>
		<td style="vertical-align:top"><div style="text-align:right; height:30px; line-height:30px">站点批量图：</div></td>
		<td  align="left">
        <div style="height:30px" class="pl_topdiv">
			<div style="float:left; height:25px; width:100px; margin-top:3px;"><span id="spanButtonPlaceholder"></span></div>
			<div id="divFileProgressContainer" class="pl_hit"></div>
            <div class="progressjd" id="progressjd"></div>
        </div>
		<div id="thumbnails">
        
				<ul id="pic_list" class="pic_list fixed"></ul>
       
		</div>
        <input type="hidden" name="pls" id="pls" value="|"/>
		</td>
    </tr>



     <tr>
		<td align="right">站点地形图：</td>
		<td  align="left" style="height:30px"><input type="file" id="sitemap" name="sitemap" style=" height:30px" />
		</td>
    </tr>
      
        
     <tr>
      <td align="right">高德地图经纬度：</td>
      <td  align="left"><input type="button" id="sitxy" name="sitxy"  style="width:80px; height:30px" value="选择"  /><span style=" margin-left:10px; color:#06F;" id="sitxy_tip">*未设置</span> 
      <span style="display:none"><input type="text" id="sitx" name="sitx" /><input type="text" id="sity" name="sity" /></span><span style=" margin-left:5px; color:#F00; display:none" id="sit_tip">×经纬度不能为空</span>
      </td>
    </tr>
    
     <tr>
      <td align="right">百度地图经纬度：</td>
      <td  align="left"><input type="button" id="bsitxy" name="bsitxy"  style="width:80px; height:30px" value="选择"  /><span style=" margin-left:10px; color:#06F;" id="bsitxy_tip">*未设置</span> 
      <span style="display:none"><input type="text" id="bsitx" name="bsitx" /><input type="text" id="bsity" name="bsity" /></span><span style=" margin-left:5px; color:#F00; display:none" id="bsit_tip">×经纬度不能为空</span>
      </td>
    </tr>
    
     <tr>
      <td align="right">腾讯地图经纬度：</td>
      <td  align="left"><input type="button" id="tsitxy" name="tsitxy"  style="width:80px; height:30px" value="选择"  /><span style=" margin-left:10px; color:#06F;" id="tsitxy_tip">*未设置</span> 
      <span style="display:none"><input type="text" id="tsitx" name="tsitx" /><input type="text" id="tsity" name="tsity" /></span><span style=" margin-left:5px; color:#F00; display:none" id="tsit_tip">×经纬度不能为空</span>
      </td>
    </tr>
    
    
    <tr>
      <td align="right">链接密码：</td>
      <td  align="left"><input type="text" id="linkpwd" name="linkpwd" class="input1" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:240px"  /><span style=" margin-left:5px; color:#06F" id="linkpwd_tip">*必须与前置主机密码相同</span> <span style=" margin-left:5px; color:#F00; display:none" id="innetip_tip">×链接密码不能为空</span>
      </td>
    </tr>
    
     <tr>
      <td align="right">单价：</td>
      <td  align="left"><input type="text" id="uint" name="uint" class="input1" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:140px"  /> 元<span style=" margin-left:5px; color:#F00; display:none" id="uint_tip">×单价不能为空</span>
      </td>
    </tr>
    
    
    <tr>
      <td align="right">备注信息：</td>
      <td  align="left"><textarea class="input1" id="mark" name="mark" onFocus="this.className='input1-bor'" onBlur="this.className='input1'"  style="width:424px; height:64px" ></textarea>
        </td>
    </tr>

    <tr>
      <td align="right">是否启用：</td>
      <td  align="left">
		<input type="radio" id="isenable" name="isenable" value="1" checked="checked" />是
      	<input type="radio" id="isenable1" name="isenable" value="0" style="margin-left:20px;" />否
      </td>
    </tr>
    <tr>
      <td align="right" height="50"></td>
      <td  align="left"><input type="button" class="btn" value="添加站点" id="addsave" style=" width:144px; height:30px" /> 
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
	$("#pls").val("|");
	$("#sitxy").click(function(){
		if($("#sitx").val()==""||$("#sity").val()==""){
			var sitxy={"x":38.32200483527823,"y":106.69221865624462,"z":4,"type":0}
		}else{
			var sitxy={"x":$("#sitx").val(),"y":$("#sity").val(),"z":19,"type":0}	
		}
		parent.M.showmap(sitxy);
	})
	
	$("#bsitxy").click(function(){
		if($("#bsitx").val()==""||$("#bsity").val()==""){
			var sitxy={"x":37.447122,"y":	105.514792,"z":5,"type":1}
		}else{
			var sitxy={"x":$("#bsitx").val(),"y":$("#bsity").val(),"z":19,"type":1}	
		}
		parent.M.showmap(sitxy);
	})
	
	$("#tsitxy").click(function(){
		if($("#tsitx").val()==""||$("#tsity").val()==""){
			var sitxy={"x":37.81037837267359,"y":101.38107635578348,"z":1,"type":2}
		}else{
			var sitxy={"x":$("#tsitx").val(),"y":$("#tsity").val(),"z":19,"type":2}	
		}
		parent.M.showmap(sitxy);
	})
	swfu = new SWFUpload({
				upload_url: "<?php echo U('/System/SiteListAll/Swfupload');?>",
				post_params: {"cid": "8"},
				file_size_limit : "2 MB",
				file_types : "*.jpg;*.png;*.gif;*.bmp",
				file_types_description : "JPG Images",
				file_upload_limit : maxnum,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				button_image_url : "/Web/System/Public/images/swfupload/upload.png",
				button_placeholder_id : "spanButtonPlaceholder",
				button_width: 100,
				button_height: 25,
				button_text : '',
				button_text_style : '.spanButtonPlaceholder { font-family: Helvetica, Arial, sans-serif; font-size: 14pt;} ',
				button_text_top_padding: 0,
				button_text_left_padding: 0,
				button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
				button_cursor: SWFUpload.CURSOR.HAND,			
				flash_url : "/Web/System/Public/images/swf/swfupload.swf",
				custom_settings : {
					upload_target : "divFileProgressContainer"
				},				
				debug: false
			});
})
	
	function setpoint(a,b){
		if(b==0){
			$("#sitxy_tip").text("经度："+a["D"]+"，纬度："+a["J"]);
			$("#sitx").val(a["J"]);
			$("#sity").val(a["D"]);
		}else if(b==1){
			$("#bsitxy_tip").text("经度："+a["D"]+"，纬度："+a["J"]);
			$("#bsitx").val(a["J"]);
			$("#bsity").val(a["D"]);
		}else if(b==2){
			$("#tsitxy_tip").text("经度："+a["D"]+"，纬度："+a["J"]);
			$("#tsitx").val(a["J"]);
			$("#tsity").val(a["D"]);	
		}
	}
	
$("#addsave").click(function(){
		$("#sitename_tip,#siteadd_tip,#sit_tip,#linkpwd_tip,#uint_tip,#siteinfoadd_tip,#sitetel_tip,#process,#siteimg_tip").hide();
		if($("#sitename").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
			$("#sitename_tip").show();
			return false;	
		}
		if($("#siteadd").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
			$("#siteadd_tip").show();
			return false;	
		}
		
		if($("#siteinfoadd").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
			$("#siteinfoadd_tip").show();
			return false;	
		}
		
		if($("#sitetel").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
			$("#sitetel_tip").show();
			return false;	
		}
		
		if($("#siteimg").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
			$("#siteimg_tip").show();
			return false;	
		}
		
		
		if($("#sitx").val().replace(/(^\s*)|(\s*$)/g, "").length==0||$("#sity").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
			$("#sit_tip").show();
			return false;	
		}
		
		if($("#linkpwd").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
			$("#linkpwd_tip").show();
			return false;	
		}	
		
		$("#form1").ajaxSubmit({
			dataType:  'json',
			success: function(data) {
				if(data["status"]["err"]==0){
					window.location.href="<?php echo U('/System/SiteListAll');?>";
				}else if(d["status"]["err"]==1){
					alert(d["status"]["msg"]);
					window.parent.location.href="<?php echo U('/System/Index');?>"
				}else{
					alert(["status"]["msg"])	
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