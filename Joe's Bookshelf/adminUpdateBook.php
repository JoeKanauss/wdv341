<?php
//set variables for validation
$validForm = "";
$titleError = "";
$authorError = "";
$pubError = "";
$lastReadError = "";
$statusError = "";
$oldTitle= "";
$oldAuthor= "";
$oldPub = "";
$oldLastRead="";
$oldWantRead="";
$oldHaveRead="";
$oldCurrentRead="";
//start session
session_start();

//if the user is not "administrator", redirect to home page
if($_SESSION["username"] !== "administrator")
{
	header("Location: homepage.php");
}

else
{
//connect to database
include "wdv341DatabaseConnect.php";

	include "validateAdminBooks.php";

//set id from GET
$bookId = $_GET["id"];

//if the update form has been submitted, validate the form
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="ppStyleSheet.css">
</head>
<body>
<img class="logo" src="pplogo.gif" />
<div id="container">

<div id="logins">
<p><a class="" href="homepage.php">Home</a></p>
<p><a class="" href="login.php">Log In</a></p>
<p><a href="signUpPage.php">Sign Up</a></p>
<p><a class="selected" href="bookshelf.php">See the Bookshelf</a></p>
<p><a href="profilePage.php">Go to Profile</a></p>
<p><a href="contactPage.php">Contact</a></p>
</div>
<div id="homeMessage">
<?php

if(isset($_POST["updateBook"]))
{
	//fill variables from form
	$inTitle = $_POST["title"];
	$inAuthor = $_POST["author"];
	$inPub = $_POST["pub"];
	$inLastRead = $_POST["lastRead"];
	$inStatus = $_POST["status"];
	
	//assume the form is valid before validating
	$validForm = true;
	
	//validate the form
	titleValidation();
	authorValidation();
	pubValidation();
	lastReadValidation();
	statusValidation();

	//if the form is valid, set up and run UPDATE query for the record
	if($validForm)
	{
		$sql = "UPDATE pp_joe_book SET joe_book_title='$inTitle', joe_book_author='$inAuthor', joe_book_pub='$inPub', joe_book_last_read = '$inLastRead', joe_book_status='$inStatus' WHERE joe_book_id='$bookId'";
		
		$result = $conn->query($sql);
		
		//if the query runs successfully, display confirmation message
		if($result)
		{
?>

<h1>The book has been updated!</h1>
<p><a href="bookshelf.php">[Return to the Bookshelf]</a></p>
<?php 
		}
	}
	//else, if the form has been submitted but is not valid, present form with errors
	else
	{
		$inTitle = $_POST["title"];
		$inAuthor = $_POST["author"];
		$inPub = $_POST["pub"];
		$inLastRead = $_POST["lastRead"];
		$inStatus = $_POST["status"];
	
		//status select
		if($_POST["status"]=="Want to Read")
		{
		$inDefault = "";
		$inWantRead= "selected";
		$inHaveRead= "";
		$inCurrentRead= "";
		}
		else if($_POST["status"]=="Have Read")
		{
		$inDefault = "";
		$inWantRead= "";
		$inHaveRead= "selected";
		$inCurrentRead= "";
		}
		else if($_POST["status"]=="default")
		{
		$inDefault = "selected";
		$inWantRead= "";
		$inHaveRead= "";
		$inCurrentRead= "";
		}	
		else
		{
		$inDefault = "";
		$inWantRead= "";
		$inHaveRead= "";
		$inCurrentRead= "selected";
		}
?>
<form method="post" name="bookadd" action="adminUpdateBook.php?id=<?php echo$bookId?>">
<p>Book Title:<br>
<span class="error"><?php echo $titleError?></span>
<input type="text" name="title" value="<?php echo $inTitle;?>"></p>
<p>Book Author:<br>
<span class="error"><?php echo $authorError?></span>
<input type="text" name="author" value="<?php echo $inAuthor;?>"></p>
<p>Publication Year:<br>
<span class="error"><?php echo $pubError?></span>
<input type="text" name="pub" value="<?php echo $inPub;?>"></p>
<p>When did you last read this book?<br>
<span class="error"><?php echo $lastReadError?></span>
<input type="text" name="lastRead" value="<?php echo$inLastRead;?>"></p>
<p>Reading Status:<br>
<span class="error"><?php echo $statusError?></span>
<select name="status">
<option value="default" <?php echo $inDefault;?>>Read Status</option>
<option value="Want to Read" <?php echo $inWantRead;?>>Want to Read</option>
<option value="Have Read" <?php echo $inHaveRead;?>>Have Read</option>
<option value="Currently Reading" <?php echo $inCurrentRead;?>>Currently Reading</option>
</select>
<p><input type="submit" name="updateBook" value="Update Book" /></p>
</form>
<?php
	}
	}
//else, if the form needs to be presented, grab record data from database
else
{
	$sql="SELECT joe_book_id, joe_book_title, joe_book_author, joe_book_pub, joe_book_last_read, joe_book_status FROM pp_joe_book WHERE joe_book_id= $bookId";
	$result = $conn->query($sql);
	if($result)
	{
		foreach($result as $row);
		
		$inTitle = $row["joe_book_title"];
		$inAuthor = $row["joe_book_author"];
		$inPub = $row["joe_book_pub"];
		$inLastRead = $row["joe_book_last_read"];
		$inStatus = $row["joe_book_status"];
	
		//status select
		if($row["joe_book_status"]=="Want to Read")
		{
		$inWantRead= "selected";
		$inHaveRead= "";
		$inCurrentRead= "";
		}
		else if($row["joe_book_status"]=="Have Read")
		{
		$inWantRead= "";
		$inHaveRead= "selected";
		$inCurrentRead= "";
		}
		else
		{
		$inWantRead= "";
		$inHaveRead= "";
		$inCurrentRead= "selected";
		}
?>
<form method="post" name="bookadd" action="adminUpdateBook.php?id=<?php echo$bookId?>">
<p>Book Title:<br>
<span class="error"><?php echo $titleError?></span>
<input type="text" name="title" value="<?php echo $inTitle;?>"></p>
<p>Book Author:<br>
<span class="error"><?php echo $authorError?></span>
<input type="text" name="author" value="<?php echo $inAuthor;?>"></p>
<p>Publication Year:<br>
<span class="error"><?php echo $pubError?></span>
<input type="text" name="pub" value="<?php echo $inPub;?>"></p>
<p>When did you last read this book?<br>
<span class="error"><?php echo $lastReadError?></span>
<input type="text" name="lastRead" value="<?php echo$inLastRead;?>"></p>
<p>Reading Status:<br>
<span class="error"><?php echo $statusError?></span>
<select name="status">
<option value="default">Read Status</option>
<option value="Want to Read" <?php echo $inWantRead;?>>Want to Read</option>
<option value="Have Read" <?php echo $inHaveRead;?>>Have Read</option>
<option value="Currently Reading" <?php echo $inCurrentRead;?>>Currently Reading</option>
</select>
<p><input type="submit" name="updateBook" value="Update Book" /></p>
</form>
<?php
	}
}
?>	
</div>
</div>
</body>
</html>



