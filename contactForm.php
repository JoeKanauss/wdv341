<?php
//variables to later hold form responses
$inName = "";
$inEmail = "";
$inReason = "";
$inComments = "";

//variables to later make a drop-down selection selected
$productSelect = "";
$returnSelect = "";
$billingSelect = "";
$technicalSelect = "";
$otherSelect = ""; 

//variables to later hold form response errors, if any
$nameError = "";
$emailError = "";
$reasonError = "";
$commentsError = "";

//date and time variables
$date = date("F d, Y");
$time = date("g:i A");




//variable to determine if form is valid( initially set to "false" to return an invalid (initally blank) form)
$validForm = false;

function validateName()//name must be included and checked for special characters
{
	global $inName, $validForm, $nameError;
	
	//check for and remove special characters
	$inName = filter_var($inName , FILTER_SANITIZE_SPECIAL_CHARS);
	//Make sure name is included, and if not post error message and make form invalid
	if ($inName == "")
	{
		$validForm = false;
		$nameError = "Please enter your name.";
	}
}	

function validateEmail() //email must be in vlaid format
{
	global $inEmail, $validForm, $emailError;
	
	//sanitize email
	$inEmail = filter_var($inEmail, FILTER_SANITIZE_EMAIL);
	//Make sure email is valid, and if not post error message and make form invalid
	if(!filter_var($inEmail, FILTER_VALIDATE_EMAIL)==true)
	{
			$validForm = false;
			$emailError = "Please enter a valid email address.";
	}
}

function validateReason() //reason must be selected
{
	global $inReason, $validForm, $reasonError;
	
	//make sure a reason other than "Please Select A Reason" is selected, and if not post error message and make form invalid
	if ($inReason == "default")
	{
			$validForm = false;
			$reasonError = "Please Select a Reason.";
	}
}

function validateComments()//if reason = "other", comments must be filled in
{
	global $inComments, $validForm, $commentsError, $inReason;
		
	//sanitize comments
	$inComments = filter_var($inComments, FILTER_SANITIZE_SPECIAL_CHARS);

	//make sure if reason = "other" comments are filled in, and if not post error message and make form invalid
	if ($inReason == "other" && $inComments == "")
	{
		$validForm = false;
		$commentsError = "Plesae let us know your reason for contact.";
	}
}
	
function reasonSelected() //refill selected reason on invalid submit
{
	global $inReason, $productSelect, $returnSelect, $billingSelect, $technicalSelect, $otherSelect;
	
	if($inReason == "product")
	{
		$productSelect = "selected";
	}
	elseif($inReason == "return")
	{
		$returnSelect = "selected";
	}
	elseif($inReason == "billing")
	{
		$billingSelect = "selected";
	}
	elseif($inReason == "technical")
	{
		$technicalSelect = "selected";
	}
	elseif($inReason == "other")
	{
		$otherSelect = "selected";
	}
}	

	
//function to determine if the "submit" button has been pressed (a form has been submitted)
if (isset($_POST["submit"]))
{ 
	$inName = $_POST["name"];
	$inEmail = $_POST["email"];
	$inReason = $_POST["reason"];
	$inComments = $_POST["comments"];
	
	$validForm = true;
	
	validateName();
	validateEmail();
	validateReason();
	validateComments();
	reasonSelected();
}
	
?>




<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WDV341 Intro PHP - Form Processing</title>
<style>
.error {
	color: red;
	font-style: italic;
	line-height: 0;
}
body {
	background-color: #cce0ff;
}

#container {
	width: 75%;
	margin: 2% 10%;
	border: 2px solid black;
	text-align: center;
	background-color: #e6f0ff;
}

input[type=text] {
	background-color: #ffffcc;
}

select {
	background-color: #ffffcc;
}

textarea {
	background-color: #ffffcc;
}
</style>

</head>

<body>

<?php
//if form is valid, print confirmation page and email confirmation to website owner
if ($validForm)
{
	global $date, $time;
	$to = "jakanauss@dmacc.edu";
	$subject = "Contact Form Confirmation";
	$from = "from: web@joekanauss.info";
	$message = "A new contact form has been submitted. Here is the provided information:\r\n\nNAME: $inName\r\n\nEMAIL: $inEmail\r\n\nREASON: $inReason\r\n\nCOMMENTS: $inComments\r\n\n This information was sent at $time on $date.";
	
	if(mail($to, $subject, $message, $from))
	{
?>
<div id="container">
<h2>Thank you for Contacting Us!</h2>
<h3>This is the infromation we recieved:</h3>
<p><strong>Name:</strong> <?php echo$inName?> </p>
<p><strong>Email:</strong> <?php echo$inEmail?></p>
<p><strong>Reason for Contact:</strong> <?php echo$inReason?></p>
<p><strong>Comments:</strong> <?php echo$inComments?></p>

<p>The information was sent at <?php echo$time?> on <?php echo$date?>.</p>
</div>

<?php
	}
	else
	{
?>
<div id="container">
<h2> Oh No! Something went wrong and we were not able to recieve your information.</h2>
<h2>:(</h2>
<h3>Please try again.</a></p>
</div>
<?php
	}
}
else
{
?>
<div id="container">
<h1>PHP Contact Page with Validation</h1>
<form name="form1" method="post" action="contactForm.php">
  <p>&nbsp;</p>
  <p>
    <label>Your Name:
      <input type="text" name="name" id="name" value="<?php echo$inName?>">
    </label>
	</p>
	<p class="error"><?php echo$nameError?></p>
  <p>Your Email: 
    <input type="text" name="email" id="email" value="<?php echo$inEmail?>"></p>
	<p class="error"><?php echo$emailError?></p>
  <p>Reason for contact: 
    <label>
      <select name="reason" id="reason">
        <option value="default">Please Select a Reason</option>
        <option value="product" <?php echo$productSelect?>>Product Problem</option>
        <option value="return" <?php echo$returnSelect?>>Return a Product</option>
        <option value="billing" <?php echo$billingSelect?>>Billing Question</option>
        <option value="technical" <?php echo$technicalSelect?>>Report a Website Problem</option>
        <option value="other" <?php echo$otherSelect?>>Other</option>
      </select>
    </label>
	</p>
	<p class="error"><?php echo$reasonError?></p>
  <p>
    <label>Comments:
      <textarea name="comments" id="textarea" cols="45" rows="5"><?php echo$inComments?></textarea>
    </label> 
	</p>
	<p class="error"><?php echo$commentsError?></p>
  <p>
    <input type="hidden" name="hiddenField" id="hiddenField" value="application-id:US447">
  </p>
  <p>
    <input type="submit" name="submit" id="submit" value="Submit">
    <input type="reset" name="button2" id="button2" value="Reset">
  </p>
</form>
<p>&nbsp;</p>
</div>
</body>

<?php
}
?>
</html>