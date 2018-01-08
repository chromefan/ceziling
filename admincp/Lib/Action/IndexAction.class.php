<?php
class IndexAction extends BaseAction {

    public function index(){

        /* 系统信息 */
        $sys_info['os']            = PHP_OS;
        $sys_info['ip']            = $_SERVER['SERVER_ADDR'];
        $sys_info['web_server']    = $_SERVER['SERVER_SOFTWARE'];
        $sys_info['php_ver']       = PHP_VERSION;
        $sys_info['zlib']          = function_exists('gzclose') ? '是':'否';
        $sys_info['safe_mode']     = (boolean) ini_get('safe_mode') ?  '是':'否';
        $sys_info['safe_mode_gid'] = (boolean) ini_get('safe_mode_gid') ? '是':'否';
        $sys_info['timezone']      = function_exists("date_default_timezone_get") ? date_default_timezone_get() : '未设定';
        $sys_info['socket']        = function_exists('fsockopen') ? '是':'否';
        $sys_info['curl']        = function_exists('curl_version') ? '是':'否';
        $sys_info['db_name']        = C('db_name');

        /* 允许上传的最大文件大小 */
        $sys_info['max_filesize'] = ini_get('upload_max_filesize');

        $this -> assign('sys_info', $sys_info);
        $this -> display();
    }

    public function refresh()
    {
        $this -> display();
    }

    public function privilege()
    {
        //角色权限 1管理员 2内容运营 3广告运营 4编辑
        if ($_SESSION['userInfo']['roleid'] == 1) {
            $privilege = 1;
        }
        elseif($_SESSION['userInfo']['roleid'] == 3) {
            //内容运营
            $privilege = 2;
        }
        elseif ($_SESSION['userInfo']['roleid'] == 2) {
            //广告运营
            $privilege = 3;
        }
        elseif (in_array($_SESSION['userInfo']['roleid'], array(1,4))) {
            //内容编辑
            $privilege = 4;
        }
        else
        {
            $privilege = 0;
        }
    }

    //服务器配置
    public function phpinfo()
    {
        echo __URL__;
        phpinfo();
    }
    public function getdate()
    {
        $time = $_GET['time'];
        echo date('Y-m-d H:i:s', $time);
    }

    public function tested()
    {
        cookie('tested', 'test', 864000);
        $this -> success('切换成功');
    }

    public function normaled()
    {
        cookie('tested', null);
        $this -> success('切换成功');
    }
    public function testmem()
    {
        $m = MeM();
        $m -> set('testtest', 'test mem');
        echo $m -> get('testtest');
    }
}