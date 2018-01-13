<?php
/**
 * 定义空模块
 *
 */
class EmptyAction extends Action {
	
    public function index()
    {
    	redirect404();
    }
		
	public function _empty()
	{
		redirect404();
	}
	
	public function test()
	{
	//这里是测试代码		
	echo ACTION_NAME;
	}
}
?>