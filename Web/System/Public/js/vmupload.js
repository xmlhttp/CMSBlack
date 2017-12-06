var isfirst=false;
$(function(){
	//上传图片按钮
	$("#img,#bigimg,#upfile").change(function(){
		var obj=$(this).get(0),
			fileName=$(this).val(),
			fix=fileName.substring(fileName.lastIndexOf('.') + 1);
		if(fix=="gif"||fix=="jpg"||fix=="png"||fix=="bmp"){
		if(obj.files&&obj.files[0]){
			$(this).parent(".vmsame").parent(".vmupload").css({"background-image":"none"});
			$(this).parent(".vmsame").next(".vmupclose").show();
			$(this).parent(".vmsame").prev(".vmupimg").css({"width":"100%","height":"100%"}).hide().attr({"src":window.URL.createObjectURL(obj.files[0])}).fadeIn()
		}else{
			obj.select();
			window.top.document.body.focus();
			var imgsrc = document.selection.createRange().text;
			var localimag = $(this).parent(".vmsame").parent(".vmupload");
			localimag.css({"width":localimag.css("width"),"height":localimag.css("height")});
			try{
				$(this).parent(".vmsame").parent(".vmupload").css({"background-image":"none"});
				localimag.get(0).style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
				localimag.get(0).filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgsrc;
				$(this).parent(".vmsame").prev(".vmupimg").fadeOut();
				$(this).parent(".vmsame").next(".vmupclose").show()
			}catch(e){
				alert("您上传的图片格式不正确，请重新选择!");
				return false
			}
			document.selection.empty()
		}
		}else if(fix=="doc"||fix=="docx"){
			$(this).parent(".vmsame").parent(".vmupload").css({"background-image":"none"});
			$(this).parent(".vmsame").next(".vmupclose").show();
			$(this).parent(".vmsame").prev(".vmupimg").hide().css({"width":"80px","height":"80px"}).attr({"src":"/Web/System/Public/images/fileico/doc.jpg"}).fadeIn()
		}else if(fix=="exe"){
			$(this).parent(".vmsame").parent(".vmupload").css({"background-image":"none"});
			$(this).parent(".vmsame").next(".vmupclose").show();
			$(this).parent(".vmsame").prev(".vmupimg").hide().css({"width":"80px","height":"80px"}).attr({"src":"/Web/System/Public/images/fileico/exe.jpg"}).fadeIn()
		}else if(fix=="mp3"){
			$(this).parent(".vmsame").parent(".vmupload").css({"background-image":"none"});
			$(this).parent(".vmsame").next(".vmupclose").show();
			$(this).parent(".vmsame").prev(".vmupimg").hide().css({"width":"80px","height":"80px"}).attr({"src":"/Web/System/Public/images/fileico/mp3.jpg"}).fadeIn()
		}else if(fix=="mp4"){
			$(this).parent(".vmsame").parent(".vmupload").css({"background-image":"none"});
			$(this).parent(".vmsame").next(".vmupclose").show();
			$(this).parent(".vmsame").prev(".vmupimg").hide().css({"width":"80px","height":"80px"}).attr({"src":"/Web/System/Public/images/fileico/mp4.jpg"}).fadeIn()
		}else if(fix=="pdf"){
			$(this).parent(".vmsame").parent(".vmupload").css({"background-image":"none"});
			$(this).parent(".vmsame").next(".vmupclose").show();
			$(this).parent(".vmsame").prev(".vmupimg").hide().css({"width":"80px","height":"80px"}).attr({"src":"/Web/System/Public/images/fileico/pdf.jpg"}).fadeIn()
		}else if(fix=="ppt"||fix=="pptx"||fix=="pps"){
			$(this).parent(".vmsame").parent(".vmupload").css({"background-image":"none"});
			$(this).parent(".vmsame").next(".vmupclose").show();
			$(this).parent(".vmsame").prev(".vmupimg").hide().css({"width":"80px","height":"80px"}).attr({"src":"/Web/System/Public/images/fileico/ppt.jpg"}).fadeIn()
		}else if(fix=="rar"){
			$(this).parent(".vmsame").parent(".vmupload").css({"background-image":"none"});
			$(this).parent(".vmsame").next(".vmupclose").show();
			$(this).parent(".vmsame").prev(".vmupimg").hide().css({"width":"80px","height":"80px"}).attr({"src":"/Web/System/Public/images/fileico/rar.jpg"}).fadeIn()
		}else if(fix=="txt"){
			$(this).parent(".vmsame").parent(".vmupload").css({"background-image":"none"});
			$(this).parent(".vmsame").next(".vmupclose").show();
			$(this).parent(".vmsame").prev(".vmupimg").hide().css({"width":"80px","height":"80px"}).attr({"src":"/Web/System/Public/images/fileico/txt.jpg"}).fadeIn()
		}else if(fix=="xls"||fix=="xlsx"){
			$(this).parent(".vmsame").parent(".vmupload").css({"background-image":"none"});
			$(this).parent(".vmsame").next(".vmupclose").show();
			$(this).parent(".vmsame").prev(".vmupimg").hide().css({"width":"80px","height":"80px"}).attr({"src":"/Web/System/Public/images/fileico/xls.jpg"}).fadeIn()
		}else if(fix=="zip"){
			$(this).parent(".vmsame").parent(".vmupload").css({"background-image":"none"});
			$(this).parent(".vmsame").next(".vmupclose").show();
			$(this).parent(".vmsame").prev(".vmupimg").hide().css({"width":"80px","height":"80px"}).attr({"src":"/Web/System/Public/images/fileico/zip.jpg"}).fadeIn()
		}else if(fix=="bin"){
			$(this).parent(".vmsame").parent(".vmupload").css({"background-image":"none"});
			$(this).parent(".vmsame").next(".vmupclose").show();
			$(this).parent(".vmsame").prev(".vmupimg").hide().css({"width":"80px","height":"80px"}).attr({"src":"/Web/System/Public/images/fileico/bin.jpg"}).fadeIn()
		}else if(fix=="html"||fix=="htm"){
			$(this).parent(".vmsame").parent(".vmupload").css({"background-image":"none"});
			$(this).parent(".vmsame").next(".vmupclose").show();
			$(this).parent(".vmsame").prev(".vmupimg").hide().css({"width":"80px","height":"80px"}).attr({"src":"/Web/System/Public/images/fileico/html.jpg"}).fadeIn()
		}else if(fix=="css"){
			$(this).parent(".vmsame").parent(".vmupload").css({"background-image":"none"});
			$(this).parent(".vmsame").next(".vmupclose").show();
			$(this).parent(".vmsame").prev(".vmupimg").hide().css({"width":"80px","height":"80px"}).attr({"src":"/Web/System/Public/images/fileico/css.jpg"}).fadeIn()
		}else{
			$(this).parent(".vmsame").parent(".vmupload").css({"background-image":"none"});
			$(this).parent(".vmsame").next(".vmupclose").show();
			$(this).parent(".vmsame").prev(".vmupimg").hide().css({"width":"80px","height":"80px"}).attr({"src":"/Web/System/Public/images/fileico/no.jpg"}).fadeIn()	
		}
		isfirst=true
	});	
	//上传图片结束
	$(".vmupclose").click(function(){
		var obj=$(this).prev(".vmsame").children("input").get(0);
		if(!(obj.files&&obj.files[0])&&isfirst){
			$(this).parent(".vmupload").get(0).filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = "none"
		}
		$(this).hide();
		clearFileInput(obj);
		$(this).siblings(".vmupimg").hide();
		$(this).parent(".vmupload").css({"background":"url(/Web/System/Public/images/fileimg.jpg) center center no-repeat"})
	})
});
//清除file内容
function clearFileInput(file){ 
    var form=document.createElement('form');
    document.body.appendChild(form);
    var pos = file.nextSibling;
    form.appendChild(file);
    form.reset();
    pos.parentNode.insertBefore(file, pos);
    document.body.removeChild(form)
} 
