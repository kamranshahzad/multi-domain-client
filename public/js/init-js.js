// JavaScript Document

$(document).ready(function(){	
	
	observerEvents();
	initEvents();
});


function observerEvents(){}

function initEvents(){
	
	if ($("#NewsletterForm").length != 0) {
		$('#newsletterButton').click(function () { 
			if(validateNewsletterForm()){
				$("#NewsletterForm").submit();
			}else{
				return false;
			}
		});
	}
	
	// contact us form
	if ($("#contactFrm").length != 0) {
		$('#contactUsButtton').click(function () { 
			if(validateContactForm()){
				$("#contactFrm").submit();
			}else{
				//$('html, .left-content').animate({ scrollTop: 0 }, 'slow');
				return false;
			}
		});
		$('#fullname').blur(function() {
			 checkBlack('fullname','',false );
		});
		$('#email').blur(function() {
			 checkEmail('email',false );
		});
		$('#phone').blur(function() {
			 checkBlack('phone','',false );
		});
		$('#comments').blur(function() {
			 checkBlack('comments','',false );
		});
		$('#scode').blur(function() {
			 checkBlack('scode','',false );
		});
		
	}
} //$initEvents




/*
	_validate newsletter form
*/
function validateNewsletterForm(){
	
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	
	var name  = $('#nameField').val();
	var email = $('#emailField').val();
	var captachtext = $('#scode').val();
	var gatevalue = $('#allowcode').val();
	
	if(name == ""){
		alert("Please enter your name.");
		validArray2.add('name', false);
		return false;	
	}else{
		validArray2.add('name', true);
	}
	if(email == ""){
		alert("Please enter your email.");
		validArray2.add('email', false);
		return false;		
	}else{
		var response = reg.test(email);
		if(response){
			validArray2.add('email', true);
		}else{
			alert("Invalid email address.");
			validArray2.add('email', false);
			return false;	
		}
	}
	if(captachtext == ""){
		alert("Enter security code!");
		validArray2.add('scode', false);
	}else{
		 if(captachtext == gatevalue){
			validArray2.add('scode', true); 
		 }else{
			alert("Enter valid security code!");
			validArray2.add('scode', false); 
		 }
	}
	
	
	
	var result = true;
	var obj = validArray2.getObj();
	for (var prop in obj) {
		if(obj[prop] == false){
			result = false;
		}
	}
	return result;		
}


/*
	_ validate contact us
*/
function validateContactForm(){
	
	checkBlack('fullname','',true);
	checkEmail('email',true);
	checkBlack('phone','',true);
	checkBlack('comments','',true);
	
	checkCaptcha('scode' , 'contact', true);
	
	var result = true;
	var obj = validArray.getObj();
	for (var prop in obj) {
		if(obj[prop] == false){
			result = false;
		}
	}
	return result;	
}




/*
	_core functions
*/
window.validArray = (function () {
  var obj = {};
  return {
	getObj: function () {return obj;} 
	, add: function (key, data) {
		obj[key] = data;
		return this; // enabling chaining
	  }
  }
})();

window.validArray2 = (function () {
  var obj = {};
  return {
	getObj: function () {return obj;} 
	, add: function (key, data) {
		obj[key] = data;
		return this; // enabling chaining
	  }
  }
})();




function checkEmail(emailId , bool){
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		var errorLbl = 'errLbl'+emailId;
		var val = $('#'+emailId).val();
		var response = reg.test(val);
		var errorText = "Invalid email address.";
		if(val != "" && response == true){
			if ($('#'+errorLbl).length != 0) {
				$('#'+errorLbl).remove();
			}
			response = true;
		}else{
			if ($('#'+errorLbl).length == 0) {
				$('<label id="'+errorLbl+'" class="error">'+errorText+'</label>').appendTo($('#wp-'+emailId));	
			}
		}
		validArray.add(emailId, response);
		if(bool){
				return response;
		}
}
	
	
function checkBlack(fieldId , errorMsg , bool){
		   
		var response = false;
		 var val = $('#'+fieldId).val();
		 var errorLbl = 'errLbl'+fieldId;
		 var errorText = 'This field is required.';
		 if(errorMsg != ''){
			 errorText = errorMsg;
		 }
		 if(val != ""){
			 if ($('#'+errorLbl).length != 0) {
				$('#'+errorLbl).remove();
			 }
			 response = true;
		}else{
			
			if ($('#'+errorLbl).length == 0) {
				$('<label id="'+errorLbl+'" class="error">'+errorText+'</label>').appendTo($('#wp-'+fieldId));	
			}
		}
		validArray.add(fieldId, response);
		
		if(bool){
			return response;
		}
}

function checkCaptcha(fieldId ,prefix, bool){
		   
		var response = false;
		var val = $('#'+ prefix + fieldId).val();
		var gatevalue = $('#'+ prefix + 'allowcode').val();
		var errorLbl = 'errLbl'+fieldId;
		
		if(val != ""){
			 if(val == gatevalue){
				 if ($('#'+errorLbl).length != 0) {
					$('#'+errorLbl).remove();
				 }
				 response = true; 
			 }else{
				if ($('#'+errorLbl).length == 0) {
					$('<label id="'+errorLbl+'" class="error" style=" display: inline;">Enter valid security code!</label>').appendTo($('#wp-'+fieldId));	
				}
				if ($('#'+errorLbl).length > 0) {
					$('#'+errorLbl).remove();
					$('<label id="'+errorLbl+'" class="error" style=" display: inline;">Enter valid security code!</label>').appendTo($('#wp-'+fieldId));	
				}
			 }
		 }else{
			if ($('#'+errorLbl).length == 0) {
				$('<label id="'+errorLbl+'" class="error" style=" display: inline;">Enter security code!</label>').appendTo($('#wp-'+fieldId));	
			}
		}
		validArray.add(fieldId, response);
		
		if(bool){
			return response;
		}
}

// validate plugin


