<?php

//variables to later hold form responses
$inName = "";
$inSocialSecurity = "";
$inResponse = "";

//variables to later make a radio button selected

$phoneSelected = "";
$emailSelected = "";
$usMailSelected = "";



//variables to later hold form response errors, if any
$nameError = "";
$socialSecurityError = "";
$responseError = "";

//variable to determine if form is valid( initially set to "false" to return an invalid (initally blank) form)
$validForm = false;

//function to check if a valid name has been entered (must be filled in with no leading spaces)
function validateName()
{
	//Use global versions of variables
	global $inName, $validForm, $nameError;
	
	//if the Name is valid, the NameError message will be blank
	$nameError = "";
	$inName = trim($inName);
	
	if ($inName == "")
	{
		//if there is no name posted, the form is not valid and the error message will be filled
		$validForm = false;
		$nameError = "Please enter your name.";
	}
}

//function to check if a valid SSN has been entered (must be numeric, no hyphens, correct size)
function validateSocialSecurity()
{
	global $inSocialSecurity, $validForm, $socialSecurityError; 
	$socialSecurityError = "";

	if (!preg_match("^\d{9}$^", $inSocialSecurity))
		{ 
			////if the posted SSN is not in an xxx-xx-xxxx pattern, the form is not valid and the socialSecurityError message is filled
			$validForm = False;
			$socialSecurityError = "Please enter a valid SSN (9 unbroken digits).";
		}
}

//function to check if a valid response has been entered (one must be chosen)
function validateResponse()
{
	global $inResponse, $validForm, $responseError;
	$responseError = "";
	
	if($inResponse == "")
	{
		// if a response is not selected, the form is not valid and the responseError message is filled
		$validForm = false;
		$responseError = "Please select a response.";
	}
}

//function to determine which radio button should be selected
function radioSelect()
{
	global $inResponse, $phoneSelected, $emailSelected, $usMailSelected;
	
	$phoneSelected = "";
	$emailSelected = "";
	$usMailSelected= "";
	
	if($inResponse == "phone")
	{
			$phoneSelected = "checked";	
	}
	elseif ($inResponse == "email")
	{
		$emailSelected = "checked";
		
	}
	elseif ($inResponse =="usMail")
	{
		$usMailSelected = "checked";
	}
}

//function to determine if the "submit" button has been pressed (a form has been submitted)
if (isset($_POST["submit"]))
{
	//if form has been submitted, fill variables with posted content
	$inName = $_POST["inName"];
	$inSocialSecurity = $_POST["inSocial"];
	$inResponse = $_POST["inResponse"];

	//assume, before validation, that the form is valid (think positive!)
	$validForm = True;
	
	//run validation functions
	validateName();
	validateSocialSecurity();
	validateResponse();
	radioSelect();
}
?>

<!DOCTYPE html>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WDV341 Intro PHP - Form Validation Example</title>
<style>

#orderArea	{
	width:600px;
	background-color:#CF9;
}

.error	{
	color:red;
	font-style:italic;	
}
</style>
</head>

<body>
<h1>WDV341 Intro PHP</h1>
<h2>Form Validation Assignment

<?php

//if the form is valid, print a confirmation page
if ($validForm)
{
?>

<h1>Thank You!</h1>

<?php

//if the form is not valid, reprint the form with error messages
}
else
{

?>
</h2>
<div id="orderArea">
  <form id="form1" name="form1" method="post" action="formValidationAssignment.php">
  <h3>Customer Registration Form</h3>
  <table width="587" border="0">
    <tr>
      <td width="117">Name:</td>
      <td width="246"><input type="text" name="inName" id="inName" size="40" value="<?php echo$inName?>"/></td>
      <td width="210" class="error"><?php echo$nameError?></td>
    </tr>
    <tr>
      <td>Social Security</td>
      <td><input type="text" name="inSocial" id="inSocial" size="40" value="<?php echo$inSocialSecurity?>" /></td>
      <td class="error"><?php echo$socialSecurityError ?></td>
    </tr>
    <tr>
      <td>Choose a Response</td>
      <td><p>
        <label>
          <input type="radio" name="inResponse" id="inResponse1" value="phone" <?php echo$phoneSelected?>>
          Phone</label>
        <br>
        <label>
          <input type="radio" name="inResponse" id="inResponse2" value="email" <?php echo$emailSelected?>>
          Email</label>
        <br>
        <label>
          <input type="radio" name="inResponse" id="inResponse3" value="usMail" <?php echo$usMailSelected?>>
          US Mail</label>
        <br>
      </p></td>
      <td class="error"><?php echo$responseError?></td>
    </tr>
  </table>
  <p>
    <input type="submit" name="submit" id="button" value="Register" />
    <input type="reset" name="button2" id="button2" value="Clear Form" />
  </p>
</form>
</div>

</body>
<?php

}
?>
</html>