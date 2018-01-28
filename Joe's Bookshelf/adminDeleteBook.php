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
//connect to database
include "wdv341DatabaseConnect.php";

//set id from GET
$bookId = $_GET["id"];

if(isset($_SESSION["validUser"]))
{
	if($_SESSION["validUser"] == "Yes")
	{
		$msg = "Here is the book that has been selected for deletion:";
		
		//set up SELECT sql query to bring in the book with the matching id as in the GET
		$sql="SELECT joe_book_title, joe_book_author, joe_book_status FROM pp_joe_book WHERE joe_book_id = '$bookId'";
		
		//run SELECT query
		$result = $conn->query($sql);
		
		//set record in div
		foreach($result as $row)
			{
				$display ="<div class='deleteBookDisplay'>";
				$display .= "<p><span class='bold'>";
				$display .= $row["joe_book_title"];
				$display .= "</span></p>";
				$display .= "<p> by ";
				$display .= $row["joe_book_author"];
				$display .= "</p>";
				$display .= "<p>".$row["joe_book_status"];
				$display .= "</p>";
				$display .= "</div>";
			}
		//if the delete confirmation button is set, set and run DELETE query on book matching book id
		if(isset($_POST["submitDelete"]))
		{
			//set up DELETE sql query
			$sql2="DELETE FROM pp_joe_book WHERE joe_book_id = '$bookId'";
			
			//run DELETE query
			$result2 = $conn->query($sql2);
			
			//if the DELETE query succeed, print confirmation message
			if($result2)
			{
				$msg2="The book was successfully deleted!<br><a href='bookshelf.php'>[Return to Bookshelf]</a>";
			}
			
		}
	}
	else
	{
		$msg = "Please log in to delete a book from your bookshelf.<br><a href='login.php'>[Log In]</a>";
		$display = "";
	}
}
else
{
	$msg = "Please log in to delete a book from your bookshelf.<br><a href='login.php'>[Log In]</a>";	
	$display = "";
}
}

?>

<script>
function onClickNo()
{
	location.href="bookshelf.php";
}
</script>
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
<p><a class="selected" href="bookshelf.php">See the Bookshelf</a></p>
<p><a href="profilePage.php">Go to Profile</a></p>
<p><a href="contactPage.php">Contact</a></p>
</div>

<div id="homeMessage">
<?php
if(isset($_POST["submitDelete"]))
{
?>
<p><?php echo $msg2; ?></p>

<?php
}
else
{
?>	
	
<p><?php echo $msg; ?></p>
<p><?php echo $display; ?></p>

<?php

	if(isset($_SESSION["validUser"]))
	{
		if($_SESSION["validUser"]=="Yes")
		{
?>
	<p>Are you sure this is the book you want to delete?</p>
	<form method="post" action="adminDeleteBook.php?id=<?php echo$bookId?>">
	<p><input type="submit" name="submitDelete" value="Yes, delete this book" />
	<input type="button" name="no" value="No, take me back to the bookshelf" onclick="onClickNo();" /></p>
<?php
		}
	}
}
?>
</div>
</div>
</body>
</html>