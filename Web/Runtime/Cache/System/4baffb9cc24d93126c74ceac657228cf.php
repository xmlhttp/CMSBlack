<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Present by vmuui.com 管理中心 - 客服列表</title>
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
<a  href="/System.php?s=/System/ManagerPage/BaseInfo.html" class="home">首页</a>><a href="/System.php?s=/System/Ser">客服管理</a>><a href="javascript:void(0)">客服列表</a>
</div>
<!--顶部导航结束-->
<div class="cont_info">

<div class="tab_txt">
<div class="tab_tit"><a class="export" href="javascript:alert('功能未开放！')" style="display:none">导出Excel</a>客服列表</div>

<div class="meun_tab">

  <table  width="95%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="35" align="center"><img src="/Web/System/Public/images/newem.gif" width="26" height="22"></td>
      <td width="45" align="right">类别：</td>
      <td width="105" align="left"><select name="select" id="menu" style="width:100px; height:28px; line-height:28px; color:#4b4b4b"><?php echo ($menu); ?></select></td>
	  <td width="45" align="right">名称：</td>
      <td style="width:120px; text-align:center">
        <input name="newtitle" class="input1" id="newtitle" onFocus="this.className='input1-bor'" onBlur="this.className='input1'" style="width:100px; height:18px; line-height:18px"/></td>
        <td width="45" align="right">账号：</td>
      <td style="width:120px; text-align:center">
        <input name="newcode" class="input1" id="newcode" onFocus="this.className='input1-bor'" onBlur="this.className='input1'" style="width:100px; height:18px; line-height:18px"/></td>
        <td align="left">
        <input name="button" type="button" class="btn" style="width:55px"  value="添加" id="search" onclick="addseritem()" /></td>
      <td  align="right">
      <input name="button" type=button class="btn" onClick="item_up()" value="上移"  style="width:55px"/>&nbsp;<input name="button" type=button class="btn" onClick="item_down()" value="下移"  style="width:55px"/>&nbsp;<input name="button" type=button class="btn" onClick="delete_items()" value="删除选中" /> </td>
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
	$("#menu>option:eq(0)").attr("selected","selected")
	$("#newtitle,#newcode").val("")
var	myGridnum=6, //选中框所在的下标
	myGridmode='/System.php?s=/System/Ser/', //模块地址
	myGrid = new dhtmlXGridObject('gridbox'); //新建列表
	myGrid.setImagePath("/Web/System/Public/Tool/codebase/imgs/dhxgrid_material/");
	myGrid.setHeader("ID,所属组别,客服名称,号码,加入时间,启用,<a href='javascript:void(0)' onclick='chk_all()'>全选 </a>");
	myGrid.setInitWidths("80,160,*,200,160,80,80,80");
	myGrid.setColAlign("center,left,left,left,center,center,center");
	myGrid.setColTypes("ro,co,ed,ed,ro,ch,ch");
	myGrid.setColSorting("int,str,str,str,str,str,str");
	for(var i=0;i<$("#menu>option").length;i++){
		myGrid.getCombo(1).put("-"+$("#menu>option:eq("+i+")").val()+"-",$("#menu>option:eq("+i+")").text());	
	}
	
	
	
	myGrid.attachEvent("onEditCell",doOnCellEdit);
	myGrid.attachEvent("onCheckbox",doOnCheckEdit);
	myGrid.init();

function addseritem(){
	if($("#newtitle").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
		alert("客服名称不能为空！");
		return false;	
	}
	if($("#newcode").val().replace(/(^\s*)|(\s*$)/g, "").length==0){
		alert("客服账号不能为空！");
		return false;	
	}
	var postdata={"list1":$("#menu").val(),"newtitle":$("#newtitle").val(),"newcode":$("#newcode").val()}
	$("#act_info").html("<span class='msgload'>正在请求中…</span>")
	$.ajax({
		url: "<?php echo U('/System/Ser/AddSave');?>",
		type: 'POST',
		dataType: 'json',
		data:postdata
	}).done(function(d) {
		if(d["status"]["err"]==0){
			cpage=d["pagecurrent"];
			countpage=d["pagecount"];
			$("#act_info").html("<span class='msgload'>解析数据……</span>")
			//分页
			$("#setpage").pagination(d["pagecount"],{
				num_edge_entries: 2,
    			num_display_entries: 9,
    			current_page: d["pagecurrent"],
				callback: pageselectCallback
			});
			//绑定数据
			myGrid.clearAll();
			myGrid.parse(d["data"],"json");		
			setTimeout(function(){$("#act_info").html("<span class='msgright'>添加成功！</span>")},200);
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
}	
</script>
</body>
</html>