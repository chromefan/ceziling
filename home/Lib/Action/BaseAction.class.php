<?php
date_default_timezone_set('Asia/Chongqing');
/**
 * 基类
* @author luohj
*
*/
class BaseAction extends Action {

	public  $base_url;
    public  $title;

	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		// 控制器初始化
		$this->base_url=C('BASE_URL');
		$this->assign('base_url',$this->base_url);
		$this->assign('img_url',C('IMG_URL'));
		$this->assign('site_name',L('site_name'));
		if(strtolower(MODULE_NAME)=='index'){
			$this->title=L('site_name');
		}else{
			$this->title=L(strtolower(MODULE_NAME)).'_'.L('site_name');
		}
		$this->assign('title',$this->title);
		$this->assign('menu',$this->setMenu(MODULE_NAME));
		//检测登录
		//$this->checkLogin();
		//$this->assign('uid',$this->uid);
		if (method_exists ( $this, '_init' )){
			$this->_init ();
		}
	}

	//生成静态HTML
	public function create($name){
		$path=SITE_PATH."/html";
		$this->assign('title',L('view_'.$name));
		$this->assign('act_name',$name);
		$this->buildHtml($name,$path."/", $name);
		@chmod($path."/{$name}.html", 0777);
		echo $this->base_url."/html/{$name}.html </br>";
	}
	//导航条
	public function setMenu($mod){
		$menu_name=array('index','cezi','meihua','sgua','case','about','contact');
		$menu=array();
		foreach ($menu_name as $k => $v) {
			if ($k<1) {
				$menu[$k]['url']=$this->base_url;
			}else{
				$menu[$k]['url']=$this->base_url."/".strtolower($v)."/";
			}
			$menu[$k]['name']=L($v);
			if ($v==strtolower($mod)) {
				$menu[$k]['class']='active';
			}
		}
		return $menu;
	}
	public function _empty(){
		redirect404();
	}

}
?>