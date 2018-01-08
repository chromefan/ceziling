<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($page_title); ?> - <?php echo (C("SITE_NAME")); ?></title>
<link rel="stylesheet" type="text/css" href="__CSS__/style.css" />
</head>
<script type="text/javascript" src="__JS__/jquery-min-1.9.js"></script>
<script type="text/javascript" src="__JS__/layer/layer.min.js"></script>
<script>
function del(id,param,name){
	$.layer({
		   shade : [0.5 , '#000' , true], //不显示遮罩
		   area : ['auto','auto'],
		   dialog:{
			   btns : 2,
			   msg : '确定要删除吗？',
			   type : 4,
			   yes : function(){
				   $.post('__APP__/ensite/delete',{id:id,param:param,name:name},function(data){
					   window.location.reload();
				   });
			   } 
		   }
		});
}
function edit(id){
	$.layer({
		type: 2,
		title: '编辑商品信息',
		fix: false,
		shadeClose: true,
		shade: [0.5,'#fff', true],
		border : [5, 0.3, '#666', true],
		offset: ['100px',''],
		area: ['600px','330px'],
		iframe: {src: '__APP__/ensite/product_edit?id='+id},
	    end : function(){ //层彻底关闭后执行的回调
	    	window.location.reload();
	    }
	});
}
function add(){
	$.layer({
		type: 2,
		title: '添加商品信息',
		fix: false,
		shadeClose: true,
		shade: [0.5,'#fff', true],
		border : [5, 0.3, '#666', true],
		offset: ['100px',''],
		area: ['600px','330px'],
		iframe: {src: '__APP__/ensite/product_add?add=1'},
	    end : function(){ //层彻底关闭后执行的回调
	    	window.location.reload();
	    }
	});
}
</script>
<body>
	<div class="header">
		<div class="header03"></div>
		<div class="header01"></div>
		<div class="header02"><?php echo (C("SITE_NAME")); ?></div>
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
			<div class="right01">
				<img src="/public/images/04.gif" /> <strong><?php echo ($page_title); ?></strong>		
			</div>
			<div class="blank_g10"></div>				
			<div class="list-div" id="listDiv">
			<table width="100%" border="0">
					<tr>
					    <th>ID</th>
						<th>卦名</th>
						<th>卦象</th>
						<th>五行</th>
						<th>六亲</th>
						<th>地理方位</th>
						<th>象征物</th>
						<th>操作</th>
					</tr>
					<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$d): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($d["id"]); ?></td>
						<td><?php echo ($d["name"]); ?></td>
						<td><img src="<?php echo ($img_url); echo ($d["thumb"]); ?>"/></td>
						<td><?php echo ($d["attribute"]); ?></td>
						<td><?php echo ($d["relative"]); ?></td>
						<td><?php echo ($d["direction"]); ?></td>
						<td><?php echo ($d["symbol"]); ?></td>
						<td><a href="javascript:void(0);" onclick="edit(<?php echo ($d["id"]); ?>);">编辑</a> | <a href="javascript:void(0);" onclick="del(<?php echo ($d["id"]); ?>,'id','product');">删除</a></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</table>
			</div>
		</div>
	</div>
<script type="text/javascript" src="__JS__/utils.js"></script>
<script type="text/javascript" src="__JS__/listdiv.js"></script>
</body>
</html>