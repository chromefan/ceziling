<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo (C("SITE_NAME")); ?></title>
<link rel="stylesheet" type="text/css" href="__CSS__/style.css" />
</head>
<body>
<div class="header">
	<div class="header03"></div>
	<div class="header01"></div>
	<div class="header02"><?php echo (C("SITE_NAME")); ?> </div>
</div>
<script type="text/JavaScript">
<!--
var $$=function(id) {
    return document.getElementById(id);
}

var temp=0;
function show_menuC(){
    if (temp==0){
        document.getElementById('LeftBox').style.display='none';
        document.getElementById('RightBox').style.marginLeft='0';
        document.getElementById('Mobile').style.background='url(/public/images/center.gif)';
        temp=1;
    }
    else
    {
        document.getElementById('RightBox').style.marginLeft='222px';
        document.getElementById('LeftBox').style.display='block';
        document.getElementById('Mobile').style.background='url(/public/images/center0.gif)';
        temp=0;
    }
}
//-->
</script>
<div class="left" id="LeftBox">
	<div class="left01">
		<div class="left01_right"></div>
		<div class="left01_left"></div>
		<div class="left01_c"><?php if(($_COOKIE['cms_tested']) == "test"): ?><a href="__APP__/index/" style="color:red; font-weight:bold;">测试版</a><?php endif; ?> <?php echo ($user["rolename"]); ?>：<?php echo ($user["username"]); ?></div>
	</div>
	<?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><div class="left02">
		<div class="left02top">
			<div class="left02top_right"></div>
			<div class="left02top_left"></div>
			<div class="left02top_c"><?php echo ($m["pid"]["name"]); ?></div>
		</div>
	    <div class="left02down">
	    <?php if(is_array($m["sid"])): $i = 0; $__LIST__ = $m["sid"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$n): $mod = ($i % 2 );++$i;?><div class="left02down01"><a href="<?php echo ($n["url"]); ?>"><div id="<?php echo ($n["id"]); ?>" class="left02down01_img"></div><?php echo ($n["name"]); ?></a></div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div><?php endforeach; endif; else: echo "" ;endif; ?>
	<div class="left01">
		<div class="left03_right"></div>
		<div class="left01_left"></div>
		<div class="left03_c"><a href="__APP__/public/logout">安全退出</a></div>
	</div>
</div>
<div class="rrcc" id="RightBox">
	<div class="center" id="Mobile" onclick="show_menuC()"></div>
	<div class="right" id="li010">
		<div class="right01"><img src="/public/images/04.gif" /> <strong>系统信息</strong></div>
		<div class="list-div">
		<table cellspacing='1' cellpadding='3'>
		  <tr>
			<td width="20%">服务器操作系统：</td>
			<td width="30%"><?php echo ($sys_info["os"]); ?> (<?php echo ($sys_info["ip"]); ?>)</td>
			<td width="20%">Web 服务器：</td>
			<td width="30%"><?php echo ($sys_info["web_server"]); ?></td>
		  </tr>
		  <tr>
			<td>PHP 版本：</td>
			<td><?php echo ($sys_info["php_ver"]); ?></td>
			<td>Zlib 支持：</td>
			<td><?php echo ($sys_info["zlib"]); ?></td>
		  </tr>
		  <tr>
			<td>安全模式：</td>
			<td><?php echo ($sys_info["safe_mode"]); ?></td>
			<td>安全模式GID：</td>
			<td><?php echo ($sys_info["safe_mode_gid"]); ?></td>
		  </tr>
		  <tr>
			<td>Socket 支持：</td>
			<td><?php echo ($sys_info["socket"]); ?></td>
			<td>时区设置：</td>
			<td><?php echo ($sys_info["timezone"]); ?></td>
		  </tr>
		  <tr>
			<td>文件上传的最大大小：</td>
			<td><?php echo ($sys_info["max_filesize"]); ?></td>
			<td>cURL支持：</td>
			<td><?php echo ($sys_info["curl"]); ?></td>
		  </tr>
		  <tr>
			<td>数据库名称：</td>
			<td><?php echo ($sys_info["db_name"]); ?></td>
			<td></td>
			<td></td>
		  </tr>
		</table>
	</div>
	</div>
</div>
</body>
</html>