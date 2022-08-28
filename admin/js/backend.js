$(function () {
	'use strict';
	$('.toggle-info ').click(function () {
		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
		if ($(this).hasClass('selected')) {
			$(this).html("<i class='glyphicon glyphicon-plus'></i>");
		}else{
			$(this).html("<i class='glyphicon glyphicon-minus'></i>");
		}
	});
	//
	$('select').selectBoxIt({
		autoWidth:false
	});
	//
	$('[placeholder]').focus(function () {
	$(this).attr('data-text',$(this).attr('placeholder'));
	$(this).attr('placeholder','');
	}).blur(function () {
	$(this).attr('placeholder',$(this).attr('data-text'));
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
	return confirm('ARE YOU SURE TO DELETE IT ?')
});
$('.categories  h3').click(function () {
	$(this).next(".full-view").fadeToggle(200);
});
$('.categories .sort span ').click(function () {
	$(this).addClass('active').siblings('span').removeClass('active');
	
	if ($(this).hasClass('full')){

		$('.categories .full-view').fadeIn(200);
	}else{
        $('.categories .full-view').fadeOut(200);
	}
	
});

});
