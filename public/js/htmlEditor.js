var Class = {
	create: function() {
		return function() {
			this.initialize.apply(this, arguments);
		}
	}
}

var htmlEditor=Class.create();
htmlEditor.prototype = {
	initialize:function(id){
		this.cssFile=htmlEditorCssDir+'/editor.css';
		this.path= htmlEditorImgDir+'/editor/';
		this.id=id;
		this.objectId='ste';
		this.viewSource = false;
		_this=this;

		var framebox = document.createElement("div");
		document.getElementById(this.id).parentNode.replaceChild(framebox, document.getElementById(this.id));
		framebox.id = this.id+"-ste";
		framebox.innerHTML =this.getEditorHtml();
		this.frame=document.getElementById(this.id+'-frame').contentWindow;
		this.frame.document.designMode='On';
		this.frame.document.open();
		this.frame.document.write(this.getFrameHtml());
		this.frame.document.close();
		var buttons=framebox.getElementsByTagName('td')
		for(var i=0; i<buttons.length;i++){
			if (buttons[i].className == "button") {
				buttons[i].id = this.id+'-button-'+i;
				buttons[i].onmouseover = function() { this.className = "button-hover"; }
				buttons[i].onmouseout = function() { this.className = this.className.replace(/button-hover(\s)?/, "button"); }
				buttons[i].onclick = function(id) { 
					return function() { 
						this.className = "button-hover button-click"; 
						setTimeout(function(){ 
							document.getElementById(id).className = document.getElementById(id).className.replace(/(\s)?button-click/, ""); 
						}, 100); 
					} 
				}(buttons[i].id);
			}
		}
		this.toggleSource()
		this.runCode()
	},
 fnKeypress:function(){
			   this.frame.document.addEventListener('keypress',function (e) {
				   
				   	var html=_this.frame.document.body.innerHTML;
		
				document.getElementById(_this.id).value=html;
				   
				   var e=e;
				   if (e.keyCode==13){
					
					   _this.insertHTML('<p></p>');
						    e.preventDefault(); 
		                return false;
						}
				   
				   },false); 
			
			  
			   
	   },
	getEditorHtml:function(){
		var html = "";
		html += '<textarea id="'+this.id+'" name="'+this.id+'"></textarea>';
		html += '<table id="ste" class="ste" cellspacing="0" cellpadding="0">';
		html += '<tr><td class="bar"><table id="'+this.id+'-buttons" cellspacing="0" cellpadding="0"><tr>';
		html += '<td class="button"><img src="'+this.path+'images/undo.gif" width="20" height="20" alt="撤销" title="撤销" onclick="_this.execCommand(\'Undo\')"></td>';
		html += '<td><select onchange="_this.execCommand(\'formatblock\', this.value);this.selectedIndex=0;"><option value=""></option><option value="<h1>">标题 1</option><option value="<h2>">标题 2</option><option value="<h3>">标题 3</option><option value="<p>">段落</option></select></td>';
		html += '<td><div class="separator"></div></td>';
		html += '<td class="button"><img src="'+this.path+'images/bold.gif" width="20" height="20" alt="Bold" title="Bold" onclick="_this.execCommand(\'Bold\')"></td>';
		html += '<td class="button"><img src="'+this.path+'images/italic.gif" width="20" height="20" alt="Italic" title="Italic" onclick="_this.execCommand(\'italic\')"></td>';
		html += '<td class="button"><img src="'+this.path+'images/underline.gif" width="20" height="20" alt="Underline" title="Underline" onclick="_this.execCommand(\'underline\')"></td>';
		html += '<td><div class="separator"></div></td>';
		html += '<td class="button"><img src="'+this.path+'images/left.gif" width="20" height="20" alt="Align Left" title="Align Left" onclick="_this.execCommand(\'justifyleft\')"></td>';
		html += '<td class="button"><img src="'+this.path+'images/center.gif" width="20" height="20" alt="Center" title="Center" onclick="_this.execCommand(\'justifycenter\')"></td>';
		html += '<td class="button"><img src="'+this.path+'images/right.gif" width="20" height="20" alt="Align Right" title="Align Right" onclick="_this.execCommand(\'justifyright\')"></td>';
		html += '<td><div class="separator"></div></td>';
		html += '<td class="button"><img src="'+this.path+'images/ol.gif" width="20" height="20" alt="Ordered List" title="Ordered List" onclick="_this.execCommand(\'insertorderedlist\')"></td>';
		html += '<td class="button"><img src="'+this.path+'images/ul.gif" width="20" height="20" alt="Unordered List" title="Unordered List" onclick="_this.execCommand(\'insertunorderedlist\')"></td>';
		html += '<td><div class="separator"></div></td>';
		html += '<td class="button"><img src="'+this.path+'images/outdent.gif" width="20" height="20" alt="Outdent" title="Outdent" onclick="_this.execCommand(\'outdent\')"></td>';
		html += '<td class="button"><img src="'+this.path+'images/indent.gif" width="20" height="20" alt="Indent" title="Indent" onclick="_this.execCommand(\'indent\')"></td>';
		html += '<td><div class="separator"></div></td>';
		html += '<td class="button"><img src="'+this.path+'images/up_biao.png" width="20" height="20" alt="上标" title="上标" onclick="_this.execCommand(\'superscript\')"></td>';
		html += '<td class="button"><img src="'+this.path+'images/down_biao.png" width="20" height="20" alt="下标" title="下标" onclick="_this.execCommand(\'subscript\')"></td>';
		html += '<td><div class="separator"></div></td>';
		
		html += '<td class="button"><img src="'+this.path+'images/link.gif" width="20" height="20" alt="Insert Link" title="Insert Link" onclick="_this.execCommand(\'createlink\')"></td>';
		html += '<td class="button"><img src="'+this.path+'images/unlink.gif" width="20" height="20" alt="取消链接" title="取消链接" onclick="_this.execCommand(\'Unlink\')"></td>';
		html += '<td class="button"><img src="'+this.path+'images/image.gif" width="20" height="20" alt="Insert Image" title="Insert Image" onclick="_this.execCommand(\'insertimage\')"></td>';
		html += '<td><div class="separator"></div></td>';
		html += '<td class="button"><img src="'+this.path+'images/yin.gif" width="20" height="20" alt="引言" title="Insert Image" onclick="_this.openbox(\'yin\')"></td>';
		html += '<td class="button"><img src="'+this.path+'images/sheng.gif" width="20" height="20" alt="生僻字" title="生僻字" onclick="_this.uploadFont()"></td>';
		html += '<td class="button"><img src="'+this.path+'images/video.gif" width="20" height="20" alt="视频" title="视频" onclick="_this.insertVideo()"></td>';
		html += '<td class="button"><img src="'+this.path+'images/clear.png" width="20" height="20" alt="清理word格式" title="清理word格式" onclick="_this.clearhtml()"></td>';
		html += '</tr></table></td></tr>';
		html += '<tr><td class="frame"><iframe id="'+this.id+'-frame" width="100%" height="500" frameborder="0" scrolling="auto"></iframe></td></tr>';
		html += '</table>';
		html += '<div class="source"    id="viewSource"  >查看源码</div>';
		return html;
	},
	getFrameHtml:function(){
		var html = "";
		html += '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
		html += '<html><head>';
		html += '<meta http-equiv="Content-Type" content="text/html; charset='+this.charset+'">';
		html += '<title>SimpleTextEditor frame</title>';
		html += '<style type="text/css">pre { background-color: #f8f8f8; padding: 0.75em 1.5em; border: 1px solid #dddddd; }</style>';
		if (this.cssFile) { html += '<link rel="stylesheet" type="text/css" href="'+this.cssFile+'">'; }
		html += '</head><body></body></html>';
		return html;
	},
	execCommand:function(cmd,value){
		if(cmd=='insertimage'){
			var imgurl=prompt('输入图片地址：','')
			if(imgurl){
				this.frame.focus();
				this.frame.document.execCommand(cmd,false,imgurl);
				this.frame.focus();
			}
		}
		else if(cmd=='createlink'){
			var linkurl=prompt('输入链接地址：','')
			if(linkurl){
				this.frame.focus();
				this.frame.document.execCommand("unlink", false, null);
				this.frame.document.execCommand(cmd, false, linkurl);
				this.frame.focus();
			}
		}
		else
		{
			this.frame.document.execCommand(cmd,false,value);
		}
	},

	insertHTML:function(html){
		this.execCommand("insertHTML",html)
	},
	clearhtml:function(){
		
var html=_this.frame.document.body.innerHTML;
    html=html.replace(/style="[^<>]*?"/ig,'')  //去除行间style样式
	   	.replace(/<!--[\s\S]*?-->/ig,'')  //去除word注释
		.replace(/<span[\s\S]*?>|<\/span>/ig,'')   //去除span
		.replace(/&nbsp;/ig,'')                   //去除空白
		.replace(/(<br>[\s]*?){2,}/ig,'<br>')
        .replace(/<br>[\s]*?</ig,'<')                    //去除br
		.replace(/<[\s]*?b[\s]*?>/ig, '')
		.replace(/<[\s]*?\/[\s]*?b[\s]*?>/ig, '')
        .replace(/<p[^>]+>/ig,'<p>')                     //去除p的样式
        .replace(/<p>[\s]*?<\/p>/ig,'')                   //去除内容为空的p   
		
		_this.frame.document.body.innerHTML=html;
		document.getElementById(_this.id).value=html;
		
		},
	insertVideo:function(){
		
			if($$('openbox')){
			$$('openbox').style.display=($$('openbox').style.display!='none')?'none':'block';
			return;
			}
		
		var box=document.createElement('div');
			box.id='openbox';
			box.className='openbox';
			var videohtml='';
			videohtml+='<table width="100%" border="0" cellspacing="0" cellpadding="0">'
			videohtml+='<tr><td width="100" align="right">视频地址：</td><td ><input size="25" id="videoUrl" name="videoUrl" type="text" /></td></tr>'
			videohtml+='<tr><td align="right">宽度：</td><td><input id="videoWidth" size="3" name="videoWidth" type="text" /></td></tr>'
			videohtml+='<tr><td align="right">高度：</td><td><input id="videoHeight" size="3" name="videoHeight" type="text" /></td></tr>'
			videohtml+='<tr><td align="right">预览图：</td><td>'
			videohtml+='<form enctype="multipart/form-data" method="POST" action="'+_BASEURL_+'index.php?s=/Public/upload/'+'">'; 
            videohtml+='<input type="file" id="upload_videopic" name="upload_videopic"   > '  ;
	        videohtml+='</form> </td></tr>';
			videohtml+='<tr><td></td><td id="videopicView"></td></tr>'
			videohtml+='</table>'
		
			var videobox=document.createElement('div');
			videobox.innerHTML=videohtml;
			    
		
			var btn_ok=document.createElement('input');
			btn_ok.type='button';
			btn_ok.value='确定';

			var btn_cancel=document.createElement('input');
			btn_cancel.type='button';
			btn_cancel.value='取消';

			box.appendChild(videobox);
			box.appendChild(btn_ok);
			box.appendChild(btn_cancel);
			$$('textarea-ste').appendChild(box);
			
			//上传视频预览图
			
			$$('upload_videopic').onchange=function(){
				
				var files=this.files;
				var arrFiles=[];
				for(var f=0;f<files.length;f++){
				if(files[f].type.indexOf("image")==-1){
				alert('文件' + files[f].name + '不是图片。');
				return
				}
				else{
				arrFiles.push(files[f]);
				}}
				
				for(var s=0; s<arrFiles.length;s++){
				videopicUpload(arrFiles[s])  
				}
		   }
	   
 function videopicUpload(files){
	  
	  
	 var xhr=new XMLHttpRequest();
	 
/*	xhr.upload.addEventListener('progress',function(e){
		var pc=parseInt(e.loaded/e.total*100);
		if($('progress'+files.index)){
		$('progress'+files.index).value=pc;}
		},false)	*/	 
	 
	 xhr.onreadystatechange = function(e) {
	if (xhr.readyState == 4 && xhr.status == 200) {
	var imgsrc=xhr.responseText;
    var  html  = '';
		  html += '<img id="viewPic" width="215"   border="0" src="'+imgsrc+'">';
          $$('videopicView').innerHTML=html;
	   
		}
			};
	       xhr.open("POST",_BASEURL_+"index.php?s=/Public/upload/", true);
			xhr.setRequestHeader("X_FILENAME", files.name);
			xhr.send(files);
	  	  }
		
				
				
	
			

			btn_ok.onclick=function(){
				
			var	videoUrl= $$('videoUrl').value.replace(/\s+/g,"");					//去除空格
			var videoWidth =$$('videoWidth').value.replace(/\s+/g,"");
			var videoHeight=$$('videoHeight').value.replace(/\s+/g,"");
			if($$('viewPic')){
			var viewPic=$$('viewPic').src;}
			
/*<div class="video" id="v1" source="file:////mnt/sdcard/dili360/建筑之美1280.mp4">
<img src="http://content.dili360.com/public/data/posts/font/201211/1354010960969.png" height="450" width="800">
<button>播放</button>
</div>*/

			if(videoUrl&&videoWidth&&videoHeight){
				
					_this.frame.focus();
					var now=new Date();
                    var number = now.getTime(); 
					_this.insertHTML('<div class="video" id="v'+number+'" source="'+videoUrl+'" w="'+videoWidth+'" h="'+videoHeight+'"> <img src="'+viewPic+'" /><button>播放</button></div><p></p>');
					_this.frame.focus();
					$$('textarea-ste').removeChild(box)


				}
				else{
					$$('textarea-ste').removeChild(box)
				}
			}
			btn_cancel.onclick=function(){
				$$('textarea-ste').removeChild(box)
			}
		
		
		
		
		},
	uploadFont:function(){
		//创建form提交表单到iframe  
		if($$('uploadbox')){
			$$('uploadbox').style.display=($$('uploadbox').style.display!='none')?'none':'block';
			return;
			}
		var uploadbox=document.createElement('div');
		    uploadbox.className='openbox';
		    uploadbox.setAttribute('id','uploadbox');
   var html_form='';
       html_form+='<div class="uploadBtnArea">';
	    html_form+='<p>浏览上传生僻字图片，点击插入编辑器</p>';
	   html_form+='<form enctype="multipart/form-data" method="POST" action="'+_BASEURL_+'index.php?s=/Public/upload/'+'">'; 
	   html_form+='<ul id="icon_uploadready">';
       html_form+='</ul>';
       html_form+='<input type="file" id="upload_file" name="upload_file"   > '  ;
	   html_form+='</form>';
	   html_form+='<input id="btn_cancel" type="button" value="取消">';

       html_form+='</div>';
	   uploadbox.innerHTML=html_form;
	   $$('textarea-ste').appendChild(uploadbox);
	   
	   	$$('btn_cancel').onclick=function(){
				$$('textarea-ste').removeChild(uploadbox)
			}
	   
	   document.getElementById('upload_file').onchange=function(){
		   
	   var files=this.files;
		   var arrFiles=[];
		   for(var f=0;f<files.length;f++){
	    if(files[f].type.indexOf("image")==-1){
		alert('文件' + files[f].name + '不是图片。');
		return
		}
		else{
			arrFiles.push(files[f]);
			}}
			
	   for(var s=0; s<arrFiles.length;s++){
    	ajaxUpload(arrFiles[s])  
	     }
		   }
	   
 function ajaxUpload(files){
	  
	  
	 var xhr=new XMLHttpRequest();
	 
/*	xhr.upload.addEventListener('progress',function(e){
		var pc=parseInt(e.loaded/e.total*100);
		if($('progress'+files.index)){
		$('progress'+files.index).value=pc;}
		},false)	*/	 
	 
	 xhr.onreadystatechange = function(e) {
	if (xhr.readyState == 4 && xhr.status == 200) {
	var imgsrc=xhr.responseText;
   var	uploadLi=document.createElement('li');	 
    var  html  = '';
		  html += '<img width="16" height="16"  border="0" src="'+imgsrc+'">';
          uploadLi.innerHTML=html;
	   $$('icon_uploadready').appendChild(uploadLi);
	    uploadLi.onclick=function(){
			
			_this.insertHTML(this.innerHTML);
			$$('uploadbox').style.display='none'
			  }
 
	   
	   
	   
		}
			};
	       xhr.open("POST",_BASEURL_+"index.php?s=/Public/upload/", true);
			xhr.setRequestHeader("X_FILENAME", files.name);
			xhr.send(files);
	  	  }
		

		},

	openbox:function(className){
		if(!$$('openbox'))
		{
			var box=document.createElement('div');
			box.id='openbox';
			box.className='openbox';
			var	textarea=document.createElement('textarea');
			    textarea.value='请输入引言';
			var btn_ok=document.createElement('input');
			btn_ok.type='button';
			btn_ok.value='确定';

			var btn_cancel=document.createElement('input');
			btn_cancel.type='button';
			btn_cancel.value='取消';

			box.appendChild(textarea);
			box.appendChild(btn_ok);
			box.appendChild(btn_cancel);

			$$('textarea-ste').appendChild(box);
			textarea.focus()
			btn_ok.onclick=function(){
				if(textarea.value!=''){
					_this.insertHTML('<div class="'+className+'">'+textarea.value+'</div><br/>');
					$$('textarea-ste').removeChild(box)
				}
				else{
					$$('textarea-ste').removeChild(box)
				}
			}
			btn_cancel.onclick=function(){
				$$('textarea-ste').removeChild(box)
			}
		}
	},

	//预览
	runCode:function(){
		$$('runCode').onclick=function(){
			var html=_this.frame.document.body.innerHTML;
			if($$('title')){
			var title=$$('title').value;}
			else{
				var title=''
				}
				
				if($$('subtitle')){
			var subtitle=$$('subtitle').value;}
			else{
				var subtitle=''
				}
			
			if($$('author')){
			var author=$$('author').value;}
			else{
				var author=''
				}
				
				if($$('editor')){
			var editor=$$('editor').value;}
			else{
				var editor=''
				}
				
		
		
			if(html==""){
				alert("什么都没有，预览个毛啊");
				return false;
			}
			var winname = window.open('', "_blank", '');
			winname.document.open();
			winname.document.write('<link href="'+htmlEditorCssDir+'/prev.css" rel="stylesheet" type="text/css" />');
			winname.document.write('<div id="top"></div><div id="bottom"></div><div id="atcileContaner"><h1>'+title+'</h1><h2>'+subtitle+'</h2><div class="author">'+author+'</div><div class="aticleBody">'+html+'<p class="editor" align="right">'+editor+'</p></div><div id="footer"></div></div>');
			winname.document.close();
		}
	},

	toggleSource:function(){
		var viewSourcebtn=document.getElementById('viewSource');
		viewSourcebtn.onclick=function(){

			if(!_this.viewSource){
				var html=_this.frame.document.body.innerHTML;
				document.getElementById('ste').style.display='none';
				document.getElementById(_this.id).style.display='block';
				document.getElementById(_this.id).value=html;
				_this.viewSource=true;
				this.innerHTML="设计模式"

			}
			else{
				var source=document.getElementById(_this.id).value;
				document.getElementById(_this.id).style.display='none';
				document.getElementById('ste').style.display='';
				_this.frame.document.body.innerHTML=source;
				_this.viewSource=false;
				this.innerHTML="查看源码"
			}
		};
	},
	
	toTextareaValue:function(){			
		//匿名滚动函数
		(function(){				
			var html=_this.frame.document.body.innerHTML;
			if(!html){					
				setTimeout(arguments.callee, 200);
			}
			else{					
				document.getElementById(_this.id).value = html;					
			}
		})();
	},
	
	fromTextareaValue:function(){		
		var source=document.getElementById(_this.id).value;
		document.getElementById(_this.id).style.display='none';
		document.getElementById('ste').style.display='';
		_this.frame.document.body.innerHTML=source;		
		_this.viewSource=false;
		var viewSourcebtn=document.getElementById('viewSource');
		viewSourcebtn.innerHTML="查看源码"
	},

	setTextareaValue:function(data){
		document.getElementById(_this.id).value = data
	}
}





