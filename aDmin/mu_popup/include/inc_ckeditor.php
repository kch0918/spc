<script src="./include/ckeditor/ckeditor.js"></script>
<script>
//Ajaximage = 서버업로드 없이 첨부파일형태
/* 
var toolbar = [
	[ 'Source', 'Preview' , '-', 'Link', 'Unlink', '-','Ajaximage', 'Table', 'HorizontalRule', 'SpecialChar', 'Youtube', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
	'/',
	[ 'Styles', 'Format', 'Font', 'FontSize', '-', 'Bold', 'Italic', 'Underline', 'Strike', '-', 'TextColor', 'BGColor', '-', 'BulletedList', '-', 'Maximize' ],
];
*/
//객체 생성
var ajaxImage = {};
//ckeditor textarea id
ajaxImage["id"] = "content";
//업로드 될 디렉토리
ajaxImage["uploadDir"] = "./ckeditor/upload";
ajaxImage["imgMaxN"] = 20;
ajaxImage["imgMaxSize"] = 32;
/*
document.addEventListener("DOMContentLoaded", function(){
	CKEDITOR.replace('content',{
		toolbar: toolbar,
		on: {
			instanceReady: function(){
				this.dataProcessor.htmlFilter.addRules({
					elements: {}
				});
			}
		},
	});
});
*/
</script>
<form id="img_upload_form" action="./include/ckeditor/img_upload.php" enctype="multipart/form-data" method="post" style="display:none;">
    <input type='file' id="img_file" multiple="multiple" name='imgfile[]' accept="image/*">
</form>