<?php
//start session
session_start();

//define variables used in validation
	$inFavoriteYes="";
	$inFavoriteNo="";
	$inDefault="";
	$inWantRead="";
	$inHaveRead="";
	$inCurrentRead="";
$titleError = "";
$authorError = "";
$favoriteError = "";
$statusError = "";
$validForm = "";

//include bookValidation
include "validateBooks.php";

if(isset($_POST["addBook"]))
{
	//fill variables from form
	$inTitle = $_POST["title"];
	$inAuthor = $_POST["author"];
	$inFavorite = $_POST["favorite"];
	$inStatus = $_POST["status"];

	
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
	
	//assume the form is valid before validating
	$validForm = true;
	
	//validate the form
	titleValidation();
	authorValidation();
	favoriteValidation();
	statusValidation();	
	//if form is valid...
	if ($validForm)
	{
		//connect to database
		include "wdv341DatabaseConnect.php";
						
		//set up query to insert username and password into database
		$sqlSet = "INSERT INTO $_SESSION[username]_books (books_title, books_author, books_favorite, books_status ) VALUES(:title, :author, :favorite,:status)";
		//prepare the query for binding
		$stmt = $conn->prepare($sqlSet);
		//bind parameters
		$stmt->bindParam(':title', $title);
		$stmt->bindParam(':author', $author);
		$stmt->bindParam(':favorite', $favorite);
		$stmt->bindParam(':status', $status);
						
		$title = $inTitle;
		$author = $inAuthor;
		$favorite = $inFavorite;
		$status = $inStatus;
		$stmt->execute();		
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
<h1>The new book has been added to your bookshelf!</h1>
<p><a href="userBookshelf.php">[Return to Your Bookshelf]</a></p>
<?php
}
else
{
?>

<form method="post" name="bookadd" action="userAddBook.php">
<p>Book Title:<br>
<span class="error"><?php echo $titleError?></span>
<input type="text" name="title" value="<?php echo $inTitle;?>"></p>
<p>Book Author:<br>
<span class="error"><?php echo $authorError?></span>
<input type="text" name="author" value="<?php echo $inAuthor;?>"></p>
<p>Is this book one of your favorites?<br>
<span class="error"><?php echo $favoriteError?></span>
<input type="hidden" name="favorite" value="noneSelected" />
 <input type="radio" name="favorite" value="yes" <?php echo $inFavoriteYes;?>>Yes <input type="radio" name="favorite" value="no" <?php echo $inFavoriteNo;?>>No</p>
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