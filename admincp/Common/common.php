<?php
/**
 * 调用服务
 *
 * @param unknown_type $name class name
 * @param unknown_type $params
 * @param unknown_type $type
 * @return unknown
 */
function Service($name, $params = array(), $type = 'Service') {
	$class = $name . 'Service';
	$classfile = LIB_PATH . $type . '/' . $class . '.class.php';
	if (file_exists ( $classfile )) {
		require_cache ( $classfile );
		return new $class ( $params );
	}
}

/**
 * 强制下载文件
 *
 * @param unknown_type $file
 *        	文件绝对路径
 * @param unknown_type $fileName
 *        	下载文件名
 */
function downloadFile($file, $fileName) {
	$filesize = filesize ( $file );
	$fileName = iconv ( 'UTF-8', 'GBK', $fileName );
	
	header ( "Pragma: public" );
	header ( "Expires: 0" );
	header ( 'Cache-Control: public, must-revalidate, max-age=0' );
	header ( 'Content-Type: application/force-download' );
	header ( 'Content-Type: text/html; charset=gbk' );
	header ( 'Content-Disposition: attachment; filename="' . $fileName . '"' );
	header ( "Content-Transfer-Encoding: binary" );
	header ( "Content-Length: {$filesize}" );
	ob_clean ();
	flush ();
	readfile ( $file );
	exit ();
}

/**
 * 生成GUID
 *
 * @return unknown
 */
function create_guid() {
	return md5 ( uniqid ( mt_rand () . time (), true ) );
}

/**
 * 返回一个JSON格式的数据
 *
 * @access public
 * @param string $content        	
 * @param integer $error        	
 * @param string $message        	
 * @param array $append        	
 * @return void
 */
function make_json_response($content = '', $error = "0", $message = '', $append = array()) {
	$res = array (
			'error' => $error,
			'message' => $message,
			'content' => $content 
	);
	if (! empty ( $append )) {
		foreach ( $append as $key => $val ) {
			$res [$key] = $val;
		}
	}
	
	$val = json_encode ( $res );
	
	exit ( $val );
}
/**
 * 生成JSON格式结果
 *
 * @access public
 * @param        	
 *
 * @return void
 */
function make_json_result($content = '', $message = '', $append = array()) {
	make_json_response ( $content, 0, $message, $append );
}

/**
 * 创建一个JSON格式的错误信息
 *
 * @access public
 * @param string $msg        	
 * @return void
 */
function make_json_error($msg) {
	make_json_response ( '', 1, $msg );
}
/**
 * 解析TAG字符串 返回数组
 *
 * @param string $tags_string        	
 * @return array
 */
function parseTags($tags_string) {
	$tags_string = trim ( $tags_string );
	
	if (empty ( $tags_string ))
		return false;
	
	$tags_string = str_replace ( '，', ',', $tags_string );
	$tags_string = str_replace ( '　', ' ', $tags_string );
	$tags_array = preg_split ( '/[,]+/', $tags_string );
	
	return array_unique ( $tags_array );
}

/**
 * 格式化TAG数组 返回字符串
 *
 * @param array $tags_array        	
 * @return string
 */
function formatTags($tags_array) {
	if (! is_array ( $tags_array ))
		return false;
	
	$tags_string = implode ( ',', $tags_array );
	
	return $tags_string;
}

/**
 * 用,分割数组
 *
 * @param array $array        	
 */
function simplode($array) {
	return "'" . implode ( "','", $array ) . "'";
}

/**
 * 检查用户名是否符合规定
 *
 * @param STRING $username
 *        	要检查的用户名
 * @return TRUE or FALSE
 */
function is_username($username) {
	$strlen = strlen ( $username );
	if (is_badword ( $username ) || ! preg_match ( "/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/", $username )) {
		return false;
	} elseif (20 < $strlen || $strlen < 2) {
		return false;
	}
	return true;
}
// 检查Email地址是否合法
function isValidEmail($email) {

	return preg_match ( "/[_a-zA-Z\d\-\.]+@[_a-zA-Z\d\-]+(\.[_a-zA-Z\d\-]+)+$/i", $email ) !== 0;
}

