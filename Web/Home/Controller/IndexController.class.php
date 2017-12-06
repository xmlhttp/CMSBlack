<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {    

    /*
     * 主页
     * 
     * return #
    */
    public function index(){
		$this->assign('title',"网站标题");
		$this->assign('keyword',"网站关键字");
		$this->display();
    }
	 public function test1(){
		header('Access-Control-Allow-Origin:*');
		for($i=0;$i<5;$i++){
			$json[$i]["label"]="ttt".($i+1);
			$json[$i]["isfinished"]=($i%2)==0?false:true; 
		}
		echo (isset($_GET['callback'])?$_GET['callback']:"").'('.json_encode($json).')';

		
    }
	/*
	*
	*版本号
	*/
	
	function getVer(){
		A('Home/User')->login_true();
		$cid = I('post.cid','','number_int');
		 if (empty($cid)) {
           	$json['status']['err']=3;
			$json['status']['msg']="参数有误！";
			$this->ajaxReturn($json, 'json');
			exit;
        }
		$ret = M('sys_site')->where('ver=0')->find();
		if($cid==1){
			$json['ver']=$ret["androidver"];
			$json['url']=$ret["androidurl"];
			$json['status']['err']=0;
			$json['status']['msg']="查询成功！";
			$this->ajaxReturn($json, 'json');
			exit;
		}else if($cid==2){
			$json['ver']=$ret["iosver"];
			$json['url']=$ret["iosurl"];
			$json['status']['err']=0;
			$json['status']['msg']="查询成功！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}else{
			$json['status']['err']=2;
			$json['status']['msg']="数据错误！";
			$this->ajaxReturn($json, 'json');
			exit;	
		}
			
	}


	
	
	
    
    /*
     * 个人中心
     * 
     * return #
    */ 
    public function a(){
        $this->login_true();
        $this->display();
    }

    /*
     * 我的账户
     * 
     * return #
    */
    public function account(){
        $this->display();
    }
    
    /*
     * 搜索
     * 
     * return #
    */
    public function search(){
        $this->display();
    }
    
    /*
     * 站点信息(所有)
     * 
     * return #
    */
    public function site_info(){
        A('Home/Site')->site_info();
    }
    
    /*
     * 站点列表
     * 
     * return #
    */
    public function site_list(){
        A('Home/Site')->site_list();
    }
    
    /*
     * 充电桩信息
     * 
     * return #
    */
    public function info_content(){
        $username = I('get.username', '', 'number_int');
        $sessionid = I('get.sessionid', '', 'strip_tags');
        $this->assign('username',$username);
        $this->assign('sessionid',$sessionid);
        $this->display();
    }
    
    /*
     * 单个站点信息(详情页面)
     * 
     * return #
    */
    public function site_info_one_all(){
        A('Home/Site')->site_info_one_all();
    }
    
    /*
     * 充电桩
     * 
     * return #
    */
    public function info(){
        $username = I('get.username', '', 'number_int');
        $sessionid = I('get.sessionid', '', 'strip_tags');
        $this->assign('username',$username);
        $this->assign('sessionid',$sessionid);
        $this->display();
    }
    
    /*
     * 单个站点信息页面充电桩桩点接口
     * 
     * return #
    */
    public function site_info_index_content(){
        A('Home/Site')->site_info_index_content();
    }
    
    /*
     * 附近设施
     * 
     * return #
    */
    public function shop(){
        $this->display();
    }
    
    /*
     * 附近设施 修改 by:11 2016/1/12
     * 
     * return #
    */
    public function site_around(){
        A('Home/Site')->site_around();
    }
    
    /*
     * 发表评论
     * 
     * return #
    */
    public function pinglun(){
        $this->login_true();
        $username = I('get.username', '', 'number_int');
        $sessionid = I('get.sessionid', '', 'strip_tags');
        $this->assign('username',$username);
        $this->assign('sessionid',$sessionid);
        $this->display();
    }
    
    /*
     * 输出成功评论 部分修改 by:ll 2016/1/13
     * 
     * return #
    */
    public function hidden_pl(){
        A('Home/Site')->hidden_pl();
    }
    
    /*
     *  分享 by:ll 2016/2/1
     * 
     * return #
    */
    public function site_share(){
        $siteinfo = A('Home/Site')->site_share();
        $this->assign('siteinfo',$siteinfo);
        $this->display();
    }
    
    /*
     * 我的收藏-增加-取消
     * 
     * return #
    */
    public function collection_add_cancel(){
        A('Home/Site')->collection_add_cancel();
    }
    
    /*
     * 报错
     * 
     * return #
    */
    public function feedback (){
        $this->display();
    }
    
    /*
     * 报错反馈 部分修改 by:ll 2016/1/13
     * 
     * return #
    */
    public function feedback_add(){
        A('Home/Site')->feedback_add();
    }
    
    /*
     * 登录
     * 
     * return #
    */
    public function login(){
        $this->display();
    }
  
    /*
     * 注册
     * 
     * return #
    */
    public function zhuce(){
        $this->display();
    }
    
    /*
     * 用户协议
     * 
     * return #
    */
    public function xieyi(){
        $this->display();
    }
    
    /*
     * 手机注册验证码验证
     * 
     * return #
    */
    public function getcode(){
        A('Home/User')->getcode();
    }
    
    /*
     * 注册 账号密码入库
     * 
     * return #
    */
    public function register(){
        A('Home/User')->register();
    }
    
    /*
     * 个人资料
     * 
     * return #
    */
    public function person_info(){
        A('Home/User')->person_info();
    }
    
    /*
     * 积分
     * 
     * return #
    */
    public function jf(){
        $this->display();
    }
    
    /*
     * 扫一扫
     * 
     * return #
    */
    public function code(){
        $this->login_true();
        $this->display();
    }
    
    /*
     * 输入终端号
     * 
     * return #
    */
    public function code2(){
        $this->display();
    }
    
    /*
     * 普通充电列表页
     * 
     * return #
    */
    public function ResNo(){
        $this->login_true();
        $username = I('get.username', '', 'number_int');
        $sessionid = I('get.sessionid', '', 'strip_tags');
        $this->assign('username',$username);
        $this->assign('sessionid',$sessionid);
        $this->display();
    }
    
    /*
     * 普通充电发起-返回枪列表 直接充电，输入端口号，输出可充电列表 修改 by:ll 2016/1/15
     * 
     * return #
    */
    public function device_open_gunlist(){
        A('Home/Charging')->device_open_gunlist();
    }
    
    /*
     * 普通充电开始流程
     * 
     * return #
    */
    public function device_open_common(){
        A('Home/Charging')->device_open_common();
    }
    
    /*
     * 确认充电(预约)
     * 
     * return #
    */
    public function Res(){
        $this->login_true();
        $username = I('get.username', '', 'number_int');
        $sessionid = I('get.sessionid', '', 'strip_tags');
        $this->assign('username',$username);
        $this->assign('sessionid',$sessionid);
        $this->display();
    }
    
    /*
     * 根据预约id返回预约信息(充电开始确认页面-预约)
     * 
     * @params array  $isorder #预约信息
     * 
     * return #
    */
    public function id_get_orderinfo() {
        A('Home/Order')->id_get_orderinfo();
    }
    
    /*
     * 预约充电开始流程
     * 
     * @params array  $isorder #预约信息
     * 
     * return #
    */
    public function device_open_order(){
        A('Home/Order')->device_open_order();
    }
    
    /*
     * 预约页面(旧)
     * 
     * return #
    */
    public function yuyue(){
        $this->login_true();
        $this->display();
    }

    /*
     * 预约页面
     * 
     * return #
    */
    public function Appointment(){
        $this->login_true();
        $username = I('get.username', '', 'number_int');
        $sessionid = I('get.sessionid', '', 'strip_tags');
        $this->assign('username',$username);
        $this->assign('sessionid',$sessionid);
        $this->display();
    }
    
    /*
     * 预约充电开始(返回列表信息)
     * 
     * return #
    */
    public function site_gun_list() {
        A('Home/Order')->site_gun_list();
    }
    
    /*
     * 预约开始 修改 by:ll 2016/1/14
     * 
     * return #
    */
    public function order_gun_start() {
        A('Home/Order')->order_gun_start();
    }
    
    /*
     * 根据枪号可返回对应桩的信息、站的信息
     *
     * return #
    */
    public function site_term_info(){
        A('Home/Order')->site_term_info();
    }
    
    /* 
     * 取消预约
     * 
     * return #
    */
    public function order_gun_cancel() {
        A('Home/Order')->order_gun_cancel();
    }
    
    /*
     * 导航页 by:ll 2016/1/11
     * 
     * return #
     */
    public function Nav(){
        $username = I('get.username', '', 'number_int');
        $sessionid = I('get.sessionid', '', 'strip_tags');
        $this->assign('username',$username);
        $this->assign('sessionid',$sessionid);
        $this->display();
    }
    
    /*
     * 导航中心 by:ll
     * 
     * return #
     */
    public function navi_center(){
        A('Home/User')->navi_center();
    }
    
    /*
     * 用户消费记录 by:ll 2016/1/29
     * 
     * return $data
     */
    public function user_costs(){
        A('Home/User')->user_costs();
    }
    
    /*
     * 充值
     * 
     * return #
    */
    public function recharge(){
        $this->login_true();
        $username = I('get.username', '', 'number_int');
        $sessionid = I('get.sessionid', '', 'strip_tags');
        $this->assign('username',$username);
        $this->assign('sessionid',$sessionid);
        $this->display();
    }
    
    /*
     * 充值记录 by:ll 2016/1/29
     * 
     * return $data
     */
    public function pay_history(){
        A('Home/Pay')->pay_history();
    }
    
    /*
     * 充值记录详情(充电) by:ll 2016/5/10
     * 
     * return $data
     */
    public function history_detail(){
        A('Home/Pay')->history_detail();
    }
    
    /*
     * 支付相关参数 by:ll 2016/1/22
     * 
     * return #
     */
    public function payperpare(){
        A('Home/Pay')->payperpare();
    }
    
    /*
     * 保存支付订单号，用于支付结果校验 by:ll 2016/1/14
     * 
     * return #
     */
    public function paysave(){
        A('Home/Pay')->paysave();
    }

    /*
     * 消息中心页面
     * 
     * return #
    */
    public function msg(){
        $this->login_true();
        $username = I('get.username', '', 'number_int');
        $sessionid = I('get.sessionid', '', 'strip_tags');
        $this->assign('username',$username);
        $this->assign('sessionid',$sessionid);
        $this->display();
    }
    
    /*
     * 消息分类数量
     * 
     * 
     */
    public function perinfo_type(){
        A('Home/User')->perinfo_type();
    }
    
    /*
     * 消息中心获取全部消息
     * 
     * return #
    */
    public function perinfo_news() {
        A('Home/User')->perinfo_news();
    }
    
    /*
     * 单条消息
     * 
     * return #
    */
    public function perinfo_news_one() {
        A('Home/User')->perinfo_news_one();
    }
    
    /*
     * 正在充电(旧)
     * 
     * return #
    */
    public function info_ac(){
        $this->login_true();
        $this->display();
    }
    
    /*
     * 正在充电
     * 
     * return #
    */
    public function info_txt(){
        $this->login_true();
        $username = I('get.username', '', 'number_int');
        $sessionid = I('get.sessionid', '', 'strip_tags');
        $this->assign('username',$username);
        $this->assign('sessionid',$sessionid);
        $this->display();
    }
        
    /*
     * 充电实时状态
     * 
     * return #
    */
    public function device_time(){
        A('Home/Charging')->device_time();
    }
    
    /*
     * 30s请求桩是否开启充电 by:ll 2016.6.2 14:57
     * 
     * return (array)
     */
    public function device_time_now(){
        A('Home/Charging')->device_time_now();
    }
    
    /*
     * 发起停止充电请求
     * 
     * return #
    */
    public function device_close ($username, $gunNo='', $chargid='', $light='') {//参数修改，添加参数username by:ll 2016/1/12
        A('Home/Charging')->device_close($username, $gunNo, $chargid, $light);
    }
    
    /*
     * 收藏
     * 
     * return #
    */
    public function coll(){
        $this->login_true();
        $username = I('get.username', '', 'number_int');
        $sessionid = I('get.sessionid', '', 'strip_tags');
        $this->assign('username',$username);
        $this->assign('sessionid',$sessionid);
        $this->display();
    }
    
    /*
     * 我的收藏
     * 
     * return #
    */
    public function my_collection(){
        A('Home/User')->my_collection();
    }
    
    /*
     * 历史清单
     * 
     * return #
    */
    public function form(){
        $this->display();
    }
    
    /*
     * 历史清单 by:ll 2016/1/11 修改 2016/1/18
     * 
     * return #
     */
    public function user_history(){
        A('Home/User')->user_history();
    }
    
    /*
     * 评论列表
     * 
     * return #
    */
    public function comment(){
        $this->display();
    }
    
    /*
     * 我的评论
     * 
     * return #
    */
    public function my_comment(){
        A('Home/User')->my_comment();
    }
    
    /*
     * 我的预约页面 修改 by:ll 2016/1/11
     *
     * return #
    */
    public function Myorder(){
        $username = I('get.username', '', 'number_int');
        $sessionid = I('get.sessionid', '', 'strip_tags');
        $this->assign('username',$username);
        $this->assign('sessionid',$sessionid);
        $this->display();
    }
    
    /*
     * 我的预约数据 修改 by:ll 2016/1/11
     *
     * return #
    */
    public function my_order(){
        A('Home/Order')->my_order();
    }
    
    /*
     * 设置
     * 
     * return #
    */
    public function set(){
        $this->login_true();
        
        $username = I('get.username','','number_int');
        $sessionid = I('get.sessionid','','strip_tags');
        $userdata = M('user')->where('username="'.$username.'"')->field('pto,nickname,sex,area,salepop,systempop,accomtomnt')->find();
        $this->assign('username',$username);
        $this->assign('sessionid',$sessionid);
        $this->assign('userdata',$userdata);
        
        $this->display();
    }
    
    /*
     * 登录状态下更新密码 by:ll 2016.5.6
     * 
     * return #
    */
    public function updatePwd(){
        A('Home/User')->updatePwd();
    }
    
    /*
     * 设置(个人资料修改) by:ll 2016/1/8
     * 
     * return #
    */
    public function person_info_update(){
        A('Home/User')->person_info_update();
    }
    
    /*
     * 活动(已弃用)
     * 
     * return #
    */
    public function paty(){
        $this->display();
    }
    
    /*
     * 个人中心(旧，已弃用)
     * 
     * return #
    */
    public function usercent(){
        //个人中心修改 by:ll 2016/1/7
        $this->login_true();
        $username = I('get.username', '', 'number_int');
        $sessionid = I('get.sessionid', '', 'strip_tags');
        $this->assign('username',$username);
        $this->assign('sessionid',$sessionid);
        $this->display();
    }
    
    /*
     * 车主认证-品牌
     * 
     * return $data
    */
    public function car_brand(){
        A('Home/User')->car_brand();
    }
    
    /*
     * 车主认证-型号
     * 
     * return $data
    */
    public function car_type(){
        A('Home/User')->car_type();
    }
    
    /*
     * 车主认证-保存车主车信息
     * 
     * return $data
    */
    public function user_car(){
        A('Home/User')->user_car();
    }
    
    /*
     * 车主认证-显示车主车信息
     * 
     * return $data
    */
    public function show_user_car(){
        A('Home/User')->show_user_car();
    }
    
    /*
     * 第三方登录验证——QQ/微信/微博
     * 
     * return $data
     */
    
    public function OAuth(){
        A('Home/User')->OAuth();
    }
    
    /*
     * 第三方登录验证码
     * 
     * return $data
     */
    public function getOcode(){
        A('Home/User')->getOcode();
    }
    
    /*
     * 绑定操作——未登录
     * 
     * return $arr
     */
    public function bingNologin(){
        A('Home/User')->bingNologin();
    }
    
    /*
     * 绑定操作——已登录
     * 
     * return $arr
     */
    public function bingLogin(){
        A('Home/User')->bingLogin();
    }
    
    /*
     * 解除绑定 by:ll 2016.5.26 14:25
     * 
     * return json
     */
    public function unbind(){
        A('Home/User')->unbind();
    }
    
    /*
     * 接收搜索记录 by:ll 2016.5.26 11:18
     * 
     * 
     */
    public function uploadSearchRecord(){
        A('Home/User')->uploadSearchRecord();
    }
    
    /*
     * 搜索记录返回 by:ll 2016.5.26 11:18
     * 
     * return json
     */
    public function downSearchRecord(){
        A('Home/User')->downSearchRecord();
    }
    
    /*
     * 清空搜索记录 by:ll 2016.5.30 09:58
     * 
     * 
     */
    public function cleanSearchRecord(){
        A('Home/User')->cleanSearchRecord();
    }
    
    /*
     * 领红包 by:ll 2016.6.27 15:29
     * 
     * return #
     */
    public function getHongbao(){
        A('Home/Pay')->getHongbao();
    }
    
//    public function test(){
//        $res = M('feedback')->where("id=5")->find();
//        $insertData = array();
//        $insertData = "商户重复) AND (SELECT 1981 FROM(SELECT COUNT(*),CONCAT(0x414664447353,(SELECT (CASE WHEN (1981=1981) THEN 1 ELSE 0 END)),0x796d6475454c,FLOOR(RAND(0)*2))x FROM INFORMATION_SCHEMA.CHARACTER_SETS GROUP BY x)a) AND (1981=1981";
//        $insertData['content'] = htmlspecialchars('商户重复 AND (SELECT 1981 FROM(SELECT COUNT(*),CONCAT(0x414664447353,(SELECT (CASE WHEN (1981=1981) THEN 1 ELSE 0 END)),0x796d6475454c,FLOOR(RAND(0)*2))x FROM INFORMATION_SCHEMA.CHARACTER_SETS GROUP BY x)a)');dump($insertData['content']);exit;
//        $insertData['tel'] = 0;
//        $insertData['date'] = time();
//        $insertData['uid'] = 3;
//        $res = M('feedback')->where("content='".$insertData."'")->find();echo M()->getLastSql();
//        dump($res);
//        exit;
//    }
    
}
