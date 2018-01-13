<?php
// 测字
import ( 'ORG.Util.Bihua' );
class CeziAction extends BaseAction {

	//首页
	public function index() {
		// echo time();
		if(isMobile()){
			$act_name='m_index';
		}else{
			$act_name='index';
		}
		$lunar=get_lunar();
		$this->assign('lunar',$lunar);
		$this->display ($act_name);
	}
	public function result(){
		$result=$this->do_result();
		$this->assign('result',$result);
		$this->display();
	}
	// 测算提交
	private function do_result() {
		if (!checkReferer()) {
			$this->error(L('request_error'));
		}
		$data ['sex'] = intval( $_POST ['sex'] );
		if ($data['sex']==0) {
			$this->error(L('input_error'),'/cezi');
		}
		$data ['birthday'] = strtotime ( $_POST ['birthday'] );
		$data ['t1'] = t ( $_POST ['t1'] );
		$data ['t2'] = t ( $_POST ['t2'] );
		$data ['problem_text'] = t ( $_POST ['problem'] );
		$data ['problem_type'] = intval($_POST['problem_type']);
		if (!is_hanzi($data['t1']) || !is_hanzi($data['t2'])) {
			$this->error(L('word_error'),'/cezi');
		}
		if (strlen ( $data ['t1'] ) < 3 || strlen ( $data ['t2'] ) < 3 || strlen ( $data ['t1'] . $data ['t2'] ) > 6) {
			$this->error ( L ( 'word_num' ) );
		}
		$text = new bihua ();
		$data ['t1_len'] = $text->find ( $data ['t1'] );
		$data ['t2_len'] = $text->find ( $data ['t2'] );
		if (empty($data['t1_len']) || empty($data['t2_len'])) {
			$this->error(L('word_error'),'/cezi');
		}
		//起卦核心算法
		$data ['down_gua'] = $data ['t1_len'] % 8;
		$data ['up_gua'] = $data ['t2_len'] % 8;
		$data ['down_gua'] = $data ['down_gua'] == 0 ? 8 : $data ['down_gua'];
		$data ['up_gua'] = $data ['up_gua'] == 0 ? 8 : $data ['up_gua'];
		$data ['shichen'] =  shichen();
		$data ['dongyao'] = ($data ['up_gua'] + $data ['down_gua']+$data['shichen']) % 6;
		$data ['dongyao'] = $data ['dongyao'] == 0 ? 6 : $data ['dongyao'];
		$data ['ctime'] = time ();
		$data ['ip'] = get_client_ip ();
		$data ['client_type']=getBrowser();
		//记录用户提交
		$fid=M('user_post')->add($data);
		$sn=$this->get_ce_sn($fid);
		M('user_post')->where('fid='.$fid)->setField('ce_sn',$sn);
		//所得原卦
		$s_gua=M('s_gua')->where("`up_id`={$data['up_gua']} and `down_id`={$data['down_gua']}")->find();
		$h_gua=M('s_gua')->field('id,name,fullname')->where("`id`={$s_gua['h_gua_id']}")->find();
		$dongyao=M('dongyao')->where("`s_gua_id`={$s_gua['id']} and `position`={$data['dongyao']}")->find();
		$b_gua=M('s_gua')->field('id,name,fullname')->where("`id`={$dongyao['b_gua_id']}")->find();

		if (!$dongyao || !$b_gua) {
			$this->error(L('nothing'),'/cezi');
		}
		//输出结果
		$user_data['sex']=$data['sex'];
		$user_data['shichen']=shichen_name($data['shichen']);
		$user_data['birthday']=date('Y年m月d日',$data ['birthday']);
		$user_data['cesuan_time']=date('Y年m月d日 H:i:s',$data['ctime']);
		$user_data['word']=$data ['t1'] ." ".$data ['t2'];
		$user_data['problem_text']=$data ['problem_text'];
		$user_data['problem_type']=self::get_problem_type($data['problem_type']);
		$user_data['ce_sn']=$sn;
		$result=array('s_gua'=>$s_gua,'h_gua'=>$h_gua,'b_gua'=>$b_gua,'dongyao'=>$dongyao,'user_data'=>$user_data);
		//记录日志
		$logs['fid']=$fid;
		$logs['dongyao_id']=$dongyao['id'];
		$logs['result']=serialize($result);
		$logs['ctime']=time();
		M('result')->add($logs);
		if(isMobile()){
			$act_name='qr_result';
		}else{
			$act_name='get_result';
		}
		redirect("/cezi/{$act_name}?csn=$sn");
		return $result;
	}
	public function get_result($id){
		$sn = $_GET['csn'];
		if(empty($sn)){
			$this->error(L('nothing'),$this->base_url);
		}
		$map['ce_sn']=t($sn);
		$res = M('user_post')->field('fid')->where($map)->find();
		if(empty($res['fid'])){
			$this->error(L('nothing'),$this->base_url);
		}
		$map=array();
		$map['fid']=$res['fid'];
		$res = M('result')->field('result')->where($map)->find();
		if(empty($res['result'])){
			$this->error(L('nothing'),$this->base_url);
		}
		$result=unserialize($res['result']);
		$this->assign('result',$result);
		$this->display('result');
			
	}
	public function qr_result($id){
		$sn = $_GET['csn'];
		if(empty($sn)){
			$this->error(L('nothing'),$this->base_url);
		}
		$map['ce_sn']=t($sn);
		$res = M('user_post')->field('fid')->where($map)->find();
		if(empty($res['fid'])){
			$this->error(L('nothing'),$this->base_url);
		}
		$map=array();
		$map['fid']=$res['fid'];
		$res = M('result')->field('result')->where($map)->find();
		if(empty($res['result'])){
			$this->error(L('nothing'),$this->base_url);
		}
		$result=unserialize($res['result']);
		$this->assign('result',$result);
		$this->display();
	}
	private static  function get_problem_type($type_id){
		$type=array(1=>'事业',2=>'爱情',3=>'健康',4=>'杂事');
		return $type[$type_id];
	}
	//生成测算单号号
	private function get_ce_sn($id) {
		$pre = sprintf('%02d', $id / 14000000);        // 每1400万的前缀
		$tempcode = sprintf('%09d', sin(($id % 14000000 + 1) / 10000000.0) * 123456789);    // 这里乘以 123456789 一是一看就知道是9位长度，二则是产生的数字比较乱便于隐蔽
		$seq = '371482506';        // 这里定义 0-8 九个数字用于打乱得到的code
		$code = '';
		for ($i = 0; $i < 9; $i++) $code .= $tempcode[ $seq[$i] ];
		return $pre.$code;
	}
	public function save_email(){
		if(!checkReferer()){
			$this->error(L('request_error'));
		}
		$ce_sn = t($_POST['ce_sn']);
		$email = t($_POST['email']);
		if(!isValidEmail($email)){
			$this->error(1);
		}
		$fid = M('user_post')->where("`ce_sn`='".$ce_sn."'")->getField('fid');
		if($fid){
			M('user_post')->where('`fid`='.$fid)->setField('email',$email);
			$this->success();
		}else{
			$this->error(2);
		}
		
	}
}