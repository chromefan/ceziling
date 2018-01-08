<?php
if (!defined('SITE_PATH'))	exit();

return array
	(
		// 数据库常用配置
		'URL_MODEL'=>3,
		'DB_TYPE'			=>	'mysql',			// 数据库类型
		'DB_HOST'			=>	'127.0.0.1',			// 数据库服务器地址
		'DB_NAME'			=>	'cezi',			// 数据库名
		'DB_USER'			=>	'root',		// 数据库用户名
		'DB_PWD'			=>	'root',		// 数据库密码
		'DB_PORT'			=>	3306,				// 数据库端口
		'DB_PREFIX'			=>	'cz_',		// 数据库表前缀（因为漫游的原因，数据库表前缀必须写在本文件）
		'DB_CHARSET'		=>	'utf8',				// 数据库编码
		'DB_FIELDS_CACHE'	=>	true,				// 启用字段缓存

		'COOKIE_DOMAIN'	=>	'.ceziling.com',	//cookie域,请替换成你自己的域名 以.开头
		'COOKIE_PREFIX' =>'chinesegeo_',
		'COOKIE_EXPIRE'=>'31536000',
		'COOKIE_PATH'=>'/',
		//Cookie加密密码
		'SECURE_CODE'       =>  'ceziling',
		// 是否开启URL Rewrite
		'URL_ROUTER_ON'		=> true,
		'SHOW_ERROR_MSG' =>true,
		'BASE_URL'     =>'http://test.ceziling.com',
		'IMG_URL'   =>'http://www.ceziling.com',
		//定义错误页面
		'TMPL_ACTION_SUCCESS'=>'Public:success',
		'TMPL_ACTION_ERROR'=>'Public:error',
		//'ERROR_PAGE'=>'./Tpl/Public/error.html',
		'TMPL_EXCEPTION_FILE'=>'./404.html',
		//'EXCEPTION_TMPL_FILE' => './Tpl/Public/error.html',
		//设置语言匹配
		'LANG_SWITCH_ON' => true,
		'DEFAULT_LANG' => 'en-us', // 默认语言
		'LANG_AUTO_DETECT' => false, // 自动侦测语言
		'LANG_LIST'=>'en-us,zh-cn,zh-tw',//必须写可允许的语言列表
		'SCORE_RATE'=>500,
		//'UC_AVATAR_PATH'=>'/home/www/wwwroot/uc/data/avatar',
		//第三方登录网站
		//'BIND_TYPE'=>array('sina','qzone','tqq'),
		//'email'=>require_once SITE_PATH.'/home/email.inc.php',
		'TOKEN_ON'=>true,  // 是否开启令牌验证			
		'TOKEN_NAME'=>'__hash__',    // 令牌验证的表单隐藏字段名称			
		'TOKEN_TYPE'=>'md5',  //令牌哈希验证规则 默认为MD5
		'TOKEN_RESET'=>true,  //令牌验证出错后是否重置令牌 默认为true
		'TMPL_PARSE_STRING'  =>array(
					'__PUBLIC__' => '/home/static', // 更改默认的__PUBLIC__ 替换规则
			)
);

?>
