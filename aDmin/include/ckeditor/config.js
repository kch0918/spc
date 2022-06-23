/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */


CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	config.font_defaultLabel = '돋움';
	
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

	//toolbar 버튼 삭제
	config.removeButtons = 'Print,Save,Preview,NewPage,Smiley,Flash,PageBreak,Anchor,Language,ShowBlocks,Iframe,ImageButton,Select,HiddenField,Textarea,TextField,Subscript,Superscript,CopyFormatting,CreateDiv,Templates,Cut,Copy,Undo,Redo,Replace,Find,SelectAll,BidiRtl,BidiLtr';

	//붙여넣기 시 자동으로 형식이 바뀌는 것 방지
	config.pasteFilter = null;

	//글씨체 추가
	config.font_names = '굴림/Gulim;돋움/Dotum;바탕/Batang;궁서/Gungsuh;Arial/Arial;Comic Sans MS/Comic Sans MS;Courier New/Courier New;Georgia/Georgia;Lucida Sans Unicode/Lucida Sans Unicode;Tahoma/Tahoma;Times New Roman/Times New Roman;Trebuchet MS/Trebuchet MS;Verdana/Verdana';

	config.filebrowserUploadUrl = '/aDmin/include/ckeditor/upload/upload.php'
		
	config.filebrowserUploadMethod = 'form';
	
	// 지윤추가
	//CKEDITOR.dtd.$removeEmpty['i'] = false;
	config.fillEmptyBlocks = false;
	//CKEDITOR.config.fillEmptyBlocks = false;
	//CKEDITOR.config.fullPage = false;
	config.enterMode = CKEDITOR.ENTER_BR;
    //config.shiftEnterMode = CKEDITOR.ENTER_BR;
    //config.allowedContent = true;
    //config.disallowedContent = 'br'; 
	
};

