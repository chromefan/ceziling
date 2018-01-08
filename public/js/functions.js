
// JavaScript Document

function ConfirmJump(s,url)
{
    if(confirm(s))
    {
        window.location.href = url;
    }
}

function Submit(formname,_target)
{


    var formid =document.getElementById(formname);
    var isform = Validator.Validate(formid,3);
    var target = (typeof(_target) == "undefined")?"":_target;

    if(!isform)
    {
        return false;
    }else
    {
        if(target!="")
        {
            formid.target = target;
        }
        formid.submit();
        return true;


    }

}


function SubmitFocus(formname,_target)
{


    var formid =document.getElementById(formname);
    var isform = Validator.Validate(formid,3);
    var target = (typeof(_target) == "undefined")?"":_target;
	
	var post_id = document.getElementById("post_id");
	if(post_id.value<1)
	{
		document.getElementById('search_msg').innerHTML = '焦点图未关联成功,不能提交';
		isform = false;
	}
	
    if(!isform)
    {
        return false;
    }else
    {
        if(target!="")
        {
            formid.target = target;
        }
        formid.submit();
        return true;


    }

}


function SubmitEditor(formname,_target)
{

    htmlEditor2.toTextareaValue();
    var formid =document.getElementById(formname);
    var isform = Validator.Validate(formid,3);
    var target = (typeof(_target) == "undefined")?"":_target;

    if(!isform)
    {
        return false;
    }else
    {
        if(target!="")
        {
            formid.target = target;
        }
        formid.submit();
        return true;


    }

}

function CreateBox(w,h,url,name,ev)
{

    Box(w,h,url,'msg_box',name,'msg_box_title','#3777BC','#3777BC','','','#FFFFFF','#3777BC','auto','','',ev);
}


function CreateBoxCenter(w,h,url,name)
{

    Box(w,h,url,'msg_box',name,'msg_box_title','#3777BC','#3777BC','','','#FFFFFF','#3777BC');
}

function CloseMsgBox()
{
    CloseBox('msg_box','msg_box_title');
}

function AddNewsCate(url)
{
    if($("#_cate_").val()=='')
    {
        alert('请填写类别名称');
        $("#_cate_").focus();
    }else
    {
        var GET_TOKEN_PARAM = {};
        GET_TOKEN_PARAM._cate_ = $("#_cate_").val();

        $.post(url, GET_TOKEN_PARAM, function(data){

            if(typeof(data.ret)!=undefined && data.ret==0){




                var select_start = '<select name="magcate" id="magcate" >';
                var select_end = '</select>';
                var select_content = '';
                for(d in data.data)
                {

                    select_content+='<option value="'+data.data[d].cate_id+'">'+data.data[d].name+'</option>';

                }
                var select_html = select_start+select_content+select_end;


                parent.document.getElementById('_magcate_').innerHTML = select_html;

                CloseMsgBox();

            }else {
                alert("抱歉，网络繁忙...请稍后");

            }
        },"json");
    }

}

function ChangeQrcodeType(obj)
{
    MakeChangeQrcodeType(obj.value);



}


function LoadChangeQrcodeType(_type,_link_type)
{

    var type = (typeof(_type) == "undefined")?"":parseInt(_type);
    var link_type = (typeof(_link_type) == "undefined")?"":parseInt(_link_type);



    var selectIndex = document.getElementById('qrtype').selectedIndex;

    MakeChangeQrcodeType(document.getElementById('qrtype').options[selectIndex].value);



    if(type>3)
    {
        MakeChangeQrcodeLinkType(_link_type);
    }

}

function MakeChangeQrcodeType(v)
{

    $("#qrtype_value").val(v);

    if(v==1 || v==2)
    {
        var selectIndex = document.getElementById('qrtype').selectedIndex;
        var selectText = document.getElementById('qrtype').options[selectIndex].text;

        //$("#qrcode_url_name").html(selectText);

        $("#qrcode_url").show();
        $("#qrcode_map_info").hide();

        $("#cms_open_type").hide();

        $("#cms_content_url").hide();
        $("#cms_content_so").hide();

    }else if(v==3)
    {
        $("#cms_open_type").hide();
        $("#qrcode_url").hide();
        $("#qrcode_map_info").show();

    }else if(v==4 || v==5 || v==6)
    {

        $("#cms_open_type").show();
        $("#qrcode_url").hide();
        $("#qrcode_map_info").hide();


        var link_type_Index = document.getElementById('link_type').selectedIndex;
        var link_type_value = document.getElementById('link_type').options[link_type_Index].value;


        MakeChangeQrcodeLinkType(link_type_value);


    }
}


