<?php
namespace Home\Controller;
use Think\Controller;

class UserController extends Controller {    

    /*
     * 主页
     * 
     * return #
    */
    public function index(){

    }
    
    /*
     * 登录
     * 
    */ 
    public function Login(){
        if(empty(I("post.username",'','strip_tags'))||empty(I("post.userpwd",'','strip_tags'))){
			$json['status']['err']=1;
			$json['status']['msg']="用户名或密码错误！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
		$User=M('sys_userinfo')->where('uname="'.str_replace(' ','',I('post.username', '','strip_tags')).'" and ucheck=1')->select();
		if(count($User)==1){
			if($User[0]["upwd"]==md5(I('post.userpwd', '','strip_tags'))){
				$sessionid=md5(time(). mt_rand(0,1000));
				$data["sessionid"]=$sessionid;
				$data["lastaddtime"]=date('y-m-d h:i:s',time());
				M('sys_userinfo')->where('uname="'.str_replace(' ','',I('post.username', '','strip_tags')).'"')->save($data);
				$json['username']=$User[0]["uname"];
				$json['sessionid']=$sessionid;
				$json['nickname']=$User[0]["truename"];
				$json['userimg']=$User[0]["userimg"];
				$json['umoney']=$User[0]["umoney"];
				$json['wx']=$User[0]["wx"]==""?0:1;
				$json['qq']=$User[0]["qq"]==""?0:1;
				$json['wb']=$User[0]["wb"]==""?0:1;
				$sql="select db_temp.*,db_pile.pilenum,db_sitelist.sitename,db_sitelist.uint from db_temp left join db_pile on db_temp.pid=db_pile.id left join db_sitelist on db_pile.parentid=db_sitelist.id where db_temp.isclose=0 and db_temp.isenable=1 and db_temp.uname='".$User[0]["uname"]."'";
				$T=M()-> query($sql);
				if(count($T)==1){
					$json['chargeid']=$T[0]['id'];
					$json['sitename']=$T[0]['sitename'];
					$json['pilenum']=$T[0]['pilenum'];
					$json['uint']=$T[0]['uint'];	
				}else{
					$json['chargeid']=0;
					$json['sitename']="";
					$json['pilenum']="";
					$json['uint']="";	
				}
				$json['status']['err']=0;
				$json['status']['msg']="登录成功！";
				$this->ajaxReturn($json, 'json');
				exit;
			}else{
				$json['status']['err']=2;
				$json['status']['msg']="用户名或密码错误！";
				$this->ajaxReturn($json, 'json');
				exit;	
			}
		}else{
			$json['status']['err']=1;
			$json['status']['msg']="用户名或密码错误！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
    }

    /*
     * 第三方登录
     * 
     * return #
    */
    public function OAuth(){
        $json['status']['err']=1;
		$json['status']['msg']="该功能暂未开放！";
		$this->ajaxReturn($json, 'json');
		exit;
    }
    
	/*
	*注册验证码
	*
	*/
    public function Regcode(){
		$tel = I('post.tel', '', 'number_int');
        $json = array();
        $res = M('sys_userinfo')->where('uname="'.$tel.'"')->find();
		if ($res) {
            $json['status']['err']=1;
			$json['status']['msg']="该用户已经注册！";
			$this->ajaxReturn($json, 'json');
			exit;
        }

		$res = M('code')->where('tel="'.$tel.'" and type=0 and addtime>NOW()-interval 60 second')->find();
		if($res){
			$json['status']['err']=1;
			$json['status']['msg']="验证码发送速度过快，请等待60秒后重试！";
			$this->ajaxReturn($json, 'json');
			exit;
		}

		for ($i=0; $i<5;$i++) {
            $randcode.=rand(0, 9);
        }
        $msg = array();
        $msg['code'] = $randcode;
        $msg['username'] = $tel;
        $msg['template'] = 'SMS_12625408';
        //调用短信接口发送数据
        require_once dirname(__FILE__) . '/../../../Api/alidy/sendMsg.php';
        $sendObject = new \sendMsg();
        $senres = $sendObject->send($msg);
		if ($senres['status'] == 1) {
			$data = array();
            $data['tel'] = $tel;
            $data['code'] = $randcode;
			if(M('code')->add($data)){
				$json['status']['err']=0;
				$json['status']['msg']="验证码发送成功，请查收！";
				$this->ajaxReturn($json, 'json');
				exit;				
			}else{
				$json['status']['err']=1;
				$json['status']['msg']="信息填写有误！";
				$this->ajaxReturn($json, 'json');
				exit;
			}
			
		}else{
			$json['status']['err']=1;
			$json['status']['msg']=(string)$senres['msg'];
			$this->ajaxReturn($json, 'json');
			exit;	
		}		
    }
	
	/*
	*注册
	*
	*/
	public function Register(){
		$tel = I('post.tel', 0, 'number_int');
		$code = I('post.code', 0, 'number_int');
		$pwd = I('post.pwd', '', 'strip_tags'); 
        $json = array();
		
		if($tel==0){
			$json['status']['err']=1;
			$json['status']['msg']="用户名不能为空！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		
		if($code==0){
			$json['status']['err']=1;
			$json['status']['msg']="验证码不能为空！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		if(strlen($pwd)<6||strlen($pwd)>12){
			$json['status']['err']=1;
			$json['status']['msg']="密码长度在6-12位之间！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}

        $res = M('sys_userinfo')->where('uname="'.$tel.'"')->find();
		if ($res) {
            $json['status']['err']=1;
			$json['status']['msg']="该用户已经注册！";
			$this->ajaxReturn($json, 'json');
			exit;
        }
	
		$res = M('code')->where('tel="'.$tel.'" and type=0 and addtime>NOW()-interval 120 second')->find();
		if(!$res){
			$json['status']['err']=1;
			$json['status']['msg']="验证码可能超时，请重新发送！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
		
		if(md5($code)!=md5($res["code"])){
			$json['status']['err']=1;
			$json['status']['msg']="验证码不正确！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
		$params = array();
		$params['uname'] = $tel;
        $params['truename'] = $tel;
        $params['upwd'] = md5($pwd);
		$params['addtime'] = date('y-m-d h:i:s',time());
		$params['lastaddtime'] = date('y-m-d h:i:s',time());
		if(M('sys_userinfo')->add($params)){
			$json['status']['err']=0;
			$json['status']['msg']="注册成功！";
			$this->ajaxReturn($json, 'json');
			exit;
		}else{
			$json['status']['err']=1;
			$json['status']['msg']="注册失败！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
	}
	
	/*
	*找回密码验证码
	*
	*/
    public function Getpwdcode(){
		$tel = I('post.tel', '', 'number_int');
        $json = array();
        $res = M('sys_userinfo')->where('uname="'.$tel.'"')->find();
		if (!$res) {
            $json['status']['err']=1;
			$json['status']['msg']="信息填写有误！";
			$this->ajaxReturn($json, 'json');
			exit;
        }

		$res = M('code')->where('tel="'.$tel.'" and type=1 and addtime>NOW()-interval 120 second')->find();
		if($res){
			$json['status']['err']=1;
			$json['status']['msg']="验证码发送速度过快，请等待两分钟后重试！";
			$this->ajaxReturn($json, 'json');
			exit;
		}

		for ($i=0; $i<5;$i++) {
            $randcode.=rand(0, 9);
        }
        $msg = array();
        $msg['code'] = $randcode;
        $msg['username'] = $tel;
        $msg['template'] = 'SMS_12625408';
        //调用短信接口发送数据
        require_once dirname(__FILE__) . '/../../../Api/alidy/sendMsg.php';
        $sendObject = new \sendMsg();
        $senres = $sendObject->send($msg);
		if ($senres['status'] == 1) {
			$data = array();
            $data['tel'] = $tel;
            $data['code'] = $randcode;
			$data['type'] = 1;
			if(M('code')->add($data)){
				$json['status']['err']=0;
				$json['status']['msg']="验证码发送成功，请查收！";
				$this->ajaxReturn($json, 'json');
				exit;				
			}else{
				$json['status']['err']=1;
				$json['status']['msg']="信息填写有误！";
				$this->ajaxReturn($json, 'json');
				exit;
			}
			
		}else{
			$json['status']['erdddr']=$senres['status'];
			$json['status']['err']=1;
			$json['status']['msg']=$senres['msg'];
			$this->ajaxReturn($json, 'json');
			exit;	
		}		
    }
	
	/*
	*找回密码 by:ll 2016.7.21 15.51
	*
	*/
	public function Getpwd(){
		$tel = I('post.tel', 0, 'number_int');
		$code = I('post.code', 0, 'number_int');
		$pwd = I('post.pwd', '', 'strip_tags'); 
        $json = array();
        $res = M('sys_userinfo')->where('uname="'.$tel.'"')->find();
		if (!$res) {
            $json['status']['err']=1;
			$json['status']['msg']="信息填写有误！";
			$this->ajaxReturn($json, 'json');
			exit;
        }
		
		$res = M('code')->where('tel="'.$tel.'" and type=1 and addtime>NOW()-interval 120 second')->find();
		if(!$res){
			$json['status']['err']=1;
			$json['status']['msg']="验证码可能超时，请重新发送！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
		if(md5($code)!=md5($res["code"])){
			$json['status']['err']=1;
			$json['status']['msg']="验证码不正确！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
		$params = array();
        $params['upwd'] = md5($pwd);
		$params['lastaddtime'] = date('y-m-d h:i:s',time());
		if(M('sys_userinfo')->where('uname="'.$tel.'"')->save($params)){
			$json['status']['err']=0;
			$json['status']['msg']="修改成功！";
			$this->ajaxReturn($json, 'json');
			exit;
		}else{
			$json['status']['err']=1;
			$json['status']['msg']="信息填写有误！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
	}
	
	
	
	
	
	  /*
     * 登录状态下修改密码
     * 
     * $return
     */
    public function updatePwd(){
        $this->login_true();
        $json = array();
        $username = I('post.username','','number_int');
        $oldpwd = I('post.password1','','strip_tags');
        $newpwd1 = I('post.password2','','strip_tags');
        $newpwd2 = I('post.password3','','strip_tags');
        if(empty($oldpwd)){
            $json['status']['err']=1;
			$json['status']['msg']="旧密码不能为空！";
			$this->ajaxReturn($json, 'json');
			exit;
        }
        if(empty($newpwd1)){
            $json['status']['err']=1;
			$json['status']['msg']="新密码不能为空！";
			$this->ajaxReturn($json, 'json');
			exit;
        }
        if(empty($newpwd2)){
            $json['status']['err']=1;
			$json['status']['msg']="确认密码不能为空！";
			$this->ajaxReturn($json, 'json');
			exit;
        }
        if($newpwd1!=$newpwd2){
            $json['status']['err']=1;
			$json['status']['msg']="两次密码不一致！";
			$this->ajaxReturn($json, 'json');
			exit;
        }
        $check = M('sys_userinfo')->where("uname='".$username."' and upwd='".md5($oldpwd)."' and ucheck=1")->find();
        if(!$check){
            $json['status']['err']=1;
			$json['status']['msg']="旧密码不正确！";
			$this->ajaxReturn($json, 'json');
			exit;
        }
        if(M('sys_userinfo')->where("uname='".$username."'")->save(array('upwd'=>md5($newpwd1)))){
			$json['status']['err']=0;
			$json['status']['msg']="修改成功！";
			$this->ajaxReturn($json, 'json');
			exit;
		}else{
       		$json['status']['err']=1;
			$json['status']['msg']="信息填写有误！";
			$this->ajaxReturn($json, 'json');
			exit;
		}
    }

	 /*
     * 个人资料修改,昵称和头像
     * 
     * return #
    */
    public function person_info_update(){
        $this->login_true();
        $params = array();
        $username = I('post.username','','number_int');
        $nickname = I('post.nickname','','strip_tags');
        if(!empty($nickname)){
            $params['truename'] = $nickname;
        }
		
        if(!empty($_FILES)){
            $config = array(
                'maxSize' => 3145728,
                'rootPath' =>'./',
				'savePath' => '/Web/UploadFile/UserInfo/',
                'exts' => array('jpg','jpeg'),
            );
            $upload = new \Think\Upload($config);
            $ret = $upload->upload($_FILES);
            if ($ret) {
                $params['userimg'] =$ret['pto']['savepath'].$ret['pto']['savename'];
				$rets=M('sys_userinfo')->where('uname="'.$username.'"')->find();
				$this->filedel($_SERVER["DOCUMENT_ROOT"]."/Web/UploadFile/UserInfo/".$rets['userimg']);
            }else{
				$json['status']['err']=1;
				$json['status']['msg']="修改失1败！";
				$this->ajaxReturn($json, 'json');
				exit;
			}
        }
        $res = M('sys_userinfo')->where('uname="'.$username.'"')->save($params);
        if ($res) {
			if(!empty($_FILES)){
				$json['userimg'] =$params['userimg'];
			}
			$json['status']['err'] = 0;
            $json['status']['msg'] = '修改成功！';
			$this->ajaxReturn($json, 'json');
			exit;
        } else {
            $json['status']['err']=1;
			$json['status']['msg']="修1改失败！";
			$this->ajaxReturn($json, 'json');
			exit;
        }
    }
	
	
	 /*
     * 我的收藏-增加-取消
     * 
     * return #
    */
    public function coll_add_cancel(){
     
        $sid = I('post.sid','','number_int');
        $username = I('post.username','','number_int');
        $json = array();
        if (empty($sid)) {
           	$json['status']['err']=3;
			$json['status']['msg']="参数有误！";
			$this->ajaxReturn($json, 'json');
			exit;	
        }
        $ret = M('coll')->where('sid='.$sid.' and tel='.$username)->find();
        if ($ret) {
            $rescancel = M('coll')->where('sid='.$sid.' and tel='.$username)->delete();
            if($rescancel){
				$json['iscoll']=0;
				$json['status']['err']=0;
				$json['status']['msg']="取消收藏成功！";
				$this->ajaxReturn($json, 'json');
				exit;
            }else{
                $json['status']['err']=1;
				$json['status']['msg']="操作失败！";
				$this->ajaxReturn($json, 'json');
				exit;
            }
        }
        $params = array();
        $params['sid'] = $sid;
        $params['tel'] = $username;
		$params['addtime'] = date('y-m-d h:i:s',time());
        $res = M('coll')->add($params);
        if($res){
			$json['iscoll']=1;
            $json['status']['err']=0;
			$json['status']['msg']="收藏成功！";
			$this->ajaxReturn($json, 'json');
			exit;
        }else{
            $json['status']['err']=1;
			$json['status']['msg']="操作失败！";
			$this->ajaxReturn($json, 'json');
			exit;
        }
    }
	
	//删除文件
	public function filedel($a){
		if(!empty($a)){
			unlink($a);
		}
	}
	
	 /*
     * 我的收藏
     * 
     * return #
    */
    public function my_collection(){
        $this->login_true();
        $username = I('post.username', '', 'number_int');
        $maxid = I('post.maxid', '', 'number_int');
        $pagenow = I('post.page', '', 'number_int');
        $count = M('coll')->where('tel="'.$username.'"')->count();//添加分页 by:ll 2016/1/8
        $pagesize = 10;
        if(empty($pagenow) || $pagenow < 1){
            $pagenow = 1;
        }
        //获取偏移量，防止新加数据导致翻页出现重复数据
        if($count>0){
            $max = M('coll')->where('tel="'.$username.'"')->max('id');
            if(empty($maxid)){
                $maxid = $max;
            }
            /*if($maxid!=$max){
                $offset = M('coll')->where("tel='".$username."' and id>".$maxid." and id<=".$max)->count();
                $start = ($pagenow-1)*$pagesize+$offset;
            }else{*/
            $start = ($pagenow-1)*$pagesize;
            //}
            if($start > $count-1){
                $json['maxid'] = $max; 
				$json['data'] = '';
                $json['status']['err']=0;
				$json['status']['msg']="查询成功！";
                $this->ajaxReturn($json, 'json');
				exit;
            }

			$sql="SELECT db_sitelist.* FROM db_coll left join db_sitelist on db_coll.sid=db_sitelist.id  where db_coll.tel='".$username."' and db_sitelist.isenable = 1 AND db_sitelist.isdelete = 0 and db_coll.id<=".$maxid." order by db_coll.id desc limit ".$start.",".$pagesize;
			
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
		   	$json['data']=$data;
			$json['maxid'] = $max; 
			$json['status']['err']=0;
			$json['status']['msg']="执行成功！";
			$this->ajaxReturn($json, 'json');
			exit;   
			}else{
				$json['maxid'] = $max; 
				$json['data'] = '';
            	$json['status']['err']=0;
				$json['status']['msg']="查询完成！";
           		$this->ajaxReturn($json, 'json');
				exit;	
			}
		}else{
			$json['maxid'] = $max; 
			$json['data'] = '';
            $json['status']['err']=0;
			$json['status']['msg']="查询完成！";
           	$this->ajaxReturn($json, 'json');
			exit;	
		}
    }
    
	//交易记录
	public function Myorder(){
		$this->login_true();
        $username = I('post.username', '', 'number_int');
        $maxid = I('post.maxid', '', 'number_int');
        $pagenow = I('post.page', '', 'number_int');
        $count = M('usou')->where('uname="'.$username.'"')->count();//添加分页 by:ll 2016/1/8
        $pagesize = 10;
        if(empty($pagenow) || $pagenow < 1){
            $pagenow = 1;
        }
        //获取偏移量，防止新加数据导致翻页出现重复数据
        if($count>0){
            $max = M('usou')->where('uname="'.$username.'"')->max('id');
            if(empty($maxid)){
                $maxid = $max;
            }
            $start = ($pagenow-1)*$pagesize;
            if($start > $count-1){
                $json['maxid'] = $max; 
				$json['data'] = '';
                $json['status']['err']=0;
				$json['status']['msg']="查询成功！";
                $this->ajaxReturn($json, 'json');
				exit;
            }
			$sql="SELECT * FROM db_usou where uname=".$username."  order by id desc limit ".$start.",".$pagesize;
			
			if($T=M()-> query($sql)){
		   	$data=array();
			foreach($T as $t=>$v){
				$data[$t]['id']=(int)$v['id'];
				$data[$t]['type']=$v['type'];
				$data[$t]['Adesc']=$v['Adesc'];
				$data[$t]['cnum']=$v['cnum'];
				$data[$t]['enum']=$v['enum'];
				$data[$t]['addtime']=$v['addtime'];
				$data[$t]['elenum']=$v['elenum'];
				$data[$t]['No']=$v['No'];
				$data[$t]['sitename']=$v['sitename'];
				$data[$t]['uint']=$v['uint'];
				$data[$t]['pilenum']=$v['pilenum'];
				
			}
		   	$json['data']=$data;
			$json['maxid'] = $max; 
			$json['status']['err']=0;
			$json['status']['msg']="执行成功！";
			$this->ajaxReturn($json, 'json');
			exit;   
			}else{
            	$json['status']['err']=0;
				$json['maxid'] = $max;
				$json['data'] = '';
				$json['status']['msg']="查询完成！";
           		$this->ajaxReturn($json, 'json');
				exit;	
			}			
		}else{
            $json['status']['err']=0;
			$json['maxid'] = $max;
			$json['data'] = '';
			$json['status']['msg']="查询完成！";
            $this->ajaxReturn($json, 'json');
			exit;	
		}
		
	}
	
	//获取金额
	public function getMoney(){
		$this->login_true();
		$User=M('sys_userinfo')->where('uname="'.str_replace(' ','',I('post.username', '','strip_tags')).'" and ucheck=1')->select();
		if(count($User)==1){
			$json['umoney']=$User[0]["umoney"];
			$json['status']['err']=0;
			$json['status']['msg']="请求成功！";
            $this->ajaxReturn($json, 'json');
			exit;	
		}else{
			$json['status']['err']=2;
			$json['status']['msg']="请求有误！";
            $this->ajaxReturn($json, 'json');
			exit;	
		}
	}
	
	
	
    //验证登录
	public function login_true(){
		$User=M('sys_userinfo')->where('uname="'.str_replace(' ','',I('post.username', '','strip_tags')).'" and ucheck=1')->select();
		if(count($User)==1){
			if($User[0]["sessionid"]!=I('post.sessionid', '','strip_tags')){
				$json['status']['err']=20;
				$json['status']['msg']="用户在其他地方登录！";
				$this->ajaxReturn($json, 'json');
				exit;
			}
		}else{
			$json['status']['err']=1;
			$json['status']['msg']="用户名或密码错误！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
		$data["lastaddtime"]=date('y-m-d h:i:s',time());
		M('sys_userinfo')->where('uname="'.str_replace(' ','',I('post.username', '','strip_tags')).'"')->save($data); 
	}
	
	
	
	
	
	
	
	//短信提醒 控制台访问方法 余额不足 断线等
	public function Sendhit(){
		$tel=I('get.username','','strip_tags');
		$sessionid=I('get.sessionid', '','strip_tags');
		$num=I('get.num','','intval');
		$User=M('sys_userinfo')->where('uname="'.str_replace(' ','',$tel).'" and ucheck=1')->select();
		if(count($User)!=1||$num==''){
			exit;
		}
        $msg = array();
        $msg['tel'] = $tel;
		$msg['tempname'] = '测试平台';
        $msg['template'] = 'SMS_27945058';
		$msg['num']=$num;
        //调用短信接口发送数据
        require_once dirname(__FILE__) . '/../../../Api/alidy/sendMsg.php';
        $sendObject = new \sendMsg();
        $senres = $sendObject->sendHit($msg);			
	}
	
}
