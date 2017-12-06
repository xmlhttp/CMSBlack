<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
    <title>Present by Richcomm.com.cn 管理中心 - 编辑车位</title>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
    <link href="/Web/System/Public/css/main.css" type="text/css" rel="stylesheet"> 
    <script  src="/Public/jquery.js"></script>
    <script  src="/Web/System/Public/js/jquery.rotate.min.js"></script>
    <script  src="/Web/System/Public/js/jquery.easydrag.handler.beta2.js"></script>
    <style>
    	.imginfo{ margin-top:0; margin-left:0; overflow:hidden}
    </style>
</head>
<body>

<!--内容设置-->
<div class="imginfo" id="imginfo" style="width:<?php echo ($attr[0]); ?>px; height:<?php echo ($attr[1]); ?>px; background:url(<?php echo ($url); ?>) top left no-repeat; position:relative"><img src="/Web/System/Public/images/che.png" id="moveche" style=" position:absolute; left:<?php echo ($x); ?>px;top:<?php echo ($y); ?>px; opacity:0.8" /></div>
<!--内容设置-->

<script>
$(function(){
	rot(<?php echo ($r); ?>);
	$('#moveche').easydrag()
	if($("#imginfo").height()>470){
		if($("#moveche").offset().top>235){
				$("html,body").scrollTop(parseInt($("#moveche").css('top').replace("px",""))-235+$("#moveche").height()/2)
		}	
	}
	if($("#imginfo").width()>700){
		if($("#moveche").offset().left>350){
				$("html,body").scrollLeft(parseInt($("#moveche").css('left').replace("px",""))-350+$("#moveche").width()/2)
		}	
	}
	
})
function rot(a){
	$('#moveche').rotate(parseInt(a));	
}

function getdata(){
	parent.M.Landdata( parseInt($("#moveche").css('left').replace("px","")),parseInt($("#moveche").css('top').replace("px","")),$("#moveche").getRotateAngle())	
}

</script>

</body>
</html>