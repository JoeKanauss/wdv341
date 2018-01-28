<?php

$name = $_POST["name"];
$email = $_POST["email"];
$reason = $_POST["reason"];
$comments = $_POST["comments"];
$mailingList = isset($_POST["mailingList"]);
$moreInfo = isset($_POST["moreInfo"]);

$sendFail = "";
$sendSuccess = "";

$fail = "";

if ($mailingList == TRUE)
{
	$mailingListLine = "We are happy to be including on our mailing list! It contains great product offers, information, and other great related items!\r\n\n";
}
else
{
	$mailingListLine="";
}

if ($moreInfo == TRUE)
{
		$moreInfoLine = "We are excited to provide you with more information regarding our products!\r\n\n";
}
else
{
		$moreInfoLine = "";
}


$to = $_POST["email"]; 
$to .= ",jakanauss@dmacc.edu";
$subject = "Contact Form Confirmation";
$from = "from: web@joekanauss.info";
$message = " Dear $name,\r\n\n Thank you for taking the time to fill out our contact form. We understand that you have a comment regarding the $reason category.\r\n\n Your comments are incredibly valuable to us and we will get back to you in a prompt and orderly fashion using the information your provided for us.\r\n\n$mailingListLine$moreInfoLine Thank You!\r\n\n___________________________________\r\n\nTHE INFORMATION YOU PROVIDED:\r\n\nName: $name\r\n\nEmail: $email\r\n\nReason: $reason\r\n\nYour Comment: $comments";

if (mail($to, $subject, $message, $from))
{
	$sendSuccess = "Your information was successfully sent! Thank you for your time!";
	$sendFail = "";
}
else
{
	
	$sendFail = "Uh-Oh! Something happened and your information was not sent. Please try again :(";
	$sendSuccess = " ";
	$fail = "fail";
	
}	
?>

<html>
<head>
<style>


.fail {
	display: none;
}

body {
	background-color: #cce0ff;
}

#form {
	width: 75%;
	border: 2px solid black;
	text-align: center;
	margin:  10%;
	padding: 1%;
	background-color: #e6f0ff;
}



</style>
</head>
<body>
<div id="container">

<div id="form">
<h1><?php echo "$sendSuccess"; echo "$sendFail";?></h1>

<h3 class="<?php echo"$fail"?>">This is the Information You Provided:</h3>

<p class="<?php echo"$fail"?>"><strong>NAME:</strong> <?php echo"$name"?></p>
<p class="<?php echo"$fail"?>"><strong>EMAIL:</strong> <?php echo"$email"?></p>
<p class="<?php echo"$fail"?>"><strong>REASON:</strong> <?php echo"$reason"?></p>
<p class="<?php echo"$fail"?>"><strong>COMMENTS:</strong> <?php echo"$comments"?></p>

<h4 class="<?php echo"$fail"?>">A confirmation email will be sent to the provided email address.</h4>
<h2 class="<?php echo"$fail"?>">Thank You!</h2>
</div>

</div>
</body>
</html>