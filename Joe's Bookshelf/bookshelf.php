<?php
//display full list of Joe's Books, with textbox to choose by author, decade, read status

//start session
session_start();


//if Joe's Books list has been narrowed by author or decade, read status...
if (isset($_POST["submitSort"]))
{
	//gather sort data from form
	$inAuthor = $_POST["author"];
	$inStatus = $_POST["status"];
	
	//connect to database
	include "wdv341DatabaseConnect.php";
	
	//if both author and status have been defined in form...
	if($inAuthor !== "" && $inStatus !=="default")
	{
		//set up SELECT query to find both author and status
		$sql = "SELECT  joe_book_title, joe_book_author, joe_book_pub, joe_book_last_read, joe_book_status FROM pp_joe_book WHERE joe_book_author = '$inAuthor' AND joe_book_status = '$inStatus' ORDER BY joe_book_last_read DESC";
		
		//run SELECT query
		$result = $conn->query($sql);
		
		//if the query brings back more than 0 results...
		if($result->rowCount() > 0)
		{
				$msg = "<p>The bookshelf has ".$result->rowCount()." book(s)</p>";
			
				$display = "<table class='bookTable'><tr>";
				$display .= "<th>Title</th>";
				$display .= "<th>Author</th>";
				$display .= "<th>Published</th>";
				$display .= "<th>Last Reading</th>";
				$display .= "<th>Read Status</th></tr>";
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
				$display .= "</td></tr>";
			
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
	//if only the author has been defined in form...
	if($inAuthor !=="" && $inStatus == "default")
	{
			//set up SELECT query to find both author
			$sql = "SELECT  joe_book_title, joe_book_author, joe_book_pub, joe_book_last_read, joe_book_status FROM pp_joe_book WHERE joe_book_author = '$inAuthor' ORDER BY joe_book_last_read DESC";
		
			//run SELECT query
			$result = $conn->query($sql);
		
			//if the query brings back more than 0 results...
			if($result->rowCount() > 0)
			{
				$msg = "<p>The bookshelf has ".$result->rowCount()." book(s)</p>";
			
				$display = "<table class='bookTable'><tr>";
				$display .= "<th>Title</th>";
				$display .= "<th>Author</th>";
				$display .= "<th>Published</th>";
				$display .= "<th>Last Reading</th>";
				$display .= "<th>Read Status</th></tr>";
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
				$display .= "</td></tr>";
			
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
	//if only the status has been defined in form...
	if($inAuthor == "" && $inStatus !== "default")
	{
		//set up SELECT query to find both author and status
		$sql = "SELECT  joe_book_title, joe_book_author, joe_book_pub, joe_book_last_read, joe_book_status FROM pp_joe_book WHERE joe_book_status = '$inStatus' ORDER BY joe_book_last_read DESC";
		
		//run SELECT query
		$result = $conn->query($sql);
		
		//if the query brings back more than 0 results...
		if($result->rowCount() > 0)
		{
				$msg = "<p>The bookshelf has ".$result->rowCount()." book(s)</p>";
			
				$display = "<table class='bookTable'><tr>";
				$display .= "<th>Title</th>";
				$display .= "<th>Author</th>";
				$display .= "<th>Published</th>";
				$display .= "<th>Last Reading</th>";
				$display .= "<th>Read Status</th></tr>";
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
				$display .= "</td></tr>";
			
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
	//if neither status has been defined in form...
	if($inAuthor == "" && $inStatus == "default")
	{
		//set up SELECT query to show all books
		$sql = "SELECT  joe_book_title, joe_book_author, joe_book_pub, joe_book_last_read, joe_book_status FROM pp_joe_book ORDER BY joe_book_last_read DESC";
		
		//run SELECT query
		$result = $conn->query($sql);
		
		//if the query brings back more than 0 results...
		if($result->rowCount() > 0)
		{
				$msg = "<p>The bookshelf has ".$result->rowCount()." book(s)</p>";
			
				$display = "<table class='bookTable'><tr>";
				$display .= "<th>Title</th>";
				$display .= "<th>Author</th>";
				$display .= "<th>Published</th>";
				$display .= "<th>Last Reading</th>";
				$display .= "<th>Read Status</th></tr>";
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
				$display .= "</td></tr>";
			
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
//else if all books are being shown (page is not from submitted form...
else
{
	//connect to database
	include "wdv341DatabaseConnect.php";

	//set up SELECT query
	$sql = "SELECT joe_book_title, joe_book_author, joe_book_pub, joe_book_last_read, joe_book_status FROM pp_joe_book ORDER BY joe_book_last_read DESC";

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
				$display .= "<th>Read Status</th></tr>";
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
				$display .= "</td></tr>";
			
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
	//else, if the query does not run successfully...
	else
	{
		$msg = "Uh-oh! Something went wrong! Please try again!";
	}
	//disconnect from database
	$conn = null;
	
}

//connect to database
include "wdv341DatabaseConnect.php";	
//select all record authors from database table
$sql="SELECT DISTINCT joe_book_author FROM pp_joe_book";
$result = $conn->query($sql);

if($result)
{
	$option = "<select name='author'>";
	$option .="<option value=''>Choose Author to Sort By</option>";
	foreach($result as $row)
	{
		$option .= "<option value='".$row["joe_book_author"]."'>".$row["joe_book_author"]."</option>";
	}
	$option .= "</select>";
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
<p><a class="selected" href="bookshelf.php">See the Bookshelf</a></p>
<p><a href="profilePage.php">Go to Profile</a></p>
<p><a href="contactPage.php">Contact</a></p>
</div>

<div id="homeMessage">
<h1><?php echo $msg ?></h1>
<?php echo $display ?>
<div id="noFloat"></div>
<form method="post" name="bookshelfSort" action="bookshelf.php" >
<p>Sort Bookshelf by Author: <?php echo $option; ?></p>

<p>Sort Bookshelf by Read Status: <select name="status">
<option value="default">Choose Read Status to Sort By</option>
<option value="Want to Read">Want to Read</option>
<option value="Have Read">Have Read</option>
<option value="Currently Reading">Currently Reading</option>
</select></p>
<input type="submit" name="submitSort" value="Sort the Bookshelf!" />
</form>

<?php 
if(isset($_SESSION["validUser"]))
{
	if($_SESSION["username"]=="administrator")
	{
?>

<p><a href="adminUpdateBookshelf.php">[Update Master Bookshelf]</a></p>

<?php
	}
}
?>
</div>
</div>
</body>
</html>