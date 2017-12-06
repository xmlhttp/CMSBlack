<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>充电桩管理</title>
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
<a  href="/System.php?s=/System/ManagerPage/BaseInfo.html" class="home">首页</a>><a href="/System.php?s=/System/AdminAll">运营信息</a>><a href="javascript:void(0)">桩管理</a>
</div>
<!--顶部导航结束-->
<div class="cont_info">

<div class="tab_txt">
<div class="tab_tit"><a class="export" href="javascript:alert('该功能暂未开放')">导出Excel</a>桩管理



</div>

<div class="meun_tab">

  <table  width="95%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="30" align="center"><img src="/Web/System/Public/images/icon_search.gif" width="26" height="22"></td>

       <td align="right" width="42">站点：</td>
      <td width="145" align="left"><select name="select" id="menu" onchange="if(this.value1=-1){searchitem()}"  style="width:140px; height:28px; line-height:28px">
      <option value="0">全部</option>
      <?php echo ($option); ?>
      </select>
      </td><td width="60" align="right">关键字：</td>
      <td style="width:170px; text-align:center">
        <input name="Input" class="input1" id="keywords" onFocus="this.className='input1-bor'" onBlur="this.className='input1'" style="width:150px; height:18px; line-height:18px"/></td>
        <td align="left">
        <input name="button" type=button class="btn" style="width:55px" onClick="searchitem()" value="查询" /></td>
      <td  align="right">
     <input name="button" type=button class="btn" onClick="delete_items()" value="删除选中" />&nbsp;<input name="button" type=button class="btn" onClick="window.location.href='/System.php?s=/System/PileListAll/AddRead'" value="添加桩" /> </td>
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
$("#menu>option:first").prop("selected",true);
var myGridnum=9, //选中框所在的下标
	myGridmode='/System.php?s=/System/PileListAll/', //模块地址
	myGrid = new dhtmlXGridObject('gridbox');
	myGrid.setImagePath("/Web/System/Public/Tool/codebase/imgs/dhxgrid_material/");
	myGrid.setHeader("ID,编号,充电,加入时间,启用,联线,车位,编辑,二维码,<a href='javascript:void(0)' onclick='chk_all()'>全选 </a>");
	myGrid.setInitWidths("80,*,80,130,70,70,70,60,60,50");
	myGrid.setColAlign("center,left,center,center,center,center,center,center,center,center");
	myGrid.setColTypes("ro,ro,img,ro,ch,img,img,link,link,ch");
	myGrid.setColSorting("int,str,str,str,str,str,str,str,str,str");
	myGrid.attachEvent("onCheckbox",doOnCheckEdit);
	myGrid.init();
</script>
</body>
</html>