/**
 * 检测输入中是否含有错误字符
 *
 * @param char $string
 *        	要检查的字符串名称
 * @return TRUE or FALSE
 */
function is_badword($string) {
	$badwords = array (
			"\\",
			'&',
			' ',
			"'",
			'"',
			'/',
			'*',
			',',
			'<',
			'>',
			"\r",
			"\t",
			"\n",
			"#" 
	);
	foreach ( $badwords as $value ) {
		if (strpos ( $string, $value ) !== FALSE) {
			return TRUE;
		}
	}
	return FALSE;
}

/**
 * 检查密码长度是否符合规定
 *
 * @param STRING $password        	
 * @return TRUE or FALSE
 */
function is_password($password) {
	$strlen = strlen ( $password );
	if ($strlen >= 6 && $strlen <= 20)
		return true;
	return false;
}
/**
 * 检查管理员密码合法性
 * 
 * @param string $password
 *        	密码
 */
function checkpasswd($password) {
	if (! is_password ( $password )) {
		return false;
	}
	return true;
}

/**
 * 输出消息
 *
 * @param unknown_type $msg        	
 * @param unknown_type $gourl        	
 * @param unknown_type $target        	
 * @param unknown_type $exit        	
 */
function showmassage($msg, $gourl = 0, $target = '', $exit = 1) {
	header ( "Content-type:text/html;charset=utf-8" );
	$js = "<script language='javascript'>alert('$msg');";
	$js .= empty ( $gourl ) ? "history.back(-1)" : "{$target}location.href='$gourl'";
	$js .= "</script>";
	echo $js;
	if ($exit) {
		exit ();
	}
}
/**
 * escape mysql query string
 *
 * @param unknown_type $string        	
 * @return unknown
 */
function es($string) {
	return mysql_escape_string ( $string );
}

/**
 * 获取gpc某个变量值
 *
 * @param unknown_type $k        	
 * @param unknown_type $type        	
 * @return unknown
 */
function getgpc($k, $type = 'P') {
	$type = strtoupper ( $type );
	switch ($type) {
		case 'G' :
			$var = &$_GET;
			break;
		case 'P' :
			$var = &$_POST;
			break;
		case 'C' :
			$var = &$_COOKIE;
			break;
		case 'R' :
			$var = &$_REQUEST;
			break;
		default :
			if (isset ( $_GET [$k] )) {
				$var = &$_GET;
			} else {
				$var = &$_POST;
			}
			break;
	}
	
	return isset ( $var [$k] ) ? $var [$k] : 0;
}

/**
 * Author:Zero
 * 1.上传文件类型错误
 * 2.无法创建目录
 * 3.上传失败
 */
function _uploadfile($filename, $tmpfile, $uploadroot = '', $is_new_name = true) {
	$extension = strtolower ( substr ( strrchr ( $filename, "." ), 1 ) );
	if (! in_array ( $extension, C ( 'UPLOAD_TYPE' ) )) {
		exit ( '1' ); // 上传文件类型错误
	}
	
	if ($uploadroot == '')
		$uploadroot = ROOT_PATH . '/public/data/temp/';
	
	$uploadpath = $uploadroot . date ( "Ym" ) . "/";
	
	if ($is_new_name) {
		$filename = time () . str_pad ( mt_rand ( 1, 9999 ), 4, '0', STR_PAD_LEFT ) . '.' . $extension;
	}
	
	$attachpath = $uploadpath . $filename;
	;
	
	if (! is_dir ( $uploadroot ))
		@mkdir ( $uploadroot, 0777 ) or die ( "2" );
	if (! is_dir ( $uploadpath ))
		@mkdir ( $uploadpath, 0777 ) or die ( "2" );
	if (@is_uploaded_file ( $tmpfile )) {
		if (! @move_uploaded_file ( $tmpfile, $attachpath )) {
			@unlink ( $tmpfile ); // 删除临时文件
			exit ( '3' );
		}
	}
	return $filename;
}
/**
 * 生成指定目录
 *
 * @param unknown_type $dir        	
 * @return unknown
 */
