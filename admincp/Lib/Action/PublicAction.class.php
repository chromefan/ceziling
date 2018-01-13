<?php
class PublicAction extends Action {

	public function index()
	{
		$this -> login();
	}

	public function login() {
		if (service ( 'Passport' )->isLogged ()) {
			redirect ( "/" );
			exit ();
		}
		$this->assign('page_title', "内容发布系统");
		$this->display ();
	}
	// 登录
	public function doLogin() {
		$userUsername = t($_POST ["username"]);
		$userPassword = $_POST ["password"];
		
		if (empty ( $userUsername)) {
			showmassage ( '帐号错误！' );
		} elseif (empty ( $_POST ['password'] )) {
			showmassage ( '密码必须！' );
		} elseif ($_SESSION ['verify'] != md5 ( $_POST ['verify'] )) {
			showmassage ( '验证码错误！' );
		}
		// 生成认证条件
		$user=service('Passport')->loginLocal($userUsername,$userPassword,true);
		// 使用用户名、密码和状态的方式进行认证
		if (false === $user) {
			showmassage ( '用户名或者密码错误！' );
		} 
		$last ['lastlogintime'] = time ();
		$last ['lastloginip'] = get_client_ip ();
		$userDao=D('User');
		$userDao->where ( "uid=" . $user ['uid'] )->save ( $last );
		if ($user ['roleid'] == 1) {
			// 管理员不受权限控制影响
			$_SESSION ['administrator'] = true;
		} else {
			$_SESSION ['administrator'] = false;
		}

		$res = $userDao->query ( "select b.rolename from cz_admin_user as a left join cz_admin_role as b on a.roleid=b.id where a.uid={$user['uid']} limit 1" );
		if ($res) {
			$userinfo ['rolename'] = $res [0] ['rolename'];
		}
		$userinfo['username']=$user['username'];
		$userinfo['realname']=$user['realname'];
		$userinfo['roleid']=$user['roleid'];
		cookie('userinfo',serialize($userinfo));
		//生成菜单缓存
		A('Base')->setMenu();
		redirect ( "/");
	}

	// 注销退出
	public function logout() {
		service('Passport')->logoutLocal();
		redirect ( "/public/login" );
	}

	// 验证码
	public function verify() {
		import ( 'ORG.Util.Image' );
		Image::buildImageVerify ();
	}

	//上传偏僻字图片
	public function upload()
	{
		$basename = C("UPLOAD_POSTS")."font/".date("Ym")."/";
		loopMakeDir(ROOT_PATH.$basename);

		$filename = time().rand(1,1000).".png";

		$re = file_put_contents(ROOT_PATH.$basename.$filename, file_get_contents("php://input", 'r'));


		echo SITE_URL . $basename.$filename;
    }
    public function add_admin() {
    	$add_data ['username'] = 'luohj';
    	$password = '123456';
    	$add_data ['password'] = md5 ( C ( 'SECURE_CODE' ) . md5 ( $password ) );
    	$id = D ( 'User' )->add ( $add_data );
    	var_dump ( $id );
    	var_dump ( D ( 'User' )->getLastSql () );
    }
    
    public function _empty()
	{
		die('403 Forbidden');
	}
}