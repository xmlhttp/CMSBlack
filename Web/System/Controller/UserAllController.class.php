<?php
namespace System\Controller;
use Think\Controller;
class UserAllController extends Controller {

    public function index(){
		loadcheck(37); 
		$this->assign('menu',showmenu(0,1));
		$this->assign('adminclass',session("adminclass"));
   		$this->display('Index:userall');

    }
	
	//查询
	public function paged(){
		$json = array();
		if(!ajaxcheck(37)){
			$json['status']['err']=1;
			$json['status']['msg']="您已经退出或权限不够！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}
		$page=I("post.page",0);
		$size=I("post.size",5);
		$count=M('sys_userinfo')->count();
		$T=M('sys_userinfo')->order('id desc')->limit($page*$size,$size)->select();
		$json['pagecount']=ceil($count/$size);
		$json['pagecurrent']=$page;		
		$json['data']['rows']=showitem($T);
		$json['status']['err']=0;
		$json['status']['msg']="请求成功！";
		ob_clean();
		$this->ajaxReturn($json, 'json');
	}
	
	
	
	//搜索
	public function search(){
		$json = array();

		if(!ajaxcheck(37)){
			$json['status']['err']=1;
			$json['status']['msg']="您已经退出或权限不够！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}
		$page=I("post.page",0);
		$size=I("post.size",5);
		$count=M('sys_userinfo')->where("truename like '%".I("post.searchtxt",'')."%' or uname like '%".I("post.searchtxt",'')."%'")->count();
		$T=M('sys_userinfo')->where("truename like '%".I("post.searchtxt",'')."%' or uname like '%".I("post.searchtxt",'')."%'")->order('id desc')->limit($page*$size,$size)->select();
		$json['pagecount']=ceil($count/$size);
		$json['pagecurrent']=$page;
		$json['data']['rows']=showitem($T);
		$json['status']['err']=0;
		$json['status']['msg']="请求成功！";
		ob_clean();
		$this->ajaxReturn($json, 'json');
	}
	
	//用户-显示
	 public function AddRead(){
		loadcheck(38);
		$option=showmenu1(0,1);
		$this->assign('option',$option);
    	$this->display('Index:userAdd');
    }

	//用户-添加
	public function AddSave(){
		$json = array();
		if(!ajaxcheck(38)){
			$json['status']['err']=1;
			$json['status']['msg']="您已经退出或权限不够！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}
		if(I('post.uname', '') == ""||I('post.upwd', '')==''){
			$json['status']['err']=2;
			$json['status']['msg']="用户名和密码不能为空！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		if(strlen(I('post.upwd', ''))<6||strlen(I('post.upwd', ''))>12){
			$json['status']['err']=2;
			$json['status']['msg']="密码长度在6-12位之间！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		$data['upwd']=md5(I('post.upwd', ''));
		$data['sessionid']=md5(time(). mt_rand(0,1000));
		$data["uname"]=I('post.uname', '');
		$data["truename"]=I('post.nickname', '');
		$data["ucheck"]=I('post.ucheck',0);
		$data["treeid"]=showtree(I('post.list1', '')).'-';
		$data["addtime"]=date('Y-m-d H:i:s');
		$data["lastaddtime"]=date('Y-m-d H:i:s');
		
		if($lastInsId =M('sys_userinfo')->add($data)){
			login_info("【用户】 信息ID为[".$lastInsId."]的项添加成功", "UserInfo");
			$json['status']['err']=0;
			$json['status']['msg']="添加用户成功！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;	
		}else{
			$json['status']['err']=2;
			$json['status']['msg']="写入数据库失败！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;	
		}
	}

	
	//编辑
	public function edit(){
		$json = array();
		if(!ajaxcheck(37)){
			$json['status']['err']=1;
			$json['status']['msg']="您已经退出或权限不够！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}
		$v=I("post.nValue","");
		switch (I("post.cInd",0)){
			case 0:
				break;
			case 1:
				$field="treeid";
				break;
			case 3:
				$field="truename";
				break;
			case 4:
				break;
			case 6:
				$field="ucheck";
				$v=$v=="true"?1:0;
				break;
		}
		$T=M('sys_userinfo');
		if($T){
			$data[$field] = $v;
			$T->where('id='.I("post.rId",0))->save($data);  	
			login_info("【会员】 信息ID为[".I("post.rId",0). "] 更新[".$field."]成功", "UserInfo");
			$json['status']['err']=0;
			$json['status']['msg']="<span class='msgright'>ID为<font style='padding-left:2px; padding-right:2px; font-size:13px'>".I("post.rId",0)."</font>的第<font  style='padding-left:2px; padding-right:2px; font-size:13px'>".(I("post.cInd",0)+1)."</font>列的数据已经更新为:".I("post.nValue","")."</span>";	
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}else{
			$json['status']['err']=2;
			$json['status']['msg']="数据连接错误！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;		
		}
		
	}
		
	//修改管理员信息-读取
	public function EditRead(){
		if(session("adminclass")==0){
			header("Content-Type:text/html;charset=utf-8");
			echo '您的权限不够.';	
			exit();
		}
		loadcheck(37);		
		$info=M('sys_userinfo')->where('id='.I("get.id"),0)->find();
		if(!$info){
			header("Content-Type:text/html;charset=utf-8");
			echo "信息不存在!";
			exit;	
		}
		$arr = explode("-",$info["treeid"]);
		$pid=$arr[count($arr)-2];
		$pcontent=M('deeptree')->where('id='.$pid.' and ver='.session("ver"))->find();
		if(!$pcontent){
			header("Content-Type:text/html;charset=utf-8");
			echo "信息不存在!";
			exit;	
		}
		$option="<option value='0'>※".$pcontent["content"]."</option>".showmenu1(0,1);
		$this->assign('option',$option);
		$this->assign('userinfo',$info);	
		$this->display('Index:userUpdata');
	}
	
	//修改管理员信息-修改
	public function EditSave(){
		$json = array();
		if(session("adminclass")==0){
			$json['status']['err']=1;
			$json['status']['msg']="您已经退出或权限不够！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}
		if(!ajaxcheck(37)){
			$json['status']['err']=1;
			$json['status']['msg']="您已经退出或权限不够！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}
		if(I('get.id',0)==0){
			$json['status']['err']=2;
			$json['status']['msg']="修改数据失败！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		
		$data['truename']=I('post.nickname', '');
		if(I('post.upwd', '')!=''){
			if(strlen(I('post.upwd', ''))<6||strlen(I('post.upwd', ''))>12){
				$json['status']['err']=2;
				$json['status']['msg']="密码长度在6-12位之间！";
				ob_clean();
				$this->ajaxReturn($json, 'json');
				exit;	
			}
			$data['upwd']=md5(I('post.upwd', ''));
			$data['sessionid']=md5(time(). mt_rand(0,1000));
		}
		$data['ucheck']=I('post.ucheck', '0');
		if(I('post.list1', 0)!=0){
			$data["treeid"]=showtree(I('post.list1', '')).'-';	
		}
		
		$result=M('sys_userinfo')->where('id='.I('get.id',0))->save($data);
		if($result||$result===0){
			login_info("【用户】 信息ID为[".I('get.id',0)."]的项修改成功", "UserInfo");
			$json['status']['err']=0;
			$json['status']['msg']="修改成功！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}else{
			$json['status']['err']=2;
			$json['status']['msg']="修改数据失败！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;	
		}		
	}
	
	//修改金额
	public function EditMoney(){
		$json = array();
		if(session("adminclass")==0){
			$json['status']['err']=1;
			$json['status']['msg']="您已经退出或权限不够！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}
		if(!ajaxcheck(37)){
			$json['status']['err']=1;
			$json['status']['msg']="您已经退出或权限不够！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}
		if(I('post.uid',0)==0){
			$json['status']['err']=2;
			$json['status']['msg']="修改数据失败！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		$T=M('sys_userinfo')->where('id='.I('post.uid',0))->select();
		if(count($T)!=1){
			$json['status']['err']=2;
			$json['status']['msg']="修改数据失败！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		if(I('post.ctype',0)==0){
			$data['umoney']=$T[0]['umoney']+I('post.moneyid',0);
		}else{
			$data['umoney']=$T[0]['umoney']-I('post.moneyid',0);	
		}
		if(M('sys_userinfo')->where('id='.I('post.uid',0))->save($data)){
			$da['uname']=$T[0]["uname"];
			$da['type']=I('post.ctype',0);
			$da['Adesc']=I('post.Newdesc',0);
			$da['cnum']=I('post.moneyid',0);
			$da['enum']=$data['umoney'];
			$da['addtime']=date('Y-m-d H:i:s');
			$da['No']="VM-".date('ymdHis').GetRandStr(4);
			if($lastInsId =M('usou')->add($da)){
				$json['status']['err']=0;
				$json['status']['msg']="修改成功！";
				ob_clean();
				$this->ajaxReturn($json, 'json');
			}else{
				$json['status']['err']=2;
				$json['status']['msg']="修改数据失败！";
				ob_clean();
				$this->ajaxReturn($json, 'json');
				exit;
			}
			
		}else{
			$json['status']['err']=2;
			$json['status']['msg']="修改数据失败！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;	
		}	
		
		
	}
	
	
}

//输出列表
function showitem($T){
	$data=array();
	foreach($T as $t=>$v){
		$data[$t]["id"]=$v['id'];
		$data[$t]["data"][]=$v['id'];
		$data[$t]["data"][]=$v['treeid'];
		$data[$t]["data"][]=$v['uname'];
		$data[$t]["data"][]=$v['truename'];
		$data[$t]["data"][]=$v['addtime'];
		$data[$t]["data"][]=$v['lastaddtime'];
		$data[$t]["data"][]=$v['ucheck'];
		$data[$t]["data"][]="编辑^/System.php?s=/System/UserAll/EditRead&id=".$v['id']."^_self";
	}

	return $data;
}

function GetRandStr($len){ 
	$chars = array( 
        "A", "B", "C", "D", "E", "F", "G",  
        "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",  
        "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",  
        "3", "4", "5", "6", "7", "8", "9" 
    ); 
    $charsLen = count($chars) - 1; 
    shuffle($chars);   
    $output = ""; 
    for ($i=0; $i<$len; $i++){ 
        $output .= $chars[mt_rand(0, $charsLen)]; 
    }  
    return $output;  
} 

//输出目录结构
function showmenu($rid,$temp){
	$ret=M('deeptree')->where('parentid='.$rid.' and class="User" and ver='.session("ver"))->order('orderid asc')->select();
	if(count($ret)){
		foreach($ret as $k=>$v){
			$menu[$k]["val"]=$v["id"];
			$menu[$k]["text"]=$v["content"];
		}
	}
	return json_encode($menu);
}

//输出目录结构
function showmenu1($rid,$temp){
	$ret=M('deeptree')->where('parentid='.$rid.' and class="User" and ver='.session("ver"))->order('orderid asc')->select();
	if(count($ret)){
		foreach($ret as $k=>$v){
			$str="";
			for($i=0;$i<$temp;$i++){
				$str.="&nbsp;&nbsp;&nbsp;";	
			}
			$menu.="<option value=".$v["id"].">".$str."|-&nbsp;".$v["content"]."</option>".showmenu($v["id"],$temp+1);
		}
	}
	return $menu;
}
//获取目录树
function showtree($rid){
	$ret=M('deeptree')->where('id='.$rid.' and class="User" and ver='.session("ver"))->find();
	if($ret["parentid"]==0){
		return "-".$ret["id"];	
	}else{
		return showtree($ret["parentid"])."-".$ret["id"];
	}
}