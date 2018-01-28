<?php
$msg = "";
//set up session
session_start();

//initially set $msg to empty
$msg = "";

//if the Log In! button has been pressed, search for username/password pair in database pp_user database
if(isset($_POST["submitLogin"]))
{
	$loginUser = $_POST["loginUser"];
	$loginPass = $_POST["loginPass"];
	
	//connect to database
	include "wdv341DatabaseConnect.php";
	
	//set up SELECT query for username/password pair
	$sql = "SELECT user_name FROM pp_user WHERE user_name = '$loginUser' AND user_pass = '$loginPass'";
	
	//run SELECT query
	$result= $conn->query($sql);
	
	//set each field as a row variable
	foreach($result as $row);
	
	//if the query brings back 1 record match...
	if($result->rowCount()==1)
	{
		$_SESSION["validUser"]="Yes";
		$_SESSION["username"]= $row["user_name"];
		$msg = "Welcome back, ".$_POST["loginUser"];
	}
	else if ($result->rowCount()<1)
	{
		$_SESSION["validUser"] = "No";
		$msg = "this is not a valid username or password. try again.";
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
<p><a class="selected" href="login.php">Log In</a></p>
<p><a href="signUpPage.php">Sign Up</a></p>
<p><a href="bookshelf.php">See the Bookshelf</a></p>
<p><a href="profilePage.php">Go to Profile</a></p>
<p><a href="contactPage.php">Contact</a></p>
</div>

<div id="homeMessage">
<h1><?php echo $msg ?></h1>
<?php
if(isset($_SESSION["validUser"]))
{
	//if valid user...
	if($_SESSION["validUser"]=="Yes")
	{
		//show options
?>
<p>I'm happy to see you again!</p>

<p><a href="profilePage.php">[Go to Your Profile]</a></p>
<p><a href="logout.php">[Log Out]</a></p>
<?php
	}
//else, if not a valid user...
	else
	{
	//show login form
?>
<form method="post" name="loginForm" action="login.php">
<p>Username:<br>
<input type="text" name="loginUser" /></p>
<p>Password:<br>
<input type="password" name="loginPass" /></p>
<p><input type="submit" name="submitLogin" value="Log In!" /></p>
</form>
<?php
	}
}
else
{
?>
<form method="post" name="loginForm" action="login.php">
<p>Username:<br>
<input type="text" name="loginUser" /></p>
<p>Password:<br>
<input type="password" name="loginPass" /></p>
<p><input type="submit" name="submitLogin" value="Log In!" /></p>
</form>
<?php
}
?>
</div>
</div>
</body>
</html>