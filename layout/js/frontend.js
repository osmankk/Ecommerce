$(function () {
	'use strict';
	// switch between login nd signup 
	$('.login h1').click(function () {
		$(this).next('form').fadeIn().siblings('form').fadeOut();
	});
	//trigger the selectboxit
	$('select').selectBoxIt({
		autoWidth:false
	});
	//placeholder on form focus
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

//confirmation delete
$('.comfirm').click(function () {
	return confirm('ARE YOU SURE TO DELETE IT ?')
});


$('.name-live').keyup(function () {

	$('.live-preview .caption h2').text($(this).val());
});
$('.Description-live').keyup(function () {


	$('.live-preview .caption p').text($(this).val());
});
$('.Price-live').keyup(function () {


	$('.live-preview .price-tag').text("$"+$(this).val());
});
});
