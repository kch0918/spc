/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.height = '500px';
	// Define changes to default configuration here. For example:
	config.language = 'en';
	// config.uiColor = '#AADC6E';
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		'/',
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];
	
	// config.extraPlugins = 'ajaximage,youtube';
	config.extraPlugins = 'youtube';
	config.extraAllowdContent = 'img[src,alt]';
	
	//toolbar 버튼 삭제
	config.removeButtons = 'Print,Save,Preview,NewPage,Smiley,Flash,PageBreak,Anchor,Language,ShowBlocks,Iframe,ImageButton,Select,HiddenField,Textarea,TextField,Subscript,Superscript,CopyFormatting,CreateDiv,Templates,Cut,Copy,Undo,Redo,Replace,Find,SelectAll,BidiRtl,BidiLtr';

	//붙여넣기 시 자동으로 형식이 바뀌는 것 방지
	config.pasteFilter = null;

	//글씨체 추가
	config.font_names = '맑은고딕;굴림/Gulim;돋움/Dotum;바탕/Batang;궁서/Gungsuh;Calibri;Arial/Arial;Comic Sans MS/Comic Sans MS;Courier New/Courier New;Georgia/Georgia;Lucida Sans Unicode/Lucida Sans Unicode;Tahoma/Tahoma;Times New Roman/Times New Roman;Trebuchet MS/Trebuchet MS;Verdana/Verdana';
	//업로드 경로
	config.filebrowserUploadUrl = './include/ckeditor/upload.php'
	//이미지 업로드시 미리보기 텍스트
	config.image_previewText = '';
	// 지윤추가
	//CKEDITOR.dtd.$removeEmpty['i'] = false;
	config.fillEmptyBlocks = false;
	//CKEDITOR.config.fillEmptyBlocks = false;
	//CKEDITOR.config.fullPage = false;
	config.enterMode = CKEDITOR.ENTER_BR;
    config.shiftEnterMode = CKEDITOR.ENTER_P;
    //config.allowedContent = true;
    //config.disallowedContent = 'br'; 
};

