function validateAnonForm(){
		
		var validAnonForm = true;
		
		var anonMessage = $("#anonMessage").val();
		var anonMessageRegEx = new RegExp(/[a-zA-Z0-9,.!?;" ]$/);
		var anonMessageValid = anonMessageRegEx.test(anonMessage);
		
		if(anonMessage.trim() == ""){
			$("#anonMessageError").html("Please enter your message");
			validAnonForm = false;
		}
		else if( (anonMessage.trim() != "") && (!anonMessageValid) ){
			$("#anonMessageError").html("Please use only numbers, letters, spaces, and basic punctuation(.,!?&ldquo;') in your message");
			validAnonForm = false;
		}
		else{
			$("#anonMessageError").html("");
		}	
		
		alert(validAnonForm);
		
		if(validAnonForm){
			$("#anonContactForm").submit();
		}
}

var validSignedForm = true

function validateSignedName(){
	var signedName = $("#signedName").val();
	var signedNameRegEx = new RegExp(/^[a-zA-Z0-9 ]*$/);
	var validSignedName = signedNameRegEx.test(signedName);
	
	if(signedName.trim() == ""){
		$("#signedNameError").html("Please enter your name");
		validSignedForm = false;
	}
	else if( (signedName.trim() != "") && (!validSignedName) ){
		$("#signedNameError").html("Please use only numbers and/or letters in your name");
		validSignedForm = false;
	}
	else{
		$("#signedNameError").html("");
	}
}

function validateSignedEmail(){
	var signedEmail = $("#signedEmail").val();
	var signedEmailRegEx = new RegExp(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/);
	var validSignedEmail = signedEmailRegEx.test(signedEmail);
	
	if(signedEmail.trim() == ""){
		$("#signedEmailError").html("Please enter your email address");
		validSignedForm = false;
	}
	else if( (signedEmail.trim() != "") && (!validSignedEmail) ){
		$("#signedEmailError").html("Please enter a valid email");
		validSignedForm = false;
	}
	else{
		$("#signedEmailError").html("");
	}
}

function validateSignedMessage(){
		
	
		
	var signedMessage = $("#signedMessage").val();
	var signedMessageRegEx = new RegExp(/[a-zA-Z0-9,.!?;" ]$/);
	var signedMessageValid = signedMessageRegEx.test(signedMessage);

	if(signedMessage.trim() == ""){
		$("#signedMessageError").html("Please enter your message");
		validSignedForm = false;
	}
	else if( (signedMessage.trim() != "") && (!signedMessageValid) ){
		$("#signedMessageError").html("Please use only numbers, letters, spaces, and basic punctuation(.,!?&ldquo;') in your message");
		validSignedForm = false;
	}
	else{
		$("#signedMessageError").html("");
	}	
}


function validateSignedForm(){
	validSignedForm = true;
	validateSignedName();
	validateSignedEmail();
	validateSignedMessage();
	
	alert(validSignedForm);
	
	if(validSignedForm){
		$("#signedContactForm").submit();
	}
}
