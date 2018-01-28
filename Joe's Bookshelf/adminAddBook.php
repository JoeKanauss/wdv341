<?php
//start session
session_start();

//if the user is not "administrator", redirect to home page
if($_SESSION["username"] !== "administrator")
{
	header("Location: homepage.php");
}
else
{
//define variables used in validation

$inDefault="";
$inWantRead="";
$inHaveRead="";
$inPub = "";
$inLastRead = "";
$inCurrentRead="";
$titleError = "";
$authorError = "";
$pubError = "";
$lastReadError = "";
$statusError = "";
$validForm = "";

//include bookValidation
include "validateAdminBooks.php";

if(isset($_POST["addBook"]))
{
	//fill variables from form
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
	
	//assume the form is valid before validating
	$validForm = true;
	
	//validate the form
	titleValidation();
	authorValidation();
	pubValidation();
	lastReadValidation();
	statusValidation();	
	//if form is valid...
	if ($validForm)
	{
		//connect to database
		include "wdv341DatabaseConnect.php";
						
		//set up query to insert username and password into database
		$sqlSet = "INSERT INTO pp_joe_book (joe_book_title, joe_book_author, joe_book_pub, joe_book_last_read, joe_book_status ) VALUES(:title, :author, :pub, :lastRead, :status)";
		//prepare the query for binding
		$stmt = $conn->prepare($sqlSet);
		//bind parameters
		$stmt->bindParam(':title', $title);
		$stmt->bindParam(':author', $author);
		$stmt->bindParam(':pub', $pub);
		$stmt->bindParam(':lastRead', $lastRead);
		$stmt->bindParam(':status', $status);
						
		$title = $inTitle;
		$author = $inAuthor;
		$pub = $inPub;
		$lastRead = $inLastRead;
		$status = $inStatus;
		$stmt->execute();		
	}
}
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
<p><a href="bookshelf.php">See the Bookshelf</a></p>
<p><a class="selected" href="profilePage.php">Go to Profile</a></p>
<p><a href="contactPage.php">Contact</a></p>
</div>

<div id="homeMessage">
<?php
if($validForm)
{
?>
<h1>The new book has been aded to the bookshelf!</h1>
<p><a href="bookshelf.php">[Return to the Bookshelf]</a></p>
<?php
}
else
{
?>

<form method="post" name="bookadd" action="adminAddBook.php">
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
<p><input type="submit" name="addBook" value="Add Book to Bookshelf" /></p>
</form>
<?php
}
?>
</div>

</div>
</body>
</html>