function loopMakeDir($dir) {
	$dir_arr = explode ( '/', $dir );
	$n = count ( $dir_arr );
	for($i = 0; $i < $n; $i ++) {
		$new_dir .= $dir_arr [$i] . '/';
		if (! is_dir ( $new_dir ))
			@mkdir ( $new_dir, 0777 );
	}
	
	return 1;
}

/**
 * 转换为安全的纯文本
 *
 * @param string $text        	
 * @param boolean $parse_br
 *        	是否转换换行符
 * @param int $quote_style
 *        	ENT_NOQUOTES:(默认)不过滤单引号和双引号 ENT_QUOTES:过滤单引号和双引号 ENT_COMPAT:过滤双引号,而不过滤单引号
 * @return string null null:参数错误
 */
function t($text, $parse_br = false, $quote_style = ENT_NOQUOTES) {
	if (is_numeric ( $text ))
		$text = ( string ) $text;
	
	if (! is_string ( $text ))
		return null;
	
	if (! $parse_br) {
		$text = str_replace ( array (
				"\r",
				"\n",
				"\t" 
		), ' ', $text );
	} else {
		$text = nl2br ( $text );
	}
	
	// $text = stripslashes($text);
	$text = htmlspecialchars ( $text, $quote_style, 'UTF-8' );
	
	return $text;
}

/**
 * 截取定长字符串（UTF-8）
 *
 * @param unknown_type $sourcestr
 *        	源字符串
 * @param unknown_type $cutlength
 *        	截取长度，字节数
 * @return unknown
 */
function cut_str($sourcestr, $cutlength) {
	$returnstr = '';
	$i = 0;
	$str_length = strlen ( $sourcestr ); // 字符串的字节数
	while ( $i <= $cutlength ) {
		$temp_str = substr ( $sourcestr, $i, 1 );
		$ascnum = Ord ( $temp_str ); // 得到字符串中第$i位字符的ascii码
		if ($ascnum >= 224) 		// 如果ASCII位高于224，
		{
			$returnstr = $returnstr . substr ( $sourcestr, $i, 3 ); // 根据UTF-8编码规范，将3个连续的字符计为单个字符
			$i = $i + 3; // 实际Byte计为3
		} elseif ($ascnum >= 192) 		// 如果ASCII位高于192，
		{
			$returnstr = $returnstr . substr ( $sourcestr, $i, 2 ); // 根据UTF-8编码规范，将2个连续的字符计为单个字符
			$i = $i + 2; // 实际Byte计为2
		} elseif ($ascnum >= 65 && $ascnum <= 90) 		// 如果是大写字母，
		{
			$returnstr = $returnstr . substr ( $sourcestr, $i, 1 );
			$i = $i + 1; // 实际的Byte数仍计1个
		} else 		// 其他情况下，包括小写字母和半角标点符号，
		{
			$returnstr = $returnstr . substr ( $sourcestr, $i, 1 );
			$i = $i + 1; // 实际的Byte数计1个
		}
	}
	return $returnstr;
}

/**
 * 创建像这样的查询: "IN('a','b')";
 *
 * @access public
 * @param mix $item_list
 *        	列表数组或字符串
 * @param string $field_name
 *        	字段名称
 * @author Xuan Yan
 *        
 * @return void
 */
