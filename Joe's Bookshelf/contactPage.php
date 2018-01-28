<?php
//Start session
session_start();

if(isset($_POST["contactSubmit"]))
{
	//set form variables
	$contactName = $_POST["contactName"];
	$contactEmail = $_POST["contactEmail"];
	$adminEmail = "penpaperjoe@gmail.com";
	$fromEmail = "from: web@joekanauss.info";
	$contactComments= $_POST["contactComments"];
	$sendAdminFail = "";
	$sendAdminSuccess = "";
	$sendContactMessage = "";
	
	// set up email to admin
	$to = $adminEmail;
	$subject = "Bookshelf Contact Form";
	$from = $fromEmail;
	$message = "A new contact form has been filled out!\r\n\n From: $contactName\r\nComments:\r\n -- $contactComments --";
	
	//send admin  email and fill success/fail messages accordingly
	if(mail($to, $subject, $message, $from))
	{
		$sendAdminSuccess = "Your contact form was sent!";
		$sendAdminFail = "";
		
		//set up email to contacter 
		$to2 = $contactEmail;
		$subject2 = "Joe's Bookshelf Contact Confirmation";
		$from2 = $fromEmail;
		$message2 = "Hi $contactName!\r\n\nThank you for sending us your comments!\r\n\nWe hope you're enjoying your time on Joe's Bookshelf and wish you happy readings!";
		
		//send admin  email and fill success/fail messages accordingly
		if(mail($to2, $subject2, $message2, $from2))
		{
			$sendContactMessage = "We'll send a confirmation email to the address you gave us.";
		}
		else
		{
			$sendContactMessage = "";
		}	
	}
	else
	{
		$sendAdminSuccess = "";
		$sendAdminFail = "Uh-Oh! Your contact form was not sent! Please try again!";
	}
	
	
}

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet"  href="ppStyleSheet.css">
</head>
<body>
<img class="logo" src="pplogo.gif" />
<div id="container">

<div id="logins">
<p><a href="homepage.php">Home</a></p>
<p><a href="login.php">Log In</a></p>
<p><a href="signUpPage.php">Sign Up</a></p>
<p><a href="bookshelf.php">See the Bookshelf</a></p>
<p><a href="profilePage.php">Go to Profile</a></p>
<p><a class="selected" href="contactPage.php">Contact</a></p>
</div>

<div id="homeMessage">

<?php
//if the contact form has been submitted...
if(isset($_POST["contactSubmit"]))
{
	//display message
?>
<h2 class="contactMsg"><?php echo$sendAdminFail."<br>".$sendAdminSuccess."<br>".$sendContactMessage."<br><a href='homepage.php'>[Go to the Homepage]</a>"?></h2>
<?php
	//if the email failed to send and contact user has to try again...
	if($sendAdminFail !== "")
	{
		//show the contact form with filled in fields
?>
<form class="contactForm" method="post" action="contactPage.php">
<p>User Name: <input type="text" name="contactName" value="<?php echo$contactName;?>"/></p>
<p>Email: <input type="text" name="contactEmail"value="<?php echo$contactEmail;?>"/></p>
<p>Comments, Questions, Suggestions:<br> <textarea name="contactComments" cols="80" rows="20"/><?php echo$contactComments;?></textarea></p>
<p><input type="submit" name="contactSubmit" value="Send Information" /></p>
</form>
<?php
	}
}
else
{
?>

<h1 class="intro"> We want to hear from you!</h1>
<p>Do you have any questions, comments, or suggestions? We'd love to hear them!</p>

<?php

//if the ValidUser index is set...
if(isset($_SESSION["validUser"]))
{
	//if the user is a valid user...
	if($_SESSION["validUser"] == "Yes")
	{
		//display form with User Name field and the username inserted
?>

<form class="contactForm" method="post" action="contactPage.php">
<p>User Name: <input type="text" name="contactName" value="<?php echo$_SESSION["username"];?>"/></p>
<p>Email: <input type="text" name="contactEmail" /></p>
<p>Comments, Questions, Suggestions:<br> <textarea name="contactComments" cols="80" rows="20"/></textarea></p>
<p><input type="submit" name="contactSubmit" value="Send Information" /></p>
</form>
<?php
	}
	//else, if the user is not a valid user...
	else
	{
		//display form with Name field and have it empty.
?>
<form class="contactForm" method="post" action="contactPage.php">
<p>Name: <input type="text" name="contactName" /></p>
<p>Email: <input type="text" name="contactEmail" /></p>
<p>Comments, Questions, Suggestions:<br> <textarea name="contactComments" cols="80" rows="20"/></textarea></p>
<p><input type="submit" name="contactSubmit" value="Send Information" /></p>
</form>

<?php 
	}
}
//else, if the ValidUser index is not set...
else
{
	//display form with Name field and have it empty.
?>
<form class="contactForm" method="post" action="contactPage.php">
<p>Name: <input type="text" name="contactName" /></p>
<p>Email: <input type="text" name="contactEmail" /></p>
<p>Comments, Questions, Suggestions:<br> <textarea name="contactComments" cols="80" rows="20"/></textarea></p>
<p><input type="submit" name="contactSubmit" value="Send Information" /></p>
</form>

<?php
}
}
?>
</div>
</div>
</body>
</html>