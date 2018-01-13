<?php
/**
 * 
 * @author luohj
 *
 */
 import("ORG.Util.Page");// 导入分页类
class DataAction extends BaseAction {

    public function index(){

        $this -> display();
    }
	//用户测试
	public function user_result(){
		$m=M('user_post');
		$p=intval($_GET['p']);
		$page_num=50;
		$count=$m->count();
		$data=$m->order('fid desc')->page($p.','.$page_num)->select();
		$Page= new Page($count,$page_num);
		$show       = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
    	$this->assign('data',$data);
    	$this->assign('page_title','用户测算结果');
    	$this->display();
	}
    // 统一删除
    public function delete() {
    	$param = $_POST ['param'];
    	$map [$param] = intval ( $_POST ['id'] );
    	$table = t ( $_POST ['name'] );
    	if (empty ( $map [$param] ) || empty ( $table )) {
    		echo 0;
    	}
    	M ($table )->where ( $map )->delete ();
    	echo 1;
    }
}
