<?php
/**
 * 六十四卦
 * @author luohj
 *
 */
class SguaAction extends BaseAction {
	

	

	public function index(){
		$path=SITE_PATH;
		$file=$path.'/sgua_index.html';
		if(file_exists($file)){
			echo file_get_contents($file);
			exit;
		}
		$e_gua=M('e_gua')->select();
		foreach($e_gua as $i =>$v1){
			$result[$i]['egua']=$v1;
			foreach($e_gua as $j =>$v2){
				$map['up_id']=$v1['id'];
				$map['down_id']=$v2['id'];
				$result[$i]['sgua'][$j]=M('s_gua')->field('id,name,fullname')->where($map)->find();
			}
		}
		$this->assign('e_gua',$e_gua);
		$this->assign('result',$result);
		$content=$this->buildHtml("sgua_index",$path."/", "index");
		echo $content;
	}
	public function index2(){
		$path=SITE_PATH;
		$e_gua=M('e_gua')->select();
		foreach($e_gua as $i =>$v1){
			$result[$i]['egua']=$v1;
			foreach($e_gua as $j =>$v2){
				$map['up_id']=$v1['id'];
				$map['down_id']=$v2['id'];
				$result[$i]['sgua'][$j]=M('s_gua')->field('id,name,fullname')->where($map)->find();
			}
		}
		for($i=0;$i<8;$i++){
			for($j=0;$j<8;$j++){
					if($i == 0 && $j==0 ){
						$data[$i]['sgua'][$j]=$result[$i]['sgua'][$j];
					}elseif($i==7 && $j==7){
						$data[$i]['sgua'][$j]=$result[$i]['sgua'][$j];
					}else{
						$data[$i]['sgua'][$j]=$result[$j]['sgua'][$i];
					}
					$data[$i]['egua']=$result[$i]['egua'];
			}
		}
		$this->assign('e_gua',$e_gua);
		$this->assign('result',$data);
		$content=$this->buildHtml("sgua_index",$path."/", "index");
		echo $content;
	}
	public function view(){
		$sid = intval($_GET['sid']);
		if($sid==0){
			redirect404();
		}
		$sgua = M('s_gua')->where('`id`='.$sid)->find();
		if(!$sgua){
			redirect404();
		}
		$result['sgua']=$sgua;
		$result['hgua']=M('s_gua')->field('id,name,fullname')->where('id='.$sgua['h_gua_id'])->find();
		$result['dongyao']=M('dongyao')->where('`s_gua_id`='.$sgua['id'])->select();
		$title = $sgua['fullname'].'_'.$this->title;
		$this->assign('title',$title);
		$this->assign('result',$result);
		$this->display();
	}
	public function create(){
		$sid = intval($_GET['sid']);
		if($sid==0){
			redirect404();
		}
		$path=SITE_PATH;
		$data = M('s_gua')->select();
		foreach($data as $k =>$v){
			$sgua = $v;
			if(!$sgua){
				redirect404();
			}
			$result['sgua']=$sgua;
			$result['hgua']=M('s_gua')->field('id,name,fullname')->where('id='.$sgua['h_gua_id'])->find();
			$result['dongyao']=M('dongyao')->where('`s_gua_id`='.$sgua['id'])->select();
			$title = $sgua['fullname'].'_'.$this->title;
			$this->assign('title',$title);
			$this->assign('result',$result);
			$this->buildHtml("{$sgua['id']}",$path."/", "view");
			echo $k."\t";
		}
		echo "<br>done";
	}
	/*public function index() {
		$page_num = 10;
		$p = intval ( $_GET ['p'] ) == 0 ? 1 : intval ( $_GET ['p'] );
		$m = M ( 's_gua' );
		$count = $m->count ();
		$data = $m->page ( $p . ',' . $page_num )->select ();
		$Page = new Page ( $count, $page_num );
		$Page->setConfig('prev', '«');
		$Page->setConfig('next', '»');
		$Page->setConfig ('theme', '<li>%upPage%</li><li>%linkPage%</li><li>%downPage%</li>' );
		$show = $Page->show (); // 分页显示输出
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->assign ( 'data', $data );
		$this->display ();
	}*/
}
?>