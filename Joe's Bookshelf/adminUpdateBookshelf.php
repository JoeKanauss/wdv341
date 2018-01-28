<?php
//start session
session_start();

//if the user is not "administrator", redirect to home page
if($_SESSION["username"] !== "administrator")
{
	header("Location: homepage.php");
}
//else, if the user is "administrator", show page
else
{
	//connect to database
	include "wdv341DatabaseConnect.php";

	//set up SELECT query
	$sql = "SELECT joe_book_id, joe_book_title, joe_book_author, joe_book_pub, joe_book_last_read, joe_book_status FROM pp_joe_book ORDER BY joe_book_last_read DESC";

	//run SELECT query
	$result = $conn->query($sql);

	//if the query runs successfully...
	if($result)
	{
		//if there are more than 0 results found...
		if($result->rowCount() > 0)
		{
				$msg = "<p>The bookshelf has ".$result->rowCount()." book(s)</p>";
			
				$display = "<table class='bookTable'><tr>";
				$display .= "<th>Title</th>";
				$display .= "<th>Author</th>";
				$display .= "<th>Published</th>";
				$display .= "<th>Last Reading</th>";
				$display .= "<th>Read Status</th>";
/*			//create a "book"-class div for each book
			$display = "<div class='book'>";		
*/		
			//for each row result...
			foreach($result as $row)
			{
				$display .="<tr><td>";
				$display .= $row["joe_book_title"];
				$display .= "</td>";
				$display .= "<td> ";
				$display .= $row["joe_book_author"];
				$display .= "</td>";
				$display .= "<td>";
				$display .= $row["joe_book_pub"];
				$display .= "</td>";
				$display .= "<td>";
				$display .= $row["joe_book_last_read"];
				$display .= "</td>";
				$display .= "<td>";
				$display .= $row["joe_book_status"];
				$display .= "</td><tr>";
				
				$display .= "<tr class='updateDeleteRow'><td colspan='5'>";
				$display .="<a href='adminUpdateBook.php?id=$row[joe_book_id]'>[Update]</a> <a href='adminDeleteBook.php?id=$row[joe_book_id]'>[Delete]</a> ";
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
<p><a  href="login.php">Log In</a></p>
<p><a href="signUpPage.php">Sign Up</a></p>
<p><a class="selected" href="bookshelf.php">See the Bookshelf</a></p>
<p><a href="profilePage.php">Go to Profile</a></p>
<p><a href="contactPage.php">Contact</a></p>
</div>

<div id="homeMessage">

<?php echo $msg; ?>
<?php echo $display; ?>
<div id="noFloat"></div>
<p><a href="adminAddBook.php">[Add a Book to the Bookshelf]</a></p>
</div>
</div>
</body>
</html>