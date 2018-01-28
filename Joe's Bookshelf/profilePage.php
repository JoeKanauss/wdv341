<?php
$msg="";
$favoriteStart = "";

//start session
session_start();

if(isset($_SESSION["validUser"]))
{
	if($_SESSION["validUser"]=="Yes")
	{
		$msg = "Hello, ".$_SESSION['username']."!";
	
	//connect to database
		include "wdv341DatabaseConnect.php";

	//set up SELECT query to bring in user's "currently reading" book(s) from user's books table
		$sql = "SELECT books_title, books_author, books_status FROM $_SESSION[username]_books WHERE books_status = 'Currently Reading'";
	
	//run SELECT query
		$result = $conn->query($sql);

	//if the query runs correctly display the "currently reading" books in paragraphs
		if($result)
		{
			$currentRead = "<p>";
			foreach($result as $row)
			{
		
				$currentRead .= "<p><strong>&ldquo; ".$row["books_title"];
				$currentRead .= " &rdquo;</strong> by ";
				$currentRead .= $row["books_author"]."</p>";
			}	
				$currentRead .= "</p>";
		}
	
		//set up Select query to bring in user's favorite book(s) from user's books table
		$sql2 = "SELECT books_title, books_author, books_favorite FROM $_SESSION[username]_books WHERE books_favorite = 'yes'";

		//run SELECT query
		$result2 = $conn->query($sql2);

		//if the query runs correctly display the favorite books in paragraphs
		if($result2)
		{
			// if there are no results...
			if($result2->rowCount()==0)
			{
				$favorite = "<p>You have no favorite books listed at the moment.</p>";
			}
			//if there is 1 result...
			else
			{
				if($result2->rowCount()==1)
				{	
					$favoriteStart = "<p>Your favorite book is: </p>";
				}
				//if there is more than 1 result...
				else
				{
					if($result2->rowCount()>=1)
					{	
						$favoriteStart = "<p>Your favorite books include:</p>";		
					}
				}
			}
			$favorite ="<p>";
			foreach($result2 as $row)
				{
				$favorite .= "<p><strong>&ldquo; ".$row["books_title"];
				$favorite .= " &rdquo;</strong> by ";
				$favorite .= $row["books_author"]."</p>";
				}
				$favorite .= "</p>";
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
<p><a href="homepage.php">Home</a></p>
<p><a class="" href="login.php">Log In</a></p>
<p><a href="signUpPage.php">Sign Up</a></p>
<p><a href="bookshelf.php">See the Bookshelf</a></p>
<p><a class="selected" href="profilePage.php">Go to Profile</a></p>
<p><a href="contactPage.php">Contact</a></p>
</div>

<div id="homeMessage">
<?php 
if(isset($_SESSION["validUser"]))
{
	//if valid user
	if($_SESSION["validUser"]=="Yes")
	{
	//display the rest of the page
?>

<h1 class="intro"><?php echo $msg?></h1>
<div class="profileOptions">
<p><a href="userBookshelf.php">[Update Your Bookshelf]</a></p>
<p><a href="logout.php">[Log out]</a></p>
</div>

<div class="current">
<p>You are currently reading: <?php echo $currentRead ?></p>
</div>

<div class="favorite">
<?php echo $favoriteStart?>
<?php echo $favorite?>
</div>

<?php
	}
//else, if not a valid user...
	else
	{
		//display invalid user profile message
?>
<h1>Hi! You're either not logged in or you don't have a profile yet!</h1>
<p><a href="login.php">[Log In]</a></p>
<p><a href="signUpPage.php">[Sign Up]</a></p>
<?php
	}
}
else
{
?>
<h1>Hi! You're either not logged in or you don't have a profile yet!</h1>
<p><a href="login.php">[Log In]</a></p>
<p><a href="signUpPage.php">[Sign Up]</a></p>
<?php 
}
?>
</div>
</div>
</div>
</body>
</html>