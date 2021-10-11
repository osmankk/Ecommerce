$(function () {
	'use strict';
	$('[placeholder]').focus(function () {
	$(this).attr('data-text',$(this).attr('placeholder'));
	$(this).attr('placeholder','');
	}).blur(function () {
	$(this).attr('placeholder',$(this).attr('data-text'));
	});
	
});
// add asterisk on required field
$('input').each(function () {
	if ($(this).attr('required')==='required'){
		$(this).after("<span class='asterisk'> * </span>");
	}
	
});
//show pass 
$('.show-pass').hover(function () {
 $('.password').attr('type','text')	
},function () {
	$('.password').attr('type','password')	
});
//confirmation delete
$('.comfirm').click(function () {
	return confirm('ARE YOU SURE TO DELETE THIS MEMBER ?')
});

