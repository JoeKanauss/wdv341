<?php
$titleError = "";
$authorError = "";
$favoriteError = "";
$statusError = "";
$validForm = "";

//start session
session_start();
//connect to database
include "wdv341DatabaseConnect.php";
//set up SELECT query for user's table
$sql = "SELECT books_id, books_title, books_author, books_status FROM $_SESSION[username]_books";
//run SELECT query
$result = $conn->query($sql);
//if there are more than 0 results found...
		if($result->rowCount() > 0)
		{
			$msg = "<p>Your bookshelf has ".$result->rowCount()." book(s)</p>";
		
					$display = "<table class='bookTable'><tr>";
				$display .= "<th>Title</th>";
				$display .= "<th>Author</th>";
				$display .= "<th>Read Status</th>";
/*			//create a "book"-class div for each book
			$display = "<div class='book'>";		
*/		
			//for each row result...
			foreach($result as $row)
			{
				$display .="<tr><td>";
				$display .= $row["books_title"];
				$display .= "</td>";
				$display .= "<td> ";
				$display .= $row["books_author"];
				$display .= "</td>";
				$display .= "<td>";
				$display .= $row["books_status"];
				$display .= "</td><tr>";
				
				$display .= "<tr class='updateDeleteRow'><td colspan='3'>";
				$display .="<a href='userUpdateBook.php?id=$row[books_id]'>[Update]</a> <a href='userDeleteBook.php?id=$row[books_id]'>[Delete]</a> ";
				$display .= "</td></tr>";
				
/*				$display .= "<tr><td colspan='5'>";
				$display .= "----------------------------------";
				$display .= "</td></tr>";
*/				
			
			}
			//close the div
			$display .= "</table>";
		}
		//else, if no results were found...
		else
		{
			$msg = "No results were found.";
			$display = "";
		}
		
//if addBook set...
if(isset($_POST["addBook"]))
{
	//include bookValidation
	include "validateBooks.php";
	
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
	else
	{
	
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
<p><a href="homepage.php">Home</a></p>
<p><a class="" href="login.php">Log In</a></p>
<p><a href="signUpPage.php">Sign Up</a></p>
<p><a href="bookshelf.php">See the Bookshelf</a></p>
<p><a class="selected" href="profilePage.php">Go to Profile</a></p>
<p><a href="contactPage.php">Contact</a></p>
</div>

<div id="homeMessage">
<h1><?php echo $msg?></h1>
<p><a href="userAddBook.php">[Add a Book to Your Bookshelf]</a></p>
<?php echo $display?>
<div id="noFloat"></div>
</div>
</div>

</div>
</body>
</html>