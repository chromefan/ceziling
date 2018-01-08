<?php
/**
 * 
 * @author luohj
 *
 */
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
    //爻辞
    public function yaoci(){
    	$data=M('dongyao')->order('id desc')->select();
    	foreach ($data as $k => $v) {
    		$data[$k]['s_gua_name']=self::get_gua_name($v['s_gua_id']);
    		$data[$k]['b_gua_name']=self::get_gua_name($v['b_gua_id']);
    	}
    	$this->assign('data',$data);
    	$this->assign('page_title','动爻管理');
    	$this->display();
    }
    public function yaoci_edit(){
    	if (intval($_POST['id'])>0) {
    		$add_data['id']=intval($_POST['id']);
    		$add_data['name']=t($_POST['name']);
    		$add_data['position']=intval($_POST['position']);
    		$add_data['s_gua_id']=intval($_POST['s_gua_id']);
    		$add_data['b_gua_id']=intval($_POST['b_gua_id']);
    		$add_data['yaoci']=t($_POST['yaoci']);
    		$add_data['shaoci']=t($_POST['shaoci']);
    		$add_data['tiyong']=t($_POST['tiyong']);
    		$add_data['wuxing']=t($_POST['wuxing']);
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
    		$add_data['name']=t($_POST['name']);
    		$add_data['position']=intval($_POST['position']);
    		$add_data['s_gua_id']=intval($_POST['s_gua_id']);
    		$add_data['b_gua_id']=intval($_POST['b_gua_id']);
    		$add_data['yaoci']=t($_POST['yaoci']);
    		$add_data['shaoci']=t($_POST['shaoci']);
    		$add_data['tiyong']=t($_POST['tiyong']);
    		$add_data['wuxing']=t($_POST['wuxing']);
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
}
