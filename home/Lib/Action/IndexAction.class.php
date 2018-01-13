<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends BaseAction {
	
    public function index(){
		if(isMobile()){
			redirect('/cezi/');
		}
		$date['date']=date('Y年m月d日 H');
		$date['lunar']=get_lunar()." ".shichen_name(shichen());
		$this->assign('date',$date);
		$this->display();
    }
    
    public function nopage(){
    	//处理生成HTML
    	$title="Not Found | ".L('site_name');
    	$this->assign('title',$title);
    	$this->assign('waitSecond',3);
    	$this->assign ( 'jumpUrl', $this->base_url );
    	$path=SITE_PATH;
    	$this->buildHtml("404",$path."/", '404');
    	echo 'ok';
    }
	public function test(){
		$d=date('c');
		var_dump($d);
		//$ch='http://www.ceziling.com/cezi/get_result?csn=00050080003';
		//get_QRcode($ch);
	}
}