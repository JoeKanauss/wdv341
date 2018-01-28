<?php

$msg = "";

//set up session
session_start();



//if the page opens with a valid user...
if($_SESSION['validUser']== "yes")
{
}
//else, if page opens without a valid user...
else
{
	//if the page was reached by a submitted login form...
	if(isset($_POST["submitLogin"]) )
	{
		//set username and password from form
		$inUsername = $_POST["loginUser"];
		$inPassword = $_POST["loginPass"];
		
		//connect to database
		include "wdv341DatabaseConnect.php";
		
		//set up SQL SELECT query for username and password that were entered into form
		$sql = "SELECT event_user_name, event_user_password FROM wdv341_event_user WHERE event_user_name = '$inUsername' AND event_user_password = '$inPassword'";
		
		//run SELCT query
		$result = $conn->query($sql);
		
		//if the query retrieves 1 record...
		if($result)
		{
			if($result->rowCount() == 1)
			{
				//user is a valid user
				$_SESSION['validUser'] = "yes";
				//set confirmation msg
				$msg = "Welcome back ".$inUsername."!";
			}
			//else, if 0 or more than 1 records were found...
			else
			{
				//user is not a valid user
				$_SESSION['validUser'] = "no";
				//set error msg
				$msg = "There was a problem with your username or password. Please try again.";
			}
		}
	}
	//else, if the user needs to see the login form...
	else
	{
		
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<style>

body {
	background-color: #cce0ff;
}

#container {
	width: 75%;
	margin: 2% 10%;
	border: 2px solid black;
	text-align: center;
	background-color: #e6f0ff;
	padding: 25px;
}

input[type=text] {
	background-color: #ffffcc;
}
input[type=password] {
	background-color: #ffffcc;
}

.tableFormat {
	border: 1px solid black;
	margin: 0 auto;
	background-color: #99c2ff;
	
}

th {
	border: 1px solid black;
	padding: 10px;
	background-color: #cce0ff;
	
}



td {
	border: 1px solid black;
	padding: 10px;
	text-align: center;
	background-color: #ffffcc;
	
}

h1 {
	text-align: center;
	text-decoration: underline;
}

p {
	text-align: center;
}

</style>
</head>
<body>
<h1><?php echo $msg?></h1>

<?php
//if the user is a valid user...
if($_SESSION['validUser'] == "yes")
{
	//show select event page
?>
<?php

//connect to database
include "wdv341DatabaseConnect.php";
	
// create SELECT query
$sql = "SELECT event_id, event_name, event_description, event_presenter, event_date, event_time FROM wdv341_event";

//run SELECT query
$result = $conn->query($sql); 

//if the query runs successfully...
if($result) 
{
	//if there are more than zero results...
	if($result->rowCount() > 0)
	{
		//display the # of results
		$display = "<p>We found ". $result->rowCount() ." result(s)!</p>"; 
	
		//start table for results with headers
		$display .= "<table class='tableFormat'>";
		$display .= "<tr><th>Event ID</th>";
		$display .= "<th>Event Name</th>";
		$display .= "<th>Event Description</th>";
		$display .= "<th>Event Presenter</th>";
		$display .= "<th>Event Date</th>";
		$display .= "<th>Event Time</th>";
		$display .= "<th>Delete</th>";
		$display .= "<th>Update</th></tr>";
	
		//for each row result...
		foreach ($result as $row) 
		{
			//create a table row in order of event_name, _desc, _presenter, _date, and _time
			//Delete and Update links added
			$display .= "<tr><td>";
			$display .= $row["event_id"];
			$display .= "</td>";
			$display .= "<td>";
			$display .= $row["event_name"];
			$display .= "</td>";
			$display .= "<td>";
			$display .= $row["event_description"];
			$display .= "</td>";
			$display .= "<td>";
			$display .= $row["event_presenter"];
			$display .= "</td>";
			$display .= "<td>";
			$display .= $row["event_date"];
			$display .= "</td>";
			$display .= "<td>";
			$display .= $row["event_time"];
			$display .= "</td>";
			$display .= "<td>";
			$display .="<a href='deleteEvent.php?id=$row[event_id]'>Delete</a>";
			$display .= "</td>";
			$display .= "<td>";
			$display .="<a href='updateEventForm.php?id=$row[event_id]'>Update</a>";
			$display .= "</td></tr>";
	}
	
	//close the table
	$display .="</table>"; 
	}
	
	//else, if there are zero results...
	else
	{
		//display "no results" message
		$display = "There were no results found.";
	}
	
}
//else, if the query does not run successfully...
else
{
	//display error message
	$display = "<h1>UH-OH!</h1>";
}

?>


<div id="container">
<h1>WDV 341: SELECT and Display Event</h1>
<p><?php echo$display?></p>
<p><a href= "eventsForm.php">Create a New Event</a></p>

<p><a href="login.php">Admin Options</a></p>
<p><a href="logout.php">Logout</a></p>
</div>

<?php
}
//else, if not a valid user...
else
{
	//show login form
?>
<div id="container">
<h2>Please Log In</h2>
<form method="post" name="loginForm" action="selectEventLogin.php">
<p>Username: <input type="text" name="loginUser" /></p>
<p>Password: <input type="password" name="loginPass" /></p>
<p><input type="submit" name ="submitLogin" value="Login"></p>
</form>
</div>
<?php
}
?>



</body>
</html>