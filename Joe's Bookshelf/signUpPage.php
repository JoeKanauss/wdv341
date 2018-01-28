<?php
//set up session
$error = "";
$usernameError = "";
$passwordError = "";

session_start();

if(isset($_SESSION["validUser"]))
{
	//if the page opens with a valid user...
	if($_SESSION['validUser']=="Yes")
	{
		$msg = "You are already signed in.";
	}
}
	//else, if the page opens without a valid user...
else
{
	//if the page was reached by a submitted login form...
		if(isset($_POST["submitInfo"]))
		{
		include "validateSignUp.php";
		
		//if the form is valid...
		if($validForm)
		{
			//set username and password from form
			$inNewUser = $_POST['newUsername'];
			$inNewPass = $_POST['newPassword'];
		
			//connect to database
			include "wdv341DatabaseConnect.php";
		
			//set up SQL SELECT query for username that was entered into the form
			$sql = "SELECT user_name FROM pp_user WHERE user_name = '$inNewUser'";
		
			//run SELECT query
			$result = $conn->query($sql);
		
			//if the query succeeds...
			if($result)
			{
				//if the query retrieves any records (the username is already in use)...
				if($result->rowCount()>0)
				{
				$error = "The username is already in use. Please select another!";
				}
				//else, if the query retrieves no records (the username is not in use)...				
				else
				{
					if($result->rowCount() == 0)
					{
						$//set username and password from form
						$inNewUser = $_POST['newUsername'];
						$inNewPass = $_POST['newPassword'];
						
						//connect to database
						include "wdv341DatabaseConnect.php";
						
						//set up query to insert username and password into database
						$sqlSet = "INSERT INTO pp_user (user_name, user_pass) VALUES(:username, :userpass)";
						//prepare the query for binding
						$stmt = $conn->prepare($sqlSet);
						//bind parameters
						$stmt->bindParam(':username', $newUser);
						$stmt->bindParam(':userpass', $newPass);
						
						$newUser = $inNewUser;
						$newPass = $inNewPass;
						$stmt->execute();
						
						//set up username_books table
						$database = "joekan_wdv341";
						$hostname = "localhost";
						$username = "joekan_wdv341";
						$password = "wdv341";
						$table = $inNewUser."_books";
						
						$db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
						$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$sql = "CREATE table $table (
								books_id INT(11) AUTO_INCREMENT PRIMARY KEY,
								books_title VARCHAR(50) NOT NULL,
								books_author VARCHAR(50) NOT NULL,
								books_favorite VARCHAR(25) NOT NULL,
								books_status VARCHAR(50) NOT NULL);";
						$db->exec($sql);
						
						$_SESSION["validUser"] = "Yes";
						$_SESSION["username"] = $inNewUser;
						$msg = "Hooray, a new user! We're happy to have you here, ". $_SESSION["username"];
					}
				}

			}
			//else, if the query does not succeed...
			else
			{
				//set error message
				$error = "Something went wrong and we were unable to process your Username or Password. Please try again.";
			}
			
		}
	}
	//else, if the page was not reached by submitted Sign Up form...
	else
	{
		//user needs to see Sign Up form
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
<p><a href="login.php">Log In</a></p>
<p><a class="selected" href="signupPage.php">Sign Up</a></p>
<p><a href="bookshelf.php">See the Bookshelf</a></p>
<p><a href="profilePage.php">Go to Profile</a></p>
<p><a href="contactPage.php">Contact</a></p>
</div>
<div id="homeMessage">
<?php 
if(isset($_SESSION["validUser"]))
{
	// if the user is already a valid user...
	if($_SESSION['validUser']=="Yes")
	{
		//display msg
?>


<h1><?php echo $msg?></h1>
<p><a href="homepage.php">Return to Home Page</a></p>

<?php
	}
//else, if not a valid user...
	else
	{
	
	//display Sign Up form
?>
<span class="error"><?php echo $error;?></span>
<form method="post" name="signUpForm" action="signUpPage.php">
<p>Username:<br>
(include only letters and numbers)<br>
<span class="error"><?php echo $usernameError; ?></span>
<input type="text" name="newUsername" /></p>
<p>Password:<br>
(include only letters and numbers)<br>
<span class="error"><?php echo $passwordError; ?></span>
<input type="password" name="newPassword" /></p>
<p><input type="submit" name="submitInfo" value= "Sign Up!" /></p>
</form>
<?php
	}
}
else
{
?>
<span class="error"><?php echo $error;?></span>
<form method="post" name="signUpForm" action="signUpPage.php">
<p>Username:<br>
(include only letters and numbers)<br>
<span class="error"><?php echo $usernameError; ?></span>
<input type="text" name="newUsername" /></p>
<p>Password:<br>
(include only letters and numbers)<br>
<span class="error"><?php echo $passwordError; ?></span>
<input type="password" name="newPassword" /></p>
<p><input type="submit" name="submitInfo" value= "Sign Up!" /></p>
</form>
<?php
}
?>
</div>
</div>
</body>
</html>