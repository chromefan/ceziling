<?php
if (!defined('SITE_PATH'))	exit();
return array
	(
		// 数据库常用配置
		'DB_TYPE'			=>	'mysql',			// 数据库类型
		'DB_HOST'		=>	'127.0.0.1',			// 数据库服务器地址
		'DB_NAME'		=>	'cezi',			// 数据库名
		'DB_USER'			=>	'root',		// 数据库用户名
		'DB_PWD'			=>	'root',		// 数据库密码
		'DB_PORT'			=>	3306,				// 数据库端口
		'DB_PREFIX'			=>	'cz_',		// 数据库表前缀（因为漫游的原因，数据库表前缀必须写在本文件）
		'DB_CHARSET'		=>	'utf8',				// 数据库编码
		'DB_FIELDS_CACHE'	=>	true,				// 启用字段缓存

			
		'SITE_NAME'=>'测字灵后台管理',
			
		'COOKIE_DOMAIN'	=>	'.ceziling.com',	//cookie域,请替换成你自己的域名 以.开头
		'COOKIE_PREFIX' =>'chinesegeo_',
		'COOKIE_EXPIRE'=>'31536000',
		'COOKIE_PATH'=>'/',
		//Cookie加密密码
		'SECURE_CODE'       =>  'ceziling',
		'COOKIE_NAME'=>'admin_auth',
		// 是否开启URL Rewrite
		'URL_ROUTER_ON'		=> true,
		'SHOW_ERROR_MSG' =>true,
		'BASE_URL'     =>'http://test.ceziling.com',
		'IMG_URL'   =>'http://test.ceziling.com/public',
		//定义错误页面
		'TMPL_ACTION_SUCCESS'=>'Public:success',
		'TMPL_ACTION_ERROR'=>'Public:error',
		//'ERROR_PAGE'=>'./Tpl/Public/error.html',
		//'TMPL_EXCEPTION_FILE'=>'./404.html',
		//'EXCEPTION_TMPL_FILE' => './Tpl/Public/error.html',
		'JS_VERSION'=>'1.0'
);

?>
