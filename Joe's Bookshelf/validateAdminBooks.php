<?php
//variables to be filled from form
$inTitle = "";
$inAuthor = "";
$inPub = "";
$inLastRead = "";
$inStatus = "";

//variables to hold error messages
$titleError = "";
$authorError = "";
$pubError = "";
$lastReadError = "";
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

function pubValidation() //must be 4 digit year
{
	global $inPub, $pubError, $validForm;
	
	$yearRegEx = "^\d{4}$^";
	
	if(!preg_match($yearRegEx, $inPub))
	{
		$validForm = false;
		$pubError = "Please enter 4 digits for the year that the book was published.<br>"; 
	}
	
	if($inPub == "")
	{
		$validForm = false;
		$pubError = "PLease enter the 4-digit year that the book was published.<br>";
	}
}

function lastReadValidation() //must be yyyy-mm-dd date
{
	global $inLastRead, $lastReadError, $validForm;
	
	$date_regex = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";

	if(!preg_match($date_regex, $inLastRead))
	{
		$validForm = false;
		$lastReadError = "Please enter the date in the yyyy-mm-dd format.<br>";
	}
	
	if($inLastRead == "")
	{
		$validForm = false;
		$lastReadError = "Please enter a date in the yyyy-mm-dd format.<br>";
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