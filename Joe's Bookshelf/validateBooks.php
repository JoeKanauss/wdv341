<?php
//variables to be filled from form
$inTitle = "";
$inAuthor = "";
$inFavorite = "";
$inStatus = "";

//variables to hold error messages
$titleError = "";
$authorError = "";
$favoriteError = "";
$statusError = "";

//variable to determine if form is valid (initially set to "false" to return an initially blank form)
$validForm = false;

//form validation functions

function titleValidation() //must be filled in, must only be letters, numbers, and basic punctuation
{
	global $inTitle, $titleError, $validForm;
	
	$titleRegEx = "/^[A-Za-z0-9 .,!?]/";
	
	if(!preg_match($titleRegEx, $inTitle))
	{
		$validForm = false;
		$titleError = "Please enter the title of book, using only letters, numbers, and/or basic punctuation.<br>";
	}
	if($inTitle == "")
	{
		$validForm = false;
		$titleError = "Please enter the title of the book.<br>";
	}
	
}

function authorValidation() //must be filled in, must only be letters
{
	global $inAuthor, $authorError, $validForm;
	
	$authorRegEx = "/^[A-Za-z\s]+$/";
	
	if(!preg_match($authorRegEx, $inAuthor))
	{
		$validForm = false;
		$authorError = "Please include only letters and spaces in the author's name.<br>";
	}
	if($inAuthor == "")
	{
		$validForm = false;
		$authorError = "Please enter the book's author, using only letters and spaces.<br>";
	}
	
}

function favoriteValidation() // one must be checked
{
	global $inFavorite, $favoriteError, $validForm;
	
	if($inFavorite == "noneSelected")
	{
		$validForm = false;
		$favoriteError = "PLease select &ldquo;Yes&rdquo; or &ldquo;No&rdquo;.<br>";
	}
}

function statusValidation() //must not be set to Default
{
	global $inStatus, $statusError, $validForm;
	
	if($inStatus == "default")
	{
		$validForm = false;
		$statusError = "Please select the reading status of the book.<br>";
	}
}

//if the form has been submitted

?>