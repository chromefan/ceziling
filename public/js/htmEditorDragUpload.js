var htmlEditor2=new htmlEditor('textarea');

//插入图片到编辑器
function insertPic(obj, picid){
    var imgsrc=$(obj).attr('src');
    var imgintro=$(obj).parent().find('.imginfoEditor').val();
    if(!imgintro){
        htmlEditor2.insertHTML('<div class="aImg"><img big="0" id="'+picid+'" src="'+imgsrc +'"/></div><br/>');
    }
    else{

        var reg=new RegExp("\n","g");
        imgintro=imgintro.replace(reg,"<br>");
        var reg2=/([\s]*<br>)*[\s]*$/g;
        imgintro=imgintro.replace(reg2,'')
        htmlEditor2.insertHTML('<div class="imgbox"><div class="img"><img big="0" id="'+picid+'" src="'+imgsrc +'"/></div>'+'<div id="'+picid+'" class="imginfo">'+imgintro+'</div></div><p>&nbsp</p>');
    }
}

function dragUploadClass(posturl, pid){
    var posturl=posturl;
    var pageContent=document.getElementById('pageContent');
    var imgs=pageContent.getElementsByTagName('img');
    var oDragWrap =$$('uploadready');
    //拖进
    oDragWrap.addEventListener('dragenter', function(e) {
        e.preventDefault();
        $$('dropbox').className='box-shadow';
    }, false);

    //拖离
    oDragWrap.addEventListener('dragleave', function(e) {
        $$('dropbox').className='';
    }, false);

    //拖来拖去
    oDragWrap.addEventListener('dragover', function(e) {
        e.preventDefault();
    }, false);

    //扔下
    oDragWrap.addEventListener('drop', function(e) {
        dropHandler(e);
    }, false);

    var arrFiles=[];
    var dropHandler = function(e) {
        e.stopPropagation();
        e.preventDefault();
        $$('pageContent').className='';
        $$('upload_btn').style.display='block';
        files = e.target.files || e.dataTransfer.files;
        for(var f = 0; f < files.length; f++){
            if(files[f].type.indexOf("image")==-1){	　
            alert('文件' + files[f].name + '不是图片。')
            } 　　
            else{
                arrFiles.push(files[f]);
                //console.log('files['+f+'].index'+files[f].index)
            }　
        }

        $$('pageContent').innerHTML='';
        for(var i=0; i<arrFiles.length;i++){
            if(arrFiles[i].index!=='no'){
                arrFiles[i].index=parseInt(Math.random() * 9000000);
            }
        }
        for(var i=0; i<arrFiles.length;i++){
            if(arrFiles[i].index!=='no'){
                viewfile(arrFiles[i])
            }
        }
        $$('upload_btn').addEventListener('click', function(e) {
            e.preventDefault();
            $$('upload_btn').style.display='none';//隐藏上传按钮
            for(var s=0; s<arrFiles.length;s++){
                if(arrFiles[s].index!=='no'){
                    ajaxUpload(arrFiles[s])
                }
            }
            arrFiles=null;
            arrFiles=[];
        }, false);
    }
    //放入完毕
    function ajaxUpload(files){
        var xhr=new XMLHttpRequest();
        xhr.upload.addEventListener('progress',function(e){
            var pc=parseInt(e.loaded/e.total*100);
            if($$('progress'+files.index)){
                $$('progress'+files.index).value=pc;
            }
        },false)
        xhr.onreadystatechange = function(e) {
            if (xhr.readyState == 4 && xhr.status == 200) {
                //长传成功后返回HTML结构
                var jsondata = jQuery.parseJSON(xhr.responseText);
                var oldLi = $$('imgViewList'+files.index);
                var	uploadLi=document.createElement('li');

                uploadLi.id = 'li_'+jsondata.picid;
                var html  = '';
                //html += '<div>';
                html +='<div class="img_and_info">'
                html += '<img id="'+jsondata.picid+'" width="230" border="0" onclick="insertPic(this, '+jsondata.picid+')" src="'+jsondata.src+'"/>';
                html += '<textarea class="imginfoEditor" id="pic_'+ jsondata.picid +'" onblur="savePicDesc('+ jsondata.picid +')">'+jsondata.content+'</textarea>';
                html += '</div><br>';
                html += '<input title="排序" id="sort_'+ jsondata.picid +'" type="text" size="4" value="'+jsondata.sort+'" style="height:20px;padding:0;text-align:center" onblur="savePicSort('+ jsondata.picid +');"/>&nbsp;<input style="height:20px;padding:0;" title="图片作者" id="author_'+ jsondata.picid +'" type="text" value="作者" size="5" onblur="savePicAuthor('+ jsondata.picid +');">&nbsp;<settitle id="t_'+ jsondata.picid +'"><ss class="t_b" onclick="setPicTitle('+ jsondata.picid +', 1)">标题图</ss></settitle>&nbsp;<delpic class="t_b" onclick="delPic('+ jsondata.picid +')">删除</delpic>';
                //html += '</div>';
                uploadLi.innerHTML=html;
                var oldLi=$$('imgViewList'+files.index);
                $$('pageContent').removeChild(oldLi);
                $$('uploaded').appendChild(uploadLi);
            }
        };
        xhr.open("POST", posturl+files.name + '&pid=' + pid, true);
        xhr.setRequestHeader("X_PID", pid);
        xhr.send(files);
    }

    function viewfile(file){
        if(window.webkitURL){
            var	imgsrc=window.webkitURL.createObjectURL(file)
            createView(file,imgsrc)
        }
        else if(window.URL){
            var	imgsrc=window.URL.createObjectURL(file)
            createView(file,imgsrc)
        }
        else
        {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imgsrc=e.target.result;
                createView(file,imgsrc)
            }
            reader.readAsDataURL(file);
        }
    }
    //创建预览dom
    function createView(file,imgsrc){
        var html = "";
        html += '<li id="imgViewList'+file.index+'">';
        html += '<div class="img_and_info">';
        html += '<img width="230"  border="0" src="'+imgsrc+'">';
        html += '</div>';
        html += '<span onclick="del(\'imgViewList'+file.index+'\')" class="upload_delete" title="删除">删除</span>'
        html += '<progress value="0" max="100" id="progress'+file.index+'"></progress>';
        html += '</li>';
        $$('pageContent').innerHTML+=html;
    }

    Array.prototype.del=function(n) {　
    //n表示第几项，从0开始算起。
    if(n<0){　
    //如果n<0，则不进行任何操作。
    return this;
    }
    else
    {
        return this.slice(0,n).concat(this.slice(n+1,this.length));
    }
    }

    $('#dropbox').height($(window).height());

    function Output(msg) {
        var m = $$id("messages");
        m.innerHTML = msg + m.innerHTML;
    }

    //删除预览
    function del(obj){
        var n=parseInt(obj.substring(11));//获取数组索引
        for(var s=0;s<arrFiles.length; s++){
            if(arrFiles[s].index==n){
            }
        }
        $$(obj).parentNode.removeChild($$(obj))
    }
}