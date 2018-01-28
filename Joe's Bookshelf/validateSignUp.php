<?php
//variables to be filled from form
$inUsername = "";
$inPassword = "";

//variables to hold error messages
$usernameError = "";
$passwordError = "";

//variable to determine if form is valid (initially set to "false" to return an invalid (initially blank) form)
$validForm = false;

//form validation functions

function validateUsername() //must be letters and numbers only
{
	global $inUsername, $usernameError, $validForm;
	
	$nameRegEx = "/^[a-zA-Z\d]+$/";
	
	if(!preg_match($nameRegEx, $inUsername))
	{
		$validForm = false;
		$usernameError = "Your username should contain letters and numbers only.<br>";
	}
	if($inUsername == "")
	{
		$validForm = false;
		$usernameError = "Please enter a username using only letters and numbers.<br>";
	}
}

function validatePassword() 
{
	global $inPassword, $passwordError, $validForm;
	
	$passRegEx = "/^[a-zA-Z\d]+$/";
	
	if(!preg_match($passRegEx, $inPassword))
	{
		$validForm = false;
		$passwordError = "Your password should contain letters and numbers only.<br>";
	}
	if($inPassword == "")
	{
		$validForm = false;
		$passwordError = "Please enter a password using only letters and numbers.<br>";
	}
}

//function to determine of the form has been submitted
if(isset($_POST["submitInfo"]))
{
	//fill variables from form
	$inUsername = $_POST["newUsername"];
	$inPassword = $_POST["newPassword"];
	
	//assume the form is valid before validating
	$validForm = true;
	
	//validate form
	validateUsername();
	validatePassword();
}
?>