function ChangeQrcodeLinkType(obj)
{
    MakeChangeQrcodeLinkType(obj.value);
}




function MakeChangeQrcodeLinkType(v)
{
    if(v==1)
    {
        $("#cms_content_url").hide();
        $("#article_news_link_title").hide();
        $("#cms_content_so").show();
        $("#qrcode_url").hide();
    }else if(v==2)
    {


        var qrtype_value = $("#qrtype_value").val();
        if(qrtype_value==6)
        {
            $("#qrcode_url").show();

            $("#cms_content_url").hide();
            $("#cms_content_so").hide();
        }else if(qrtype_value==4 || qrtype_value==5)
        {

            $("#article_news_link_title").show();
            $("#cms_content_url").show();
            $("#cms_content_so").hide();


        }else
        {
            $("#cms_content_url").show();
            $("#cms_content_so").hide();
        }

    }
}



function AddChannel(formname,url)
{
    var formid =document.getElementById(formname);
    var isform = Validator.Validate(formid,3);


    if(!isform)
    {
        return false;
    }else
    {
        var GET_TOKEN_PARAM = {};
        GET_TOKEN_PARAM._channel_ = $("#_channel_").val();
        //GET_TOKEN_PARAM._channel_id_ = $("#_channel_id_").val();

        $.post(url, GET_TOKEN_PARAM, function(data){

            if(typeof(data.ret)!=undefined && data.ret==0){




                var select_start = '<select name="channelID" id="channelID" >';
                var select_end = '</select>';
                var select_content = '';
                for(d in data.data)
                {

                    select_content+='<option value="'+data.data[d].id+'">'+data.data[d].name+'</option>';

                }
                var select_html = select_start+select_content+select_end;


                parent.document.getElementById('_magcate_').innerHTML = select_html;

                CloseMsgBox();

            }else {
                alert("抱歉，网络繁忙...请稍后");

            }
        },"json");
    }

}



function FileUpload(v,_acturl_)
{

    if(v.value!='')
    {
        var acturl = (typeof(_acturl_) == "undefined")?_BASEURL_+"index.php?s=/Pic/save/":_acturl_;
        var attrurl =  (typeof(_acturl_) == "undefined")?_BASEURL_+"index.php?s=/Pic/attr/":_BASEURL_+"index.php?s=/Pic/padattr/";
        var ext = v.value.substring(v.value.lastIndexOf(".")+1).toUpperCase();
        if(ext=='JPG' || ext=='JPEG' || ext=='GIF' || ext=='PNG')
        {

            $("#"+v.id+'_msg').show();
            $('#'+v.id+'_msg').html("<img src='"+_BASEIMG_+"/loading.gif'>正在上传中,请稍后");
            //alert(acturl+"-"+attrurl);
            $.ajaxFileUpload
            (
            {
                url:acturl,
                secureuri:false,
                fileElementId:v.id,
                dataType: 'json',
                data:{id:v.id,edit_id:$("#edit_id").val()},
                success: function (data, status)
                {


                    if(typeof(data.error) != 'undefined')
                    {


                        $("#"+data.id+'_msg').html('');




                        if(data.error != '')
                        {

                            $('#'+data.id+'_msg').html('<font color="#FF0000" style="font-weight:bold;">上传失败</font>');
                        }else
                        {

                            $('#'+data.id+'_msg').html('<font color="#FF0000" style="font-weight:bold;">上传成功</font>');

                            if($("#edit_id").val()<1)
                            {

                                //alert(acturl);
                                CreateBoxCenter(600,550,attrurl+data.data,'添加图片属性');
                            }




                        }
                    }
                },
                error: function (data, status, e)
                {
                    alert(e);
                }
            }
            )



        }else
        {
            alert('只能上传图片');
        }




    }

}



