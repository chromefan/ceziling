<?php
/**
 * 
 * @author luohj
 *
 */
 import("ORG.Util.Page");// 导入分页类
class ContentAction extends BaseAction {

    public function index(){

        $this -> display();
    }

    //八卦
    public function egua(){
    	$data=M('e_gua')->select();
    	$this->assign('data',$data);
    	$this->assign('page_title','八卦管理');
    	$this->display();
    }
    //六十四卦
    public function sgua(){
    	$data=M('s_gua')->select();
    	$this->assign('data',$data);
    	$this->assign('page_title','六十四卦管理');
    	$this->display();
    }
    //六十四卦
    public function sgua_edit(){
    	if (intval($_POST['id'])>0) {
    		$add_data=$this->get_change_post();
    		$save_id=M('s_gua')->save($add_data);
    		if ($save_id>0) {
    			echo "更新成功";
    		}else{
    			echo "更新失败";
    		}
    		exit;
    	}
		$id=intval($_GET['id']);
    	if ($id>0) {
    		$map['id']=$id;
    		$data=M('s_gua')->where($map)->find();
    	}
		$data['sgua']=self::get_gua_name(0,1);
    	$this->assign('data',$data);
    	$this->assign('page_title','六十四卦编辑');
    	$this->display();
    }
    //爻辞
    public function yaoci(){
		$page_num=20;
		$m=M('dongyao');
		$p=intval($_GET['p']);
    	$data=$m->order('id desc')->page($p.','.$page_num)->select();
		$count=$m->count();
		$Page= new Page($count,$page_num);
    	foreach ($data as $k => $v) {
    		$data[$k]['s_gua_name']=self::get_gua_name($v['s_gua_id']);
    		$data[$k]['b_gua_name']=self::get_gua_name($v['b_gua_id']);
    	}
		$show       = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
    	$this->assign('data',$data);
    	$this->assign('page_title','动爻管理');
    	$this->display();
    }
    public function yaoci_edit(){
    	if (intval($_POST['id'])>0) {
    		$add_data=get_post_data();
    		$save_id=M('dongyao')->save($add_data);
    		if ($save_id>0) {
    			echo "更新成功";
    		}else{
    			echo "更新失败";
    		}
    		exit;
    	}
    	$id=intval($_GET['id']);
    	if ($id>0) {
    		$map['id']=$id;
    		$data['dongyao']=M('dongyao')->where($map)->find();
    	}
    	$data['sgua']=self::get_gua_name(0,1);
    	$this->assign('data',$data);
    	$this->display();
    }
    public function yaoci_add(){
    	if (intval($_GET['add'])==1) {
    		$add_data=get_post_data();
    		$add_id=M('dongyao')->add($add_data);
    		if ($add_id>0) {
    			echo "添加成功";
    		}else{
    			echo "添加失败";
    		}
    		exit;
    	}
    	$data=self::get_gua_name(0,1);
    	$this->assign('data',$data);
    	$this->display();
    }    
    private static  function get_gua_name($id=0,$all=0){
    	if ($id==0 && $all==1) {
    		$res=M('s_gua')->field('id,fullname')->order('up_id asc,down_id asc')->select();
    		return $res;
    	}
    	$map['id']=$id;
    	$res=M('s_gua')->where($map)->find();
    	if ($res) {
    		return $res['fullname'];
    	}
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
	//仅获取改变的POST
	private function get_change_post(){
		$data=get_post_data();
		if(!$data){
			return false;
		}
		$input=array();
		$org=array();
		foreach($data as $k=>$v){
			if(!strpos($k,'_org')){
				$input[$k]=$v;
			}else{
				$org[$k]=$v;
			}
		}
		$result=array();
		$i=0;
		foreach($input as $k=>$v){
			$org_key=$k.'_org';
			if(isset($org[$org_key])){
				if(strcmp($v,$org[$org_key]) != 0){
					$result[$k]=$v;
					$i++;
					continue;
				}
			}else{
				$result[$k]=$v;
			}
		}
		if($i==0){
			return false;
		}
		return $result;
	}
}
