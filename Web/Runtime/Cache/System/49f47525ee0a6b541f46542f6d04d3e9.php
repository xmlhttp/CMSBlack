<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>管理员管理</title>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
    <link href="/Web/System/Public/css/main.css" type="text/css" rel="stylesheet">
	<link rel="STYLESHEET" type="text/css" href="/Web/System/Public/Tool/codebase/dhtmlxgrid.css">
	<script  src="/Public/jquery.js"></script>
	<script  src="/Web/System/Public/Tool/codebase/dhtmlxgrid.js"></script>
	<script type="text/javascript" src="/Web/System/Public/Tool/page/jquery.pagination.js"></script>
	<script  src="/Web/System/Public/js/System.js"></script>
<style>
     body{ overflow-y:hidden}
</style>
</head>
<body>
<!--顶部导航开始-->
<div class="topnav">
<a  href="/System.php?s=/System/ManagerPage/BaseInfo.html" class="home">首页</a>><a href="/System.php?s=/System/ManagerPage/UserAg">商务信息</a>><a href="/System.php?s=/System/PSou">充值记录</a>
</div>
<!--顶部导航结束-->
<div class="cont_info">

<div class="tab_txt">
<div class="tab_tit">充值记录</div>

<div class="meun_tab">

  <table  width="95%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="30" align="center"><img src="/Web/System/Public/images/icon_search.gif" width="26" height="22"></td>
       <?php if($adminclass != 0): ?><td align="right" width="42">类别：</td>
      <td width="145" align="left"><select name="select" id="menu"  style="width:140px; height:26px; line-height:26px" onchange="searchitem()">
      <option value="0" selected="selected">全部</option>
      <option value="1" selected="selected">充电</option>
      <option value="2" selected="selected">充值</option>
      </select></td><?php endif; ?>      
      <td width="60" align="right">关键字：</td>
      <td style="width:170px; text-align:center">
        <input name="Input" class="input1" id="keywords" onFocus="this.className='input1-bor'" onBlur="this.className='input1'" style="width:150px; height:18px; line-height:18px"/></td>
        <td align="left">
        <input name="button" type="button" class="btn" style="width:55px"  value="查询" id="search" onclick="searchitem()" /></td>
      <td  align="right">
        </td>
    </tr>
  </table>
</div>
<div class="db_div" >
<div id="gridbox" width="100%"></div>
</div>
<div id="setpage" class="paged" >
</div>
</div>
<DIV id="DIV1" class="info_foot">
  Action Info: <span id=act_info style="display:inline"></span>
</DIV>
</div>
<script>
	$("#keywords").val("");
var	myGridmode='/System.php?s=/System/PSou/', //模块地址
	myGrid = new dhtmlXGridObject('gridbox');
	myGrid.setImagePath("/Web/System/Public/Tool/codebase/imgs/dhxgrid_material/");

var	myGridnum=5; //选中框所在的下标
	myGrid.setHeader("ID,账号,描述,时间,变化金额,最终金额");
	myGrid.setInitWidths("80,160,*,160,100,100");
	myGrid.setColAlign("center,left,left,center,center,center");
	myGrid.setColTypes("ro,ro,ro,ro,ro,ro");
	myGrid.setColSorting("int,str,str,str,str,str");
	myGrid.init();
	
</script>
</body>
</html>