function TopFileUpload(v,_url_,_data_)
{

    if(v.value!='')
    {

        var ext = v.value.substring(v.value.lastIndexOf(".")+1).toUpperCase();

        var _data_ = (typeof(_data_) == "undefined")?"":_data_;

        if(ext=='JPG' || ext=='JPEG' || ext=='GIF' || ext=='PNG')
        {

            $("#"+v.id+'_msg').show();
            $('#'+v.id+'_msg').html("<img src='"+_BASEIMG_+"/loading.gif'>正在上传中,请稍后");

            $.ajaxFileUpload
            (
            {
                url:_url_,
                secureuri:false,
                fileElementId:v.id,
                dataType: 'json',
                data:{id:v.id,old_id:$("#old_id").val(),_data_:_data_},
                success: function (data, status)
                {



                    if(typeof(data.error) != 'undefined')
                    {


                        $("#"+data.id+'_msg').html('');




                        if(data.error != '')
                        {

                            $('#'+data.id+'_msg').html('<font color="#FF0000" style="font-weight:bold;">上传失败</font>');
                        }else
                        {

                            $('#'+data.id+'_msg').html('<font color="#FF0000" style="font-weight:bold;">上传成功</font>');





                        }
                    }
                },
                error: function (data, status, e)
                {
                    alert(e);
                }
            }
            )



        }else
        {
            alert('只能上传图片');
        }




    }

}



function VerFileUpload(v,_url_)
{

    if(v.value!='')
    {
        var ext = v.value.substring(v.value.lastIndexOf(".")+1).toUpperCase();

        $("#"+v.id+'_msg').show();
        $('#'+v.id+'_msg').html("<img src='"+_BASEIMG_+"/loading.gif'>正在上传中,请稍后");

        $.ajaxFileUpload(
        {
            url:_url_,
            secureuri:false,
            fileElementId:v.id,
            dataType: 'json',
            data:{id:v.id},
            success: function (data, status)
            {
                if(typeof(data.error) != 'undefined')
                {
                    $("#"+data.id+'_msg').html('');

                    if(data.error != '')
                    {
                        $('#'+data.id+'_msg').html('<font color="#FF0000" style="font-weight:bold;">上传失败</font>');
                    }else
                    {
                        alert(data.data);
                        $('#'+data.id+'_msg').html('<font color="#FF0000" style="font-weight:bold;">上传成功</font>');
                        $('#'+data.id+'_value').val(data.data);
                    }
                }
            },
            error: function (data, status, e)
            {
                alert(e);
            }
        })
    }
}

function AddPicAttr(formname,url)
{
    var formid =document.getElementById(formname);
    var isform = Validator.Validate(formid,3);

    if(!isform)
    {
        return false;
    }else
    {

        var GET_TOKEN_PARAM = {};
        GET_TOKEN_PARAM._title_ = $("#_title_").val();
        GET_TOKEN_PARAM._author_ = $("#_author_").val();
        GET_TOKEN_PARAM._showtime_ = $("#_showtime_").val();
        GET_TOKEN_PARAM._description_ = $("#_description_").val();

        GET_TOKEN_PARAM._source_ = $("#_source_").val();

        GET_TOKEN_PARAM._tag_ = $("#_tag_").val();

        GET_TOKEN_PARAM._id_ = $("#_id_").val();

        $.post(url, GET_TOKEN_PARAM, function(data){

            if(typeof(data.ret)!=undefined && data.ret==0){
                alert('图片属性编辑成功');
                CloseMsgBox();
            }else {
                alert("抱歉，网络繁忙...请稍后");
            }
        },"json");
    }
}

function TopSearch(ev)
{
    var title = $("#title").val();
    var types = $("#types").val();
    _title = types=="1"?'文章':'新闻';

    CreateBoxCenter(500,290,_BASEURL_+"index.php?s=/Top/search/"+encodeURIComponent(title)+"/"+types,'搜索系统中的'+_title);
}

function QrcodeCmsSearch(ev)
{
    var qrtype_value = $("#qrtype_value").val();
    var types = 1;
    if(qrtype_value==4)
    {
        types = 2;

    }else if(qrtype_value==5)
    {
        types = 1;
    }else if(qrtype_value==6)
    {
        types = 3;
    }

    var title = $("#title").val();

    CreateBox(500,250,_BASEURL_+"index.php?s=/Top/search/"+encodeURIComponent(title)+"/"+types,'搜索',ev);

}

