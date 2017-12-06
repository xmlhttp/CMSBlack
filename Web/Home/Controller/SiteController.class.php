<?php
namespace Home\Controller;
use Think\Controller;

class SiteController extends Controller {      
  	/*
	 *所有站点
	*/
    public function Site_list(){
      // $sql="SELECT a.*, IFNULL( sum(IF(b.gtype = 'ACnum', num, 0)), 0 ) AS ACnum, IFNULL( sum(IF(b.gtype = 'DCnum', num, 0)), 0 ) AS DCnum, IFNULL( sum(IF(b.gtype = 'ACount', num, 0)), 0 ) AS ACount, IFNULL( sum(IF(b.gtype = 'DCount', num, 0)), 0 ) AS DCount FROM db_sitelist a LEFT JOIN ( SELECT CASE gtype WHEN 0 THEN 'ACnum' WHEN 1 THEN 'Dcnum' ELSE 'Othernum' END AS gtype, parentid, sum( IF (pA = 4, 1, 0) + IF (pB = 4, 1, 0) + IF (pC = 4, 1, 0) + IF (pD = 4, 1, 0)) AS num FROM db_pile WHERE (pA = 4 OR pB = 4 OR pC = 4 OR pD = 4) AND isdelete = 0 AND isenable = 1 GROUP BY gtype, parentid UNION ALL SELECT IF (gtype = 0, 'ACount', 'Dcount') AS gtype, parentid, sum( IF (pA = 0, 0, 1) + IF (pB = 0, 0, 1) + IF (pC = 0, 0, 1) + IF (pD = 0, 0, 1)) AS num FROM db_pile WHERE (pA <> 0 OR pB <> 0 OR pC <> 0 OR pD <> 0) AND isdelete = 0 AND isenable = 1 GROUP BY gtype, parentid ) b ON a.id = b.parentid WHERE a.isdelete = 0 AND a.isenable = 1 GROUP BY b.parentid, a.id ORDER BY a.orderid DESC";
	$sql="SELECT * FROM db_sitelist where isenable = 1 AND isdelete = 0";
	   if($T=M()-> query($sql)){
		   $data=array();
			foreach($T as $t=>$v){
				$data[$t]['id']=(int)$v['id'];
				$data[$t]['sitename']=$v['sitename'];
				$data[$t]['siteadd']=$v['siteadd']==null?'':$v['siteadd'];
				$data[$t]['siteinfoadd']=$v['siteinfoadd']==null?'':$v['siteinfoadd'];
				$data[$t]['sitetel']=$v['sitetel']==null?'13829719806':$v['sitetel'];
				$data[$t]['siteimg']=($v['siteimg']==null?'none.jpg':$v['siteimg']);
				$data[$t]['siteimgs']=($v['siteimgs']==null?'none.jpg':$v['siteimgs']);
				$data[$t]['sitemap']=($v['sitemap']==null?'none.jpg':$v['sitemap']);
				$data[$t]['sitex']=$v['sitex']==null?'':$v['sitex'];
				$data[$t]['sitey']=$v['sitey']==null?'':$v['sitey'];
				$data[$t]['bsitex']=$v['bsitex']==null?'':$v['bsitex'];
				$data[$t]['bsitey']=$v['bsitey']==null?'':$v['bsitey'];
				$data[$t]['tsitex']=$v['tsitex']==null?'':$v['tsitex'];
				$data[$t]['tsitey']=$v['tsitey']==null?'':$v['tsitey'];
				$data[$t]['uint']=$v['uint']==null?'':$v['uint'];
			}
		   	$json['site']=$data;
			$json['status']['err']=0;
			$json['status']['msg']="执行成功！";
			$this->ajaxReturn($json, 'json');
			exit;   
		}else{
			$json['status']['err']=1;
			$json['status']['msg']="数据库命令执行错误！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
    }
	
		/*
	 *单站点
	 */
	public function Site_list_one(){
		if(I('post.sid',0,'intval')==0){
			$json['status']['err']=1;
			$json['status']['msg']="参数错误！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
		$sid=I('post.sid',0,'intval');
		$sql="select db_sitelist.*,(select count(*) from db_pile where db_pile.parentid=".$sid." and db_pile.isenable = 1 and db_pile.isdelete =0) as ACount,(select count(*) from db_pile where db_pile.parentid=".$sid." and db_pile.islink=1 and db_pile.ptype=0 and db_pile.isenable = 1 and db_pile.isdelete =0) as ACnum,(select count(*) from db_pile where db_pile.parentid=".$sid." and db_pile.islink=1 and db_pile.ptype=0 and db_pile.isenable = 1 and db_pile.isdelete =0 and db_pile.isnone =0) as Freenum from db_sitelist where id=".$sid;
		if($T=M()-> query($sql)){
			$json['site']['id']=(int)$T[0]['id'];
			$json['site']['sitename']=$T[0]['sitename'];
			$json['site']['siteadd']=$T[0]['siteadd']==null?'':$T[0]['siteadd'];
			$json['site']['siteinfoadd']=$T[0]['siteinfoadd']==null?'':$T[0]['siteinfoadd'];
			$json['site']['sitetel']=$T[0]['sitetel']==null?'13829719806':$T[0]['sitetel'];
			$json['site']['siteimg']=($T[0]['siteimg']==null?'none.jpg':$T[0]['siteimg']);
			$json['site']['siteimgs']=($T[0]['siteimgs']==null?'none.jpg':$T[0]['siteimgs']);
			$json['site']['sitemap']=($T[0]['sitemap']==null?'none.jpg':$T[0]['sitemap']);
			$json['site']['sitex']=$T[0]['sitex']==null?'':$T[0]['sitex'];
			$json['site']['sitey']=$T[0]['sitey']==null?'':$T[0]['sitey'];
			$json['site']['bsitex']=$T[0]['bsitex']==null?'':$T[0]['bsitex'];
			$json['site']['bsitey']=$T[0]['bsitey']==null?'':$T[0]['bsitey'];
			$json['site']['tsitex']=$T[0]['tsitex']==null?'':$T[0]['tsitex'];
			$json['site']['tsitey']=$T[0]['tsitey']==null?'':$T[0]['tsitey'];
			$json['site']['uint']=$T[0]['uint']==null?'':$T[0]['uint'];
			$json['site']['ACnum']=(int)($T[0]['ACnum']==null?0:$T[0]['ACnum']);
			$json['site']['ACount']=(int)($T[0]['ACount']==null?0:$T[0]['ACount']);
			$json['site']['Freenum']=(int)($T[0]['Freenum']==null?0:$T[0]['Freenum']);
			$json['status']['err']=0;
			$json['status']['msg']="执行成功！";
			$this->ajaxReturn($json, 'json');
			exit; 
		}else{
			$json['status']['err']=1;
			$json['status']['msg']="数据库命令执行错误！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		
	}

	/*
	 *单个站点详情
	*/
	public function Site_one(){
		if(I('post.sid',0,'intval')==0){
			$json['status']['err']=1;
			$json['status']['msg']="参数错误！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		$sql="select db_sitelist.*,(select count(*) from db_pile where db_pile.parentid=".I('post.sid',0,'intval')." and db_pile.isenable = 1 and db_pile.isdelete =0) as ACount,(select count(*) from db_pile where db_pile.parentid=".I('post.sid',0,'intval')." and db_pile.islink=1 and db_pile.ptype=0 and db_pile.isenable = 1 and db_pile.isdelete =0) as ACnum,(select count(*) from db_pile where db_pile.parentid=".I('post.sid',0,'intval')." and db_pile.islink=1 and db_pile.ptype=0 and db_pile.isenable = 1 and db_pile.isdelete =0 and db_pile.isnone=0) as Freenum from db_sitelist where id=".I('post.sid',0,'intval');
		if($T=M()-> query($sql)){
			$json['site']['id']=(int)$T[0]['id'];
			$json['site']['sitename']=$T[0]['sitename'];
			$json['site']['siteadd']=$T[0]['siteadd']==null?'':$T[0]['siteadd'];
			$json['site']['siteinfoadd']=$T[0]['siteinfoadd']==null?'':$T[0]['siteinfoadd'];
			$json['site']['sitetel']=$T[0]['sitetel']==null?'13829719806':$T[0]['sitetel'];
			$json['site']['siteimg']=($T[0]['siteimg']==null?'none.jpg':$T[0]['siteimg']);
			$json['site']['siteimgs']=($T[0]['siteimgs']==null?'none.jpg':$T[0]['siteimgs']);
			$json['site']['sitemap']=($T[0]['sitemap']==null?'none.jpg':$T[0]['sitemap']);
			$json['site']['sitex']=$T[0]['sitex']==null?'':$T[0]['sitex'];
			$json['site']['sitey']=$T[0]['sitey']==null?'':$T[0]['sitey'];
			$json['site']['bsitex']=$T[0]['bsitex']==null?'':$T[0]['bsitex'];
			$json['site']['bsitey']=$T[0]['bsitey']==null?'':$T[0]['bsitey'];
			$json['site']['tsitex']=$T[0]['tsitex']==null?'':$T[0]['tsitex'];
			$json['site']['tsitey']=$T[0]['tsitey']==null?'':$T[0]['tsitey'];
			$json['site']['uint']=$T[0]['uint']==null?'':$T[0]['uint'];
			$json['site']['ACnum']=(int)($T[0]['ACnum']==null?0:$T[0]['ACnum']);
			$json['site']['ACount']=(int)($T[0]['ACount']==null?0:$T[0]['ACount']);
			$json['site']['Freenum']=(int)($T[0]['Freenum']==null?0:$T[0]['Freenum']);
		}
		//$sql="SELECT a.*, IFNULL( sum(IF(b.gtype = 'ACnum', num, 0)), 0 ) AS ACnum, IFNULL( sum(IF(b.gtype = 'DCnum', num, 0)), 0 ) AS DCnum, IFNULL( sum(IF(b.gtype = 'ACount', num, 0)), 0 ) AS ACount, IFNULL( sum(IF(b.gtype = 'DCount', num, 0)), 0 ) AS DCount FROM db_sitelist a LEFT JOIN ( SELECT CASE gtype WHEN 0 THEN 'ACnum' WHEN 1 THEN 'Dcnum' ELSE 'Othernum' END AS gtype, parentid, sum( IF (pA = 4, 1, 0) + IF (pB = 4, 1, 0) + IF (pC = 4, 1, 0) + IF (pD = 4, 1, 0)) AS num FROM db_pile WHERE (pA = 4 OR pB = 4 OR pC = 4 OR pD = 4) AND isdelete = 0 AND isenable = 1 GROUP BY gtype, parentid UNION ALL SELECT IF (gtype = 0, 'ACount', 'Dcount') AS gtype, parentid, sum( IF (pA = 0, 0, 1) + IF (pB = 0, 0, 1) + IF (pC = 0, 0, 1) + IF (pD = 0, 0, 1)) AS num FROM db_pile WHERE (pA <> 0 OR pB <> 0 OR pC <> 0 OR pD <> 0) AND isdelete = 0 AND isenable = 1 GROUP BY gtype, parentid ) b ON a.id = b.parentid WHERE a.isdelete = 0 AND a.isenable = 1 AND a.id=".I('post.sid',0,'intval')." GROUP BY b.parentid, a.id ORDER BY a.orderid DESC";
		$sql="select * from db_pile where isenable=1 and isdelete=0 and parentid=".I('post.sid',0,'intval') ." order by orderid desc";
		if($T=M()-> query($sql)){
			$data=array();
			foreach($T as $t=>$v){
				$data[$t]['id']=(int)$v['id'];
				$data[$t]['pilenum']=$v['pilenum']==null?'':$v['pilenum'];
				$data[$t]['ptype']=$v['ptype'];
				$data[$t]['islink']=$v['islink']==null?0:$v['islink'];
				$data[$t]['cx']=$v['cx']==null?0:$v['cx'];
				$data[$t]['cy']=$v['cy']==null?0:$v['cy'];
				$data[$t]['cr']=$v['cr']==null?0:$v['cr'];
				$data[$t]['isnone']=$v['isnone']==null?3:$v['isnone'];
			}
		}
		
	   	$json['data']=$data;
		$json['iscoll']=0;
		if(!empty(I('post.username', '','strip_tags'))){
			$C = M('coll')->where('tel="'.I('post.username', '','strip_tags').'" and sid='.I('post.sid',0,'intval'))->find();
			if($C){
				$json['iscoll']=1;
			}
		}
		$json['status']['err']=0;
		$json['status']['msg']="执行成功！";
		$this->ajaxReturn($json, 'json');
		exit; 
	}

	/*
	桩信息
	*/
	public function Pile_list(){
		if(I('post.sid',0,'intval')==0){
			$json['status']['err']=1;
			$json['status']['msg']="参数错误！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		$fpile=0; //空闲桩
		$fpark=0; //空闲车位
		$sql="select * from db_pile where isenable=1 and isdelete=0 and parentid=".I('post.sid',0,'intval') ." order by orderid desc";
		if($T=M()-> query($sql)){
			$data=array();
			foreach($T as $t=>$v){
				$data[$t]['id']=(int)$v['id'];
				$data[$t]['pilenum']=$v['pilenum']==null?'':$v['pilenum'];
				$data[$t]['ptype']=$v['ptype'];
				$data[$t]['islink']=$v['islink']==null?0:$v['islink'];
				$data[$t]['cx']=$v['cx']==null?0:$v['cx'];
				$data[$t]['cy']=$v['cy']==null?0:$v['cy'];
				$data[$t]['cr']=$v['cr']==null?0:$v['cr'];
				$data[$t]['isnone']=$v['isnone']==null?3:$v['isnone'];
				if($v['islink']==1){
					if($v['ptype']==0){
						$fpile++;	
						if($v['isnone']==0){
							$fpark++;	
						}
					}
				}
				
			}
		}
		$json['ACnum']=$fpile;
		$json['Freenum']=$fpark;
	   	$json['data']=$data;
		$json['status']['err']=0;
		$json['status']['msg']="执行成功！";
		$this->ajaxReturn($json, 'json');
		exit; 
	}




	/*
	*启动充电
	*
	*/
	public function Scancode(){
		if(I('post.username', '','strip_tags')==''||I('post.sessionid', '','strip_tags')==''||I('post.scode', '','strip_tags')==''){
			$json['status']['err']=1;
			$json['status']['msg']="传送参数有误！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		A('Home/User')->login_true();
		$User=M('sys_userinfo')->where('uname="'.str_replace(' ','',I('post.username', '','strip_tags')).'" and ucheck=1')->select();
		if(floatval($User[0]["umoney"])<=0){
			$json['status']['err']=2;
			$json['status']['msg']="余额不足！";
			$this->ajaxReturn($json, 'json');
			exit;
		}	
		$url=I('post.scode', '','strip_tags');
		if(strpos($url,"http://temp.vmuui.com/index.php?s=/Home/Down/index/")!=0){
			$json['status']['err']=1;
			$json['status']['msg']="无效的二维码！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
		$par=explode("?",$url);
		$par1=explode("/",$par[1]);
		$scode=$par1[4];
		if(strlen($scode)!=20){
		
			$json['status']['err']=1;
			$json['status']['msg']="无效的二维码！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
		//$gid=substr($scode,-1);
		//$pid=(int)substr($scode,0,-1);
		$pid=(int)$scode;
		$T=M("pile")->where('id='.$pid.' and isdelete=0 and isenable=1 and islink=1')->select();
		if(count($T)!=1){
			$json['status']['err']=1;
			$json['status']['msg']="不存在的桩！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
		require_once 'Gateway.php';
		Gateway::$registerAddress = '127.0.0.1:1236';
		$gid=Gateway::getSession($T[0]['client_id']);
		if($gid['cid']!=0){
			$json['status']['err']=1;
			$json['status']['msg']="该桩为非空闲状态！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
		
		$data['uname']=I('post.username', '','strip_tags');
		$data['pilenum']=$T[0]["pilenum"];
		$data['pid']=$pid;
		$data['lasttime']=date("Y-m-d H:i:s");
		$data['addtime']=date("Y-m-d H:i:s");
		
		if($lastInsId =M('temp')->add($data)){
			Gateway::sendToClient($T[0]['client_id'],'1');
			$json['chargeid']=$lastInsId;
			$json['status']['err']=0;
			$json['status']['msg']="命令发送成功！";
			$this->ajaxReturn($json, 'json');
			exit;
		}else{
			$json['status']['err']=1;
			$json['status']['msg']="执行失败！";
			$this->ajaxReturn($json, 'json');
			exit;
		}		
	}
	
	/*
	*停止充电
	*
	*/
	public function StopCharge(){
		if(I('post.username', '','strip_tags')==''||I('post.sessionid', '','strip_tags')==''||I('post.chargeid', '','strip_tags')==''){
			$json['status']['err']=1;
			$json['status']['msg']="传送参数有误！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		A('Home/User')->login_true();
		$tel=I('post.username', '','strip_tags');
		$chargeid=I('post.chargeid', '','strip_tags');
		//$T=M("temp")->where('id='.$chargeid.' and isclose=0 and isenable=1')->find();
		$T=M("temp")->where('id='.$chargeid.' and isclose=0')->find();
		if(!$T){
			$json['status']['err']=1;
			$json['status']['msg']="不存在的充电！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
		$T1=M("pile")->where('id='.$T["pid"].' and isdelete=0 and isenable=1 and islink=1')->select();
		if(count($T1)!=1){
			$json['status']['err']=1;
			$json['status']['msg']="该站点不存在或未连接云平台！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		require_once 'Gateway.php';
		Gateway::$registerAddress = '127.0.0.1:1236';
		$gid=Gateway::getSession($T1[0]['client_id']);
		if($gid['cid']!=$chargeid){
			$json['status']['err']=1;
			$json['status']['msg']="非法操作！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
		Gateway::sendToClient($T1[0]['client_id'],'5');
		$json['status']['err']=0;
		$json['status']['msg']="命令发送成功！";
		$this->ajaxReturn($json, 'json');
		exit;
	}
	
	/*
	 *获取充电状态
	*/
	public function GetStatus(){
		if(I('post.username', '','strip_tags')==''||I('post.sessionid', '','strip_tags')==''||I('post.chargeid', '','strip_tags')==''){
			$json['status']['err']=1;
			$json['status']['msg']="传送参数有误！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		A('Home/User')->login_true();
		$tel=I('post.username', '','strip_tags');
		$chargeid=I('post.chargeid', '','strip_tags');
		$T=M("temp")->where('id='.$chargeid.' and isclose=0 and uname="'.$tel.'"')->find();
		if($T){
		if($T["isenable"]!=1){
			$json['status']['err']=1;
			$json['status']['msg']="充电未启动！";
			$this->ajaxReturn($json, 'json');
			exit;
		}else{
			$sql="select db_pile.*,db_sitelist.sitename,db_sitelist.uint from db_pile left join db_sitelist on db_pile.parentid=db_sitelist.id where db_pile.isenable=1 and db_pile.isdelete=0 and db_pile.islink=1 and db_pile.id=".$T["pid"];
			
			if($T1=M()-> query($sql)){
				$json['cinfo']['sitename']=$T1[0]['sitename'];
				$json['cinfo']['pilenum']=$T1[0]['pilenum'];
				$json['cinfo']['uint']=$T1[0]['uint'];
				$json['status']['err']=0;
				$json['status']['msg']="充电已启动！";
				$this->ajaxReturn($json, 'json');
				exit;
			}else{
				$json['status']['err']=2;
				$json['status']['msg']="信息错误！";
				$this->ajaxReturn($json, 'json');
				exit;	
			}	
		}
		}else{
			$json['status']['err']=2;
			$json['status']['msg']="信息错误！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
	}
	
	/*
	 *获取电度数据
	*/
	public function SiteGetNum(){
		if(I('post.username', '','strip_tags')==''||I('post.sessionid', '','strip_tags')==''||I('post.chargeid', '','strip_tags')==''){
			$json['status']['err']=1;
			$json['status']['msg']="传送参数有误！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		A('Home/User')->login_true();
		$tel=I('post.username', '','strip_tags');
		$chargeid=I('post.chargeid', '','strip_tags');
		$T=M("temp")->where('id='.$chargeid.' and uname="'.$tel.'"')->find();
		if($T){
		if($T["isenable"]==1&&$T["isclose"]==0){
			$json['cinfo']['time']=strtotime(date("Y-m-d H:i:s"))-strtotime($T["addtime"]);
			$json['cinfo']['Cnum']=floatval($T["eleend"])-floatval($T["elecount"])+0.1;
			$json['status']['err']=0;
			$json['status']['msg']="正在充电！";
			$this->ajaxReturn($json, 'json');
			exit;
		}else{
			$T1=M("usou")->where('cid='.$chargeid.' and uname="'.$tel.'" and type=1')->find();
			if($T1){
				$json['cinfo']['No']=$T1["No"];
				$json['cinfo']['endtime']=$T1["addtime"];
				$json['cinfo']['Adesc']=$T1["Adesc"];
				$json['cinfo']['cnum']=$T1["cnum"];
				$json['cinfo']['elenum']=$T1["elenum"];
				$json['cinfo']['starttime']=$T["addtime"];
				$json['cinfo']['ctime']=strtotime($T1["addtime"])-strtotime($T["addtime"]);
				$json['cinfo']['pilenum']=$T1["pilenum"];
				$json['cinfo']['sitename']=$T1["sitename"];
				$json['cinfo']['uint']=$T1["uint"];
				$json['status']['err']=1;
				$json['status']['msg']="充电停止！";
				$this->ajaxReturn($json, 'json');
				exit;
			}else{
				$json['status']['err']=2;
				$json['status']['msg']="信息错误！";
				$this->ajaxReturn($json, 'json');
				exit;	
			}
		}
		}else{
			$json['status']['err']=2;
			$json['status']['msg']="信息错误！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
	}
	
	/*
	 *获取停止充电状态
	*/
	public function GetClostStatus(){
		if(I('post.username', '','strip_tags')==''||I('post.sessionid', '','strip_tags')==''||I('post.chargeid', '','strip_tags')==''){
			$json['status']['err']=1;
			$json['status']['msg']="传送参数有误！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		A('Home/User')->login_true();
		$tel=I('post.username', '','strip_tags');
		$chargeid=I('post.chargeid', '','strip_tags');
		$T=M("temp")->where('id='.$chargeid.' and uname="'.$tel.'"')->find();
		if($T){
		if($T["isclose"]==1){
			$T1=M("usou")->where('cid='.$chargeid.' and uname="'.$tel.'" and type=1')->find();
			if($T1){
				$json['cinfo']['No']=$T1["No"];
				$json['cinfo']['endtime']=$T1["addtime"];
				$json['cinfo']['Adesc']=$T1["Adesc"];
				$json['cinfo']['cnum']=$T1["cnum"];
				$json['cinfo']['elenum']=$T1["elenum"];
				$json['cinfo']['starttime']=$T["addtime"];
				$json['cinfo']['ctime']=strtotime($T1["addtime"])-strtotime($T["addtime"]);
				$json['cinfo']['pilenum']=$T1["pilenum"];
				$json['cinfo']['sitename']=$T1["sitename"];
				$json['cinfo']['uint']=$T1["uint"];
				$json['status']['err']=0;
				$json['status']['msg']="充电停止！";
				$this->ajaxReturn($json, 'json');
				exit;
			}else{
				$json['status']['err']=2;
				$json['status']['msg']="信息错误1！";
				$this->ajaxReturn($json, 'json');
				exit;	
			}
		}else{
			$json['status']['err']=1;
			$json['status']['msg']="充电未停止！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		}else{
			$json['status']['err']=2;
			$json['status']['msg']="信息错误2！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
	}	
	
	/*
	*获取结束充电订单
	*/
	public function GetEndCharge(){
		if(I('post.username', '','strip_tags')==''||I('post.sessionid', '','strip_tags')==''||I('post.chargeid', '','strip_tags')==''){
			$json['status']['err']=1;
			$json['status']['msg']="传送参数有误！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		A('Home/User')->login_true();
		$tel=I('post.username', '','strip_tags');
		$chargeid=I('post.chargeid', '','strip_tags');
		$T=M("temp")->where('id='.$chargeid.' and uname="'.$tel.'" and isenable=1 and isclose=1')->find();
		$T1=M("usou")->where('cid='.$chargeid.' and uname="'.$tel.'" and type=1')->find();
		if($T&&$T1){
				$json['cinfo']['No']=$T1["No"];
				$json['cinfo']['endtime']=$T1["addtime"];
				$json['cinfo']['Adesc']=$T1["Adesc"];
				$json['cinfo']['cnum']=$T1["cnum"];
				$json['cinfo']['elenum']=$T1["elenum"];
				$json['cinfo']['starttime']=$T["addtime"];
				$json['cinfo']['ctime']=strtotime($T1["addtime"])-strtotime($T["addtime"]);
				$json['cinfo']['pilenum']=$T1["pilenum"];
				$json['cinfo']['sitename']=$T1["sitename"];
				$json['cinfo']['uint']=$T1["uint"];
				$json['status']['err']=0;
				$json['status']['msg']="充电停止！";
				$this->ajaxReturn($json, 'json');
				exit;
		}else{
			$json['status']['err']=1;
			$json['status']['msg']="数据信息有误！";
			$this->ajaxReturn($json, 'json');
			exit;		
		}
	}	
		
}