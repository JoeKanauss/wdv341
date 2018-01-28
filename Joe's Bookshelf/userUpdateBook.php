<?php
//set variables for validation
$validForm = "";
$titleError = "";
$authorError = "";
$favoriteError = "";
$statusError = "";
$oldTitle= "";
$oldAuthor= "";
$oldFavoriteYes= "";
$oldFavoriteNo= "";
$oldWantRead="";
$oldHaveRead="";
$oldCurrentRead="";
//start session
session_start();

//connect to database
include "wdv341DatabaseConnect.php";

	include "validateBooks.php";

//set id from GET
$bookId = $_GET["id"];

//if the update form has been submitted, validate the form

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

if(isset($_POST["updateBook"]))
{
	//fill variables from form
	$inTitle = $_POST["title"];
	$inAuthor = $_POST["author"];
	$inFavorite = $_POST["favorite"];
	$inStatus = $_POST["status"];
	
	//assume the form is valid before validating
	$validForm = true;
	
	//validate the form
	titleValidation();
	authorValidation();
	favoriteValidation();
	statusValidation();

	//if the form is valid, set up and run UPDATE query for the record
	if($validForm)
	{
		$sql = "UPDATE $_SESSION[username]_books SET books_title='$inTitle', books_author='$inAuthor', books_favorite='$inFavorite', books_status='$inStatus' WHERE books_id='$bookId'";
		
		$result = $conn->query($sql);
		
		//if the query runs successfully, display confirmation message
		if($result)
		{
?>

<h1>The book has been updated!</h1>
<p><a href="userBookshelf.php">[Return to Your Bookshelf]</a></p>
<?php 
		}
	}
	//else, if the form has been submitted but is not valid, present form with errors
	else
	{
		$inTitle = $_POST["title"];
		$inAuthor = $_POST["author"]; 
	//favorite select
		if($_POST["favorite"]=="yes")
		{
			$inFavoriteYes = "checked";
			$inFavoriteNo = "";
		}
		else
		{
			$inFavoriteYes = "";
			$inFavoriteNo = "checked";
		}
	
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
<form method="post" name="bookupdate" action="userUpdateBook.php?id=<?php echo$bookId?>">
<p>Book Title:<br>
<span class="error"><?php echo $titleError?></span>
<input type="text" name="title" value="<?php echo $inTitle; ?>"></p>
<p>Book Author:<br>
<span class="error"><?php echo $authorError?></span>
<input type="text" name="author" value="<?php echo $inAuthor; ?>"></p>
<p>Is this book one of your favorites?<br>
<span class="error"><?php echo $favoriteError?></span>
<input type="hidden" name="favorite" value="noneSelected" />
 <input type="radio" name="favorite" value="yes" <?php echo$inFavoriteYes?>>Yes <input type="radio" name="favorite" value="no" <?php echo$inFavoriteNo?>>No</p>
<p>Reading Status:<br>
<span class="error"><?php echo $statusError?></span>
<select name="status">
<option value="default">Read Status</option>
<option value="Want to Read" <?php echo $inWantRead?>>Want to Read</option>
<option value="Have Read" <?php echo $inHaveRead?>>Have Read</option>
<option value="Currently Reading" <?php echo $inCurrentRead?>>Currently Reading</option>
</select>
<p><input type="submit" name="updateBook" value="Update This Book" /></p>
</form>
<?php
	}
	}
//else, if the form needs to be presented, grab record data from database
else
{
	$sql="SELECT books_id, books_title, books_author, books_favorite, books_status FROM $_SESSION[username]_books WHERE books_id= $bookId";
	$result = $conn->query($sql);
	if($result)
	{
		foreach($result as $row);
		
		$inTitle= $row["books_title"];
		$inAuthor= $row["books_author"];
		$inFavoriteYes= "";
		$inFavoriteNo= "";
		$inWantRead="";
		$inHaveRead="";
		$inCurrentRead="";
	
		//favorite select
		if($row["books_favorite"]=="yes")
		{
			$inFavoriteYes = "checked";
			$inFavoriteNo = "";
		}
		else
		{
			$inFavoriteYes = "";
			$inFavoriteNo = "checked";
		}
	
		//status select
		if($row["books_status"]=="Want to Read")
		{
		$inWantRead= "selected";
		$inHaveRead= "";
		$inCurrentRead= "";
		}
		else if($row["books_status"]=="Have Read")
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
<form method="post" name="bookupdate" action="userUpdateBook.php?id=<?php echo$bookId?>">
<p>Book Title:<br>
<span class="error"><?php echo $titleError?></span>
<input type="text" name="title" value="<?php echo $inTitle?>"></p>
<p>Book Author:<br>
<span class="error"></span>
<input type="text" name="author" value="<?php echo $inAuthor?>"></p>
<p>Is this book one of your favorites?<br>
<span class="error"></span>
<input type="hidden" name="favorite" value="noneSelected" />
 <input type="radio" name="favorite" value="yes" <?php echo $inFavoriteYes?>>Yes <input type="radio" name="favorite" value="no" <?php echo $inFavoriteNo?>>No</p>
<p>Reading Status:<br>
<span class="error"></span>
<select name="status">
<option value="default">Read Status</option>
<option value="Want to Read" <?php echo $inWantRead?>>Want to Read</option>
<option value="Have Read" <?php echo $inHaveRead?>>Have Read</option>
<option value="Currently Reading"<?php echo $inCurrentRead?>>Currently Reading</option>
</select>
<p><input type="submit" name="updateBook" value="Update This Book" /></p>
</form>
<?php
	}
}
?>	
</div>
</div>
</body>
</html>