function SearchRadio(obj)
{
    $("#_id_").val(obj.value);
}


function TopSearchBtn()
{
    _v = $("#_id_").val();
    if(_v!='')
    {
        _v = _v.split("_");
        parent.document.getElementById('title').value = _v[1];
        parent.document.getElementById('post_id').value = _v[0];
		if(parent.document.getElementById('post_id').value>0)
		{
			parent.document.getElementById('search_msg').innerHTML = '焦点图与内容关联成功';
		}
		
        CloseMsgBox();
    }
}

function ChangeLinkTypes(obj)
{
    if(obj.value==3)
    {
        $("#_link_url_").hide();
    }else
    {
        $("#_link_url_").show();
    }
}

function ChangeStartTypes(obj)
{
    if(obj.value==1)
    {
        $("#start_link_attr").hide();
    }else
    {
        $("#start_link_attr").show();
    }
}


function delCoordinate_pic(cid)
{
    //alert(postid+"-"+cid+"-"+_tid_);return;
    $.post(_BASEURL_+'index.php?s=/coord/delCoord/', {pid: postid, cid: cid,tid:_tid_}, delCoordinateResponse=function(data){
        if(data.error){
            alert(data.message);
        } else {
            $('#li_'+cid).remove();
        }
    },'json');
    return false;
}
//添加坐标点
function addCoordinate_pic()
{
    var tagname = $('#input_coord').val();
    if (tagname){
        $('#loading').show();
        $.post(_BASEURL_+'index.php?s=/coord/addCoord/', {pid: postid, coord: tagname,tid:_tid_}, addCoordinateResponse=function(data){
            $('#loading').hide();
            if(data.error){
                alert(data.message);
            } else {
                if(data.getlat){
                    var li_class = "";
                } else {
                    var li_class = ' class="dd"';
                }
                var li = '<li id="li_'+data.cid+'"' + li_class + '>'+tagname+'<a onclick="return delCoordinate_pic('+data.cid+');" href="#" title="删除坐标点" class="a2"><img src="__IMG__/transparent.gif"></a></li>';
                $("#coordList").append(li);
                $('#input_coord').val('');
            }
        },'json');
    }
}

function PicUpload(file, acturl, parent_id, pic_type)
{
    if(file.value == '')
    {
        alert('请选择图片');
        return false;
    }

    var url = acturl;
    var ext = file.value.substring(file.value.lastIndexOf(".")+1).toUpperCase();
    if(ext=='JPG' || ext=='JPEG' || ext=='GIF' || ext=='PNG')
    {
        $("#"+file.id+'_msg').show();
        $.ajaxFileUpload(
        {
            url:url,
            secureuri:false,
            fileElementId:file.id,
            dataType: 'json',
            data:{id:file.id, parent_id:parent_id, pic_type:pic_type},
            success: function (data, status)
            {
                $("#"+data.file_id+'_msg').hide();
                if(data.error == 1)
                {
                    $('#'+data.file_id+'_msg').after('<font color="#FF0000" style="font-weight:bold;">失败</font>');
                }
                else
                {
                    var html = '<li><a target="new" href="'+data.img_o+'"><img width="200" border="0" src="'+data.img_s+'"></a><p><input type="text" name="sort['+data.img_id+']" value="0" size=5> <a href="javascript:" onclick="ConfirmJump(\'您确认删除吗?\', \'/admincp/shop/imgDel/id/'+data.img_id+'\')"><strong>删除</strong></a></p></li>';
                    if (data.img_type == 1){
                        $('ul.pad').append(html);
                    } else {
                        $('ul.mobile').append(html);
                    }

                    $("#"+data.file_id).val('');
                }
            },
            error: function (data, status, e)
            {
                alert(e);
            }
        })
    }
    else
    {
        alert('只能上传图片');
    }
}



function getNdate(lasttime,n,pid) 
{ 
	
	var uom = new Date(new Date(lasttime)-0+n*86400000); 
	var m = (uom.getMonth()+1)<10?("0"+(uom.getMonth()+1)):(uom.getMonth()+1);
	var d = (uom.getDate())<10?("0"+(uom.getDate())):(uom.getDate());
	uom = uom.getFullYear() + "-" + m + "-" + d; 
	
	document.getElementById(pid).value = uom
} 