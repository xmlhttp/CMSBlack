<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
      <title>VMUUI.COM 劲驰网络管理中心</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	  <link href="/Web/System/Public/images/XM_favicon.ico" rel="shortcut icon" type="image/x-icon" />
      <link href="/Web/System/Public/css/index.css" rel="stylesheet" type="text/css" />
	  <script  src="/Public/jquery.js"></script>
      <script  src="/Web/System/Public/js/Index.js"></script>
  </head>
  <body scroll="no">
      <div class="log_head"><a class="product" href="http://www.vmuui.com/index.php?s=/Home/Index/Web.html" target="_blank">产品简介</a><a class="product" href="http://www.vmuui.com/index.php?s=/Home/Index/About.html#contact" target="_blank">联系我们</a><a class="product" href="http://www.vmuui.com" target="_blank">官方网站</a><a href="http://www.vmuui.com" target="_blank"><img src="/Web/System/Public/images/ManagerPage/logo.png" style="width:250px; margin-top:-6px" /></a></div>
	  
	  <div class="logmid" id="logmid">
      <div class="login_div">
		<div class="logintit">用户登录</div>
		<div class="logindesc">请输入管理员分配给您的账号密码</div>
        <table class="tab_login">
          <tbody>
          <tr>
            <td colspan="2">
                <input id="user_name" class="input1"  type="text"  placeholder="登录账号"/>
            </td></tr>
          <tr>
            <td colspan="2">
             <input id="user_pwd" class="input1" type="password" placeholder="登录密码"/>
             </td></tr>
          <tr >
            <td style="width:238px;">
                <input id="vcode" class="input1" type="text"  style="width:210px" maxlength="4" placeholder="验证码"/>
             </td>
            <td><img src="<?php echo U('/System/Index/verify');?>" style="width:100px; height:36px; border:#ccc solid 1px" id="codeimg" title="点击刷新" /></td>
          </tr>
          <tr>
			<td align=right colSpan=2 style="height:25px">
            <div class="msg" id="msg"></div>
            </td></tr>
            <td colspan="2" style="text-align:center">
            	 <a class="btnlog" id="Button1" >登 录</a> 
             </td></tr>
          <tr>
            </tbody></table>
          </div>
		  
		  </div>
      <div class="footer2">版权所有<span>&copy;</span>广州市劲驰互联网科技有限公司</div>
  </body>
</html>