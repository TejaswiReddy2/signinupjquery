$(document).ready(function(){
	// Form Validation
    $("#currentPageForm").validate({
		rules:{
			new_password: { minlength: 6, maxlength: 25 },
			conf_password: { minlength: 6, equalTo: "#new_password" },
	        admin_mobile_number:{ minlength:10, maxlength:15, numberandsign:true },
			vendor_mobile_number:{ minlength:10, maxlength:15, numberandsign:true }
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.form-group-inner').removeClass('success');
			$(element).parents('.form-group-inner').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group-inner').removeClass('error');
			$(element).parents('.form-group-inner').addClass('success');
		}
	});

	jQuery.validator.addMethod("numberonly", function(value, element) 
	{
		return this.optional(element) || /^[0-9]+$/i.test(value);
	}, "Number only please");
});

 // Cookies
function createCookie(name, value, days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		var expires = "; expires=" + date.toGMTString();
	}
	else var expires = "";               
	document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length).replace(/%2F/gi,'/').replace(/\+/gi,' ').replace(/\%26%23xa3%3B/gi,'&#xa3;');
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name, "", -1);
}
$(function(){
	// check and create cart cookie
	if(!readCookie('currentCartCookie')){
		var randomNumber = getRandomInt(1000000000000000,9999999999999999); 
		createCookie('currentCartCookie', randomNumber, 365);
		window.location.reload();
	} 
	// check and create recent view cookie
	if(!readCookie('recentViewCookie')){
		var randomNumber = getRandomInt(1000000000000000,9999999999999999); 
		createCookie('recentViewCookie', randomNumber, 365);
		window.location.reload();
	} 
});
function getRandomInt(min, max) {
	return Math.floor(Math.random() * (max - min)) + min;
} //The maximum is exclusive and the minimum is inclusive
$(document).on('change','#Data_Form #showLength',function(){ 
	$('#Data_Form').submit();														 
});

$(document).on('keypress','#Data_Form #searchValue',function(e){ 
	if (e.keyCode == '13') { 
		var searchField 	=	$('#Data_Form #searchField').val(); 
		var searchValue 	=	$('#Data_Form #searchValue').val(); 
		if(searchField){	
			if(!searchValue){	$('#Data_Form #searchField').val('');	}
			$('#Data_Form').submit();
		} else {	
			alertMessageModelPopup('Please Select Search Field','Warning');
			return false;
		}
    }																  
});

$(document).on('change','#Data_Form #searchField',function(){ 
	var searchField 	=	$('#Data_Form #searchField').val(); 
	var searchValue 	=	$('#Data_Form #searchValue').val(); 
	if(searchField && searchValue){	
		$('#Data_Form').submit();
	} else if(searchValue){
		$('#Data_Form #searchValue').val('');
		$('#Data_Form').submit();
	}												 
});