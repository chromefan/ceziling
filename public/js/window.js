var MiniSite={};
MiniSite.Browser = {
	ie: /msie/.test(window.navigator.userAgent.toLowerCase()),
	version: /7.0/.test(window.navigator.userAgent.toLowerCase()),
	v6: /6.0/.test(window.navigator.userAgent.toLowerCase()),
	moz: /gecko/.test(window.navigator.userAgent.toLowerCase()),
	opera: /opera/.test(window.navigator.userAgent.toLowerCase())
};
isIE = MiniSite.Browser.ie;

/*
	创建背景层
	Author By Zero

*/
function create_bg(bg_id,bg_color)
{
    var sWidth, sHeight;
    sWidth = document.body.offsetWidth;
    sHeight = document.body.scrollHeight;
    var bgObj = document.createElement("div");
    bgObj.setAttribute('id',bg_id);
    bgObj.style.position = "absolute";
    bgObj.style.top = "0";
    bgObj.style.background = bg_color;
    bgObj.style.filter = "alpha(opacity=30)";
    bgObj.style.opacity = "0.6";
    bgObj.style.left = "0";
    bgObj.style.width = sWidth + "px";
    bgObj.style.height = sHeight + "px";
    bgObj.style.zIndex = "10000";
    return bgObj;
	//document.body.appendChild();
}
/*
	创建弹出层[位置可以自适应或设置默认居中]
	Author By Zero

*/
function create_msg(msgw,msgh,msg_id,ifbgcolor,bordercolor,auto_margin,margin_left,margin_top,ev)
{


	 var msgObj = document.createElement("div");
    msgObj.setAttribute("id", msg_id);
    msgObj.setAttribute("align", "center");

	if(ifbgcolor!="")
	{
		msgObj.style.background = ifbgcolor;
	}
    if(bordercolor!="")
	{
		msgObj.style.border = "1px solid " + bordercolor;
	}
    msgObj.style.position = "absolute";
    //msgObj.style.left = "50%";
    //msgObj.style.top = "50%";
    msgObj.style.font = "12px/1.6em Verdana, Geneva, Arial, Helvetica, sans-serif";

	var x,y;

	if(auto_margin=="auto")
	{
	    
		var Mouse = mouseMove(ev);
		x = (Mouse[0]-margin_left);
		y = (Mouse[1]+margin_top);

	}else if(auto_margin=="set")
	{
		x  = margin_left;
		y = margin_top;

	}else
	{
		x = document.documentElement.scrollLeft + (window.screen.availWidth - msgw) / 2;
		y = document.documentElement.scrollTop + (window.screen.availHeight - msgh) / 2 - 50;

	}
    msgObj.style.left = x+"px";
    msgObj.style.top = y+"px";

	msgObj.style.width = msgw + "px";
    msgObj.style.height = msgh + "px";
    msgObj.style.zIndex = "10001";
	return msgObj;
}
/*
	创建标题层
	Author By Zero

*/
function create_msg_title(title_name,title_id,title_bg_color,title_border_color,msg_id,bg_id)
{
	 var title = document.createElement("h4");
    title.setAttribute("id", title_id);
    title.setAttribute("align", "right");
    title.style.margin = "0";
    title.style.padding = "3px";
    title.style.background = title_bg_color;
    title.style.filter = "progidXImageTransform.Microsoft.Alpha(startX=20, startY=20, finishX=100, finishY=100,style=1,finishOpacity=100);";
    title.style.opacity = "0.75";
    title.style.border = "1px solid " + title_border_color;
    title.style.height = "18px";
    title.style.font = "12px Verdana, Geneva, Arial, Helvetica, sans-serif";
    title.style.color = "white";
    title.style.cursor = "pointer";
    title.innerHTML = "<span><span style=\"float:left;padding-left:5px;font-weight:bold;\">" + title_name + "</span><span style=\"float:right;font-weight:bold;\">关闭</span></span>";
    title.title = "关闭";
    title.onclick = function() {
		if(null!=document.getElementById(bg_id))
		{
			document.body.removeChild(document.getElementById(bg_id));
		}
        document.getElementById(msg_id).removeChild(title);
        document.body.removeChild(document.getElementById(msg_id));
    }
	return title;
}
/*
	组合弹出层
	Author By Zero
*/
function Box(msgw, msgh, url,msg_id,title_name,title_id,title_bg_color,title_border_color,bg_id,bg_color,msg_bgcolor,msg_bordercolor,msg_auto_margin,msg_margin_left,msg_margin_top,ev) {

	var msg_auto_margin =  (typeof(msg_auto_margin) == "undefined")?"":msg_auto_margin;
	var msg_margin_left = (typeof(msg_margin_left) == "undefined")?"":msg_margin_left;
	var msg_margin_top = (typeof(msg_margin_top) == "undefined")?"":msg_margin_top;
	var ev = (typeof(ev) == "undefined")?"":ev;
	var msg_bgcolor = (typeof(msg_bgcolor) == "undefined")?"":msg_bgcolor;
	var msg_bordercolor = (typeof(msg_bordercolor) == "undefined")?"":msg_bordercolor;
	var title_name = (typeof(title_name) == "undefined")?"":title_name;
	var title_id = (typeof(title_id) == "undefined")?"":title_id;
	var title_bg_color = (typeof(title_bg_color) == "undefined")?"":title_bg_color;
	var title_border_color = (typeof(title_border_color) == "undefined")?"":title_border_color;
	var title_name = (typeof(title_name) == "undefined")?"":title_name;
	var bg_id = (typeof(bg_id) == "undefined")?"":bg_id;
	var bg_color = (typeof(bg_color) == "undefined" || bg_color=="")?"#F00":bg_color;

	if(null!=document.getElementById(msg_id))
	{
		return;
	}
	if(bg_id!="")
	{
		document.body.appendChild(create_bg(bg_id,bg_color));
	}

    document.body.appendChild(create_msg(msgw,msgh,msg_id,msg_bgcolor,msg_bordercolor,msg_auto_margin,msg_margin_left,msg_margin_top,ev));

	if(title_id!="")
	{
		document.getElementById(msg_id).appendChild(create_msg_title(title_name,title_id,title_bg_color,title_border_color,msg_id,bg_id));
	}
    var txt = document.createElement("div");
    txt.style.padding = "1px";
    txt.setAttribute("id", "msgTxt");
    txt.innerHTML = '<iframe src="' + url + '&rand=' + Math.random() + '" id="jquery-overlay-mybox-iframe" name="jquery-overlay-mybox-iframe" style="width:' + (msgw - 8) + 'px;height:' + (msgh - 28) + 'px;" allowTransparency="ture" scrolling="no" frameborder="0"></iframe>';
    document.getElementById(msg_id).appendChild(txt);
}




/*
	关闭弹出层
	Author By Zero

*/
function CloseBox(msg_id,title_id,bg_id)
{
	    var title_id =  (typeof(title_id) == "undefined")?"":title_id;
		var bg_id =  (typeof(bg_id) == "undefined")?"":bg_id;
		if(bg_id!="")
		{
			parent.document.body.removeChild(parent.document.getElementById(bg_id));
		}

		if(title_id!="")
		{
			parent.document.getElementById(msg_id).removeChild(parent.document.getElementById(title_id));
		}
		parent.document.body.removeChild(parent.document.getElementById(msg_id));



}



/*
	获取当前鼠标位置
	Author By Zero
*/
function mouseMove(e)
{
	 var re = Array()
	 if(!document.all)
	 {
	  re[0]=e.pageX;
	  re[1]=e.pageY;
	 }else
	 {
	  re[0]=document.body.scrollLeft+event.clientX;
	  re[1]=document.body.scrollTop+event.clientY;
	 }
	 return re;

}