function db_create_in($item_list, $field_name = '') {
	if (empty ( $item_list )) {
		return $field_name . " IN ('') ";
	} else {
		if (! is_array ( $item_list )) {
			$item_list = explode ( ',', $item_list );
		}
		$item_list = array_unique ( $item_list );
		$item_list_tmp = '';
		foreach ( $item_list as $item ) {
			if ($item !== '') {
				$item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
			}
		}
		if (empty ( $item_list_tmp )) {
			return $field_name . " IN ('') ";
		} else {
			return $field_name . ' IN (' . $item_list_tmp . ') ';
		}
	}
}
// 加密函数
function jiami($txt, $key = null) {
	if (empty ( $key ))
		$key = C ( 'SECURE_CODE' );
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=_";
	$nh = rand ( 0, 64 );
	$ch = $chars [$nh];
	$mdKey = md5 ( $key . $ch );
	$mdKey = substr ( $mdKey, $nh % 8, $nh % 8 + 7 );
	$txt = base64_encode ( $txt );
	$tmp = '';
	$i = 0;
	$j = 0;
	$k = 0;
	for($i = 0; $i < strlen ( $txt ); $i ++) {
		$k = $k == strlen ( $mdKey ) ? 0 : $k;
		$j = ($nh + strpos ( $chars, $txt [$i] ) + ord ( $mdKey [$k ++] )) % 64;
		$tmp .= $chars [$j];
	}
	return $ch . $tmp;
}

// 解密函数
function jiemi($txt, $key = null) {
	if (empty ( $key ))
		$key = C ( 'SECURE_CODE' );
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=_";
	$ch = $txt [0];
	$nh = strpos ( $chars, $ch );
	$mdKey = md5 ( $key . $ch );
	$mdKey = substr ( $mdKey, $nh % 8, $nh % 8 + 7 );
	$txt = substr ( $txt, 1 );
	$tmp = '';
	$i = 0;
	$j = 0;
	$k = 0;
	for($i = 0; $i < strlen ( $txt ); $i ++) {
		$k = $k == strlen ( $mdKey ) ? 0 : $k;
		$j = strpos ( $chars, $txt [$i] ) - $nh - ord ( $mdKey [$k ++] );
		while ( $j < 0 )
			$j += 64;
		$tmp .= $chars [$j];
	}
	return base64_decode ( $tmp );
}
// 字符串解密加密
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4; // 随机密钥长度 取值 0-32;
	                  // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
	                  // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
	                  // 当此值为 0 时，则不产生随机密钥
	
	$key = md5 ( $key ? $key : UC_KEY );
	$keya = md5 ( substr ( $key, 0, 16 ) );
	$keyb = md5 ( substr ( $key, 16, 16 ) );
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr ( $string, 0, $ckey_length ) : substr ( md5 ( microtime () ), - $ckey_length )) : '';
	
	$cryptkey = $keya . md5 ( $keya . $keyc );
	$key_length = strlen ( $cryptkey );
	
	$string = $operation == 'DECODE' ? base64_decode ( substr ( $string, $ckey_length ) ) : sprintf ( '%010d', $expiry ? $expiry + time () : 0 ) . substr ( md5 ( $string . $keyb ), 0, 16 ) . $string;
	$string_length = strlen ( $string );
	
	$result = '';
	$box = range ( 0, 255 );
	
	$rndkey = array ();
	for($i = 0; $i <= 255; $i ++) {
		$rndkey [$i] = ord ( $cryptkey [$i % $key_length] );
	}
	for($j = $i = 0; $i < 256; $i ++) {
		$j = ($j + $box [$i] + $rndkey [$i]) % 256;
		$tmp = $box [$i];
		$box [$i] = $box [$j];
		$box [$j] = $tmp;
	}
	
	for($a = $j = $i = 0; $i < $string_length; $i ++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box [$a]) % 256;
		$tmp = $box [$a];
		$box [$a] = $box [$j];
		$box [$j] = $tmp;
		$result .= chr ( ord ( $string [$i] ) ^ ($box [($box [$a] + $box [$j]) % 256]) );
	}
	
	if ($operation == 'DECODE') {
		if ((substr ( $result, 0, 10 ) == 0 || substr ( $result, 0, 10 ) - time () > 0) && substr ( $result, 10, 16 ) == substr ( md5 ( substr ( $result, 26 ) . $keyb ), 0, 16 )) {
			return substr ( $result, 26 );
		} else {
			return '';
		}
	} else {
		return $keyc . str_replace ( '=', '', base64_encode ( $result ) );
	}
}