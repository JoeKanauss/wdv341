<?php 

include 'UserContactClass.php';

	$firstContact = new UserContact(); //instantiate new object
	
	$firstContact->set_name($_POST["textfield"]); //load name into object
	
	$firstContact->set_email($_POST["textfield2"]);
	
	$firstContact->set_reason($_POST["select2"]);
	
	$firstContact->set_comments($_POST["textarea"]);
	
	$firstContact->set_mailingList($_POST["checkbox"]);
	
	$firstContact->set_moreInfo($_POST["checkbox2"]);
	
	$firstContact->set_contactDate(date("F d, Y"));
?>	
<html>
<body>	
	
	<?php echo "<p>" . $firstContact->get_name()."</p>";
	
	echo "<p>" . $firstContact->get_email() . "</p>";
	
	echo "<p>". $firstContact->get_reason() . "</p>";
	
	echo "<p>" . $firstContact->get_comments()."</p>";
	
	echo "<p>" . $firstContact->get_mailingList()."</p>";

	echo "<p>" . $firstContact->get_moreInfo()."</p>";
	
	echo "<p>" . $firstContact->get_contactDate()."</p>";

	echo $firstContact->formatHTMLMessage();
	
	echo $firstContact->formatMailMessage();
	
	echo $firstContact -> sendEmail();
?>