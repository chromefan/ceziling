<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title><?php echo ($page_title); ?> - <?php echo (C("SITE_NAME")); ?></title><link rel="stylesheet" type="text/css" href="__CSS__/style.css" /></head><script type="text/javascript" src="__JS__/jquery-min-1.9.js"></script><script type="text/javascript" src="__JS__/layer/layer.min.js"></script><script type="text/javascript" src="__JS__/va.js"></script><script>	function Submit(formname) {

		var formid = document.getElementById(formname);
		var isform = Validator.Validate(formid, 3);

		if (!isform) {
			return false;
		} else {
			formid.submit();
			return true;
		}
	}
</script><body><div class="list-div" id="listDiv"><form id="form1" name="form1" method="post" action="__APP__/content/yaoci_edit"><p>&nbsp;</p><table width="100%" border="0" style="text-align:left;"><tr><td width="15%">名称</td><td><label for="name"></label><input type="text" name="name"
						id="name"  datatype="Require"
						msg="请输入名称" placeholder="名称" value="<?php echo ($data["dongyao"]["name"]); ?>"/><span id="nameTip" style="color: red"></span></td></tr><tr><td>位置</td><td><label for="position"></label><input type="text" name="position"
						id="position"  datatype="Number"
						msg="请输入位置为数字" placeholder="位置" value="<?php echo ($data["dongyao"]["position"]); ?>"/><span id="positionTip" style="color: red"></span></td></tr><tr><td>本卦</td><td><select name="s_gua_id" id="cate"><?php if(is_array($data["sgua"])): $i = 0; $__LIST__ = $data["sgua"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i; if($c[id]==$data[dongyao][s_gua_id]){ ?><option value="<?php echo ($c["id"]); ?>" selected="true"><?php echo ($c["fullname"]); ?></option><?php }else{ ?><option value="<?php echo ($c["id"]); ?>"><?php echo ($c["fullname"]); ?></option><?php } endforeach; endif; else: echo "" ;endif; ?></select></td></tr><tr><td>变卦</td><td><select name="b_gua_id" id="cate"><?php if(is_array($data["sgua"])): $i = 0; $__LIST__ = $data["sgua"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i; if($c[id]==$data[dongyao][b_gua_id]){ ?><option value="<?php echo ($c["id"]); ?>" selected="true"><?php echo ($c["fullname"]); ?></option><?php }else{ ?><option value="<?php echo ($c["id"]); ?>"><?php echo ($c["fullname"]); ?></option><?php } endforeach; endif; else: echo "" ;endif; ?></select></td></tr><tr><td>爻辞</td><td><label for="yaoci"></label><textarea
						name="yaoci" id="yaoci" cols="30" rows="3"/><?php echo ($data["dongyao"]["yaoci"]); ?></textarea></td></tr><tr><td>邵辞</td><td><label for="shaoci"></label><textarea name="shaoci"
							id="shaoci" cols="45" rows="4"><?php echo ($data["dongyao"]["shaoci"]); ?></textarea></td></tr><tr><td>体用</td><td><label for="tiyong"></label><textarea name="tiyong"
							id="tiyong" cols="30" rows="3"><?php echo ($data["dongyao"]["tiyong"]); ?></textarea></td></tr><tr><td>五行</td><td><label for="wuxing"></label><textarea name="wuxing"
							id="wuxing" cols="30" rows="3"><?php echo ($data["dongyao"]["wuxing"]); ?></textarea></td></tr><tr><td>&nbsp;</td><input type="hidden" name='id' value="<?php echo ($data["dongyao"]["id"]); ?>"/><td><input type="button" name="doSave" id="button" value="保存" onclick="Submit('form1');"/></td></tr></table></form></div></body></html>