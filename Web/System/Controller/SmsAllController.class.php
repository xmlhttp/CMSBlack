<?php
namespace System\Controller;
use Think\Controller;
class SmsAllController extends Controller {

    public function index(){
		loadcheck(54); 
   		$this->display('Index:Smsall');
    }
	
	//查询
	public function paged(){
		$json = array();
		if(!ajaxcheck(54)){
			$json['status']['err']=1;
			$json['status']['msg']="您已经退出或权限不够！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}
		$page=I("post.page",0);
		$size=I("post.size",5);
		//if(session("adminclass")==1||session("adminclass")==99){
		$count=M('sms')->where("isdelete=0")->count();
		$T=M('sms')->where("isdelete=0")->order('orderid desc')->limit($page*$size,$size)->select();
		/*}else{
			$count=M('sms')->where("isdelete=0 and userid=".session("uid"))->count();
			$T=M('sms')->where("isdelete=0 and userid=".session("uid"))->order('orderid desc')->limit($page*$size,$size)->select();
		}*/
		
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

		if(!ajaxcheck(54)){
			$json['status']['err']=1;
			$json['status']['msg']="您已经退出或权限不够！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}
		$page=I("post.page",0);
		$size=I("post.size",5);
		$count=M('sms')->where("Newtitle like '%".I("post.searchtxt",'')."%' or Newdesc like '%".I("post.searchtxt",'')."%'")->count();
		$T=M('sms')->where("Newtitle like '%".I("post.searchtxt",'')."%' or Newdesc like '%".I("post.searchtxt",'')."%'")->order('orderid desc')->limit($page*$size,$size)->select();
		$json['pagecount']=ceil($count/$size);
		$json['pagecurrent']=$page;
		$json['data']['rows']=showitem($T);
		$json['status']['err']=0;
		$json['status']['msg']="请求成功！";
		ob_clean();
		$this->ajaxReturn($json, 'json');
	}
	
	//标题和简介都保存在客户端 
	public function edit(){
		$json = array();
		if(session("adminclass")==0){
			$json['status']['err']=1;
			$json['status']['msg']="您已经退出或权限不够！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}
		if(!ajaxcheck(54)){
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
				break;
			case 2:
				$field="putout";
				$v=$v=="true"?1:0;
				break;
		}
		$T=M('sms');
		if($T){
			$data[$field] = $v;
			$T->where('id='.I("post.rId",0))->save($data);  	
			login_info("【消息推送】 信息ID为[".I("post.rId",0). "] 更新[".$field."]成功", "sys_admin");
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
	
	//删除
	public function del(){
		$json = array();
		if(!ajaxcheck(54)){
			$json['status']['err']=1;
			$json['status']['msg']="您已经退出或权限不够！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}
		$data["isdelete"]=1;
		if(M('sms')->where('id in('.I("post.ids","-1").')')->save($data)){ //删除成功后刷新数据
			$page=I("post.page",0);
			$size=I("post.size",5);
			
			$count=M('sms')->where("isdelete=0")->count();
			$T=M('sms')->where("isdelete=0")-> order('orderid desc')->limit($page*$size,$size)->select();	
			if($T){ //数据表有数据时
				$json['pagecount']=ceil($count/$size);
				$json['pagecurrent']=$page;
				$json['data']['rows']=showitem($T);;
				$json['status']['err']=0;
				$json['status']['msg']="请求成功";
				ob_clean();
				$this->ajaxReturn($json, 'json');
				exit;
			}else{ //查询结果为空自动返回上一页
				if($page==0){
					$json['pagecount']=0;
					$json['pagecurrent']=0;
					$json['data']['rows']=array();
					$json['status']['err']=0;
					$json['status']['msg']="请求成功，数据已被清空";
					ob_clean();
					$this->ajaxReturn($json, 'json');
					exit;	
				}else{
					$page=I("post.page",0)-1;	
					$count=M('sms')->where("isdelete=0")->count();
					$T=M('sms')->where("isdelete=0")-> order('orderid desc')->limit($page*$size,$size)->select();
					$json['pagecount']=ceil($count/$size);
					$json['pagecurrent']=$page;
					$json['data']['rows']=showitem($T);;
					$json['status']['err']=0;
					$json['status']['msg']="请求成功，当前页面没有数据系统自动向上翻页";
					ob_clean();
					$this->ajaxReturn($json, 'json');
					exit;
				}
			}	
		}else{
			$json['status']['err']=2;
			$json['status']['msg']="命令执行错误！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;	
		}
	}
	
	
	//带查询的删除
	public function delsearch(){
		$json = array();
		if(!ajaxcheck(54)){
			$json['status']['err']=1;
			$json['status']['msg']="您已经退出或权限不够！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}		
		$data["isdelete"]=1;
		if(M('sms')->where('id in('.I("post.ids","-1").')')->save($data)){ //删除成功后刷新数据
			$page=I("post.page",0);
			$size=I("post.size",5);
			$count=M('sms')->where("isdelete=0 and(Newtitle like '%".I("post.searchtxt",'')."%' or Newdesc like '%".I("post.searchtxt",'')."%')")->count();
			$T=M('sms')->where("isdelete=0 and(Newtitle like '%".I("post.searchtxt",'')."%' or Newdesc like '%".I("post.searchtxt",'')."%')")-> order('orderid desc')->limit($page*$size,$size)->select();	
			
			
			if($T){ //数据表有数据时
				$json['pagecount']=ceil($count/$size);
				$json['pagecurrent']=$page;
				$json['data']['rows']=showitem($T);;
				$json['status']['err']=0;
				$json['status']['msg']="请求成功";
				ob_clean();
				$this->ajaxReturn($json, 'json');
				exit;
			}else{ //查询结果为空自动返回上一页
				if($page==0){
					$json['pagecount']=0;
					$json['pagecurrent']=0;
					$json['data']['rows']=array();
					$json['status']['err']=0;
					$json['status']['msg']="请求成功，数据已被清空";
					ob_clean();
					$this->ajaxReturn($json, 'json');
					exit;	
				}else{
					$page=I("post.page",0)-1;
					$count=M('sms')->where("isdelete=0 and(Newtitle like '%".I("post.searchtxt",'')."%' or Newdesc like '%".I("post.searchtxt",'')."%')")->count();
					$T=M('sms')->where("isdelete=0 and(Newtitle like '%".I("post.searchtxt",'')."%' or Newdesc like '%".I("post.searchtxt",'')."%')")-> order('orderid desc')->limit($page*$size,$size)->select();	
					
					$json['pagecount']=ceil($count/$size);
					$json['pagecurrent']=$page;
					$json['data']['rows']=showitem($T);
					$json['status']['err']=0;
					$json['status']['msg']="请求成功，当前页面没有数据系统自动向上翻页";
					ob_clean();
					$this->ajaxReturn($json, 'json');
					exit;
				}
			}	
		}else{
			$json['status']['err']=2;
			$json['status']['msg']="命令执行错误！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;	
		}
	}
	
	//添加-显示
	 public function AddRead(){
		if(session("adminclass")==0){
			header("Content-Type:text/html;charset=utf-8");
			echo '您的权限不够.';	
			exit();
		}
		loadcheck(54); 	
    	$this->display('Index:SmsAdd');
    }
	
	//添加-保存
	public function AddSave(){
		$json = array();
		if(!ajaxcheck(54)){
			//filedel($_SERVER["DOCUMENT_ROOT"]."/Web/UploadFile/Site/".I('post.siteimg', ''));
			$json['status']['err']=1;
			$json['status']['msg']="您已经退出或权限不够！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}
		if(I('post.Newtitle', '')=="" || I('post.Newdesc', '')==""|| I('post.Newcontent', '')==""){
			$json['status']['err']=2;
			$json['status']['msg']="信息提交有误！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}
		
		$data['Newtitle']=I('post.Newtitle', '');
		$data['Newdesc']=I('post.Newdesc', '');
		$data['Newcontent']=$_POST["Newcontent"];
		$data['putout']=I('post.putout',0);
		$data['targets']=I('post.targets',0);
		$data['addtime']=date('Y-m-d H:i:s');
		
		if($lastInsId =M('sms')->add($data)){
			$data['orderid']=$lastInsId;
			if(M('sms')->where('id='.$lastInsId)->save($data)){
				login_info("【消息】 信息ID为[".$lastInsId."]的项添加成功", "SMS");
				$json['status']['err']=0;
				$json['status']['msg']="添加成功！";
				ob_clean();
				$this->ajaxReturn($json, 'json');
				exit;	
			}else{
				$json['status']['err']=2;
				$json['status']['msg']="写入数1据库失败！";
				ob_clean();
				$this->ajaxReturn($json, 'json');
				exit;	
			}					
		}else{
			$json['status']['err']=2;
			$json['status']['msg']="写入数据库1失败！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}
	}
	
	
	
	//修改消息信息-读取
	public function EditRead(){
		if(session("adminclass")==0){
			header("Content-Type:text/html;charset=utf-8");
			echo '您的权限不够.';	
			exit();
		}
		loadcheck(54);
		$sms=M('sms')->where('id='.I("get.id"),0)->find();
		$this->assign('sms',$sms);	
		$this->display('Index:SmsUpdata');
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
		if(!ajaxcheck(54)){
			$json['status']['err']=1;
			$json['status']['msg']="您已经退出或权限不够！";
			ob_clean();
			$this->ajaxReturn($json, 'json');
			exit;
		}
		$data['Newcontent']=$_POST["Newcontent"];
		$data['putout']=I('post.putout',0);
		$result=M('sms')->where('id='.I('get.id',0))->save($data);
		if($result||$result===0){
			login_info("【消息】 信息ID为[".I('get.id',0)."]的项修改成功", "SMS");
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
	
}

//输出列表
function showitem($T){
	$data=array();
	foreach($T as $t=>$v){
		$data[$t]["id"]=$v['id'];
		$data[$t]["data"][]=$v['id'];
		$data[$t]["data"][]=$v['Newtitle'];
		if($v['targets']==0){
			$data[$t]["data"][]="全部";	
		}else if($v['targets']==1){
			$data[$t]["data"][]="安卓";	
		}else if($v['targets']==2){
			$data[$t]["data"][]="苹果";	
		}
		$data[$t]["data"][]=$v['putout'];
		$data[$t]["data"][]=$v['addtime'];
		$data[$t]["data"][]="编辑^/System.php?s=/System/SmsAll/EditRead&id=".$v['id']."^_self";
		$data[$t]["data"][]=0;
	}
		

	return $data;
}
