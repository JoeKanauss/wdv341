<?php

//connect to database
include "wdv341DatabaseConnect.php";

//retrieve record id (eventId) from $_GET;
$eventId = $_GET["id"];

//create SQL DELETE query with record id
$sql = "DELETE FROM wdv341_event WHERE event_id = $eventId";

//run DELETE query
$result = $conn->query($sql);

//if the query runs successfully print  message telling the event was deleted
if($result)
{
	$msg = "<h3> The event associated with Event ID ".$eventId." has been deleted.</h3>";
}
else
{
	$msg = "<h3>Uh-oh, we weren't able to delete the event associated with Event ID  ".$eventId." Please try again.</h3>";
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
<div id="container">
<h1>Event DELETE Page</h1>
<?php echo $msg; ?>
<p><a href="selectEvents.php">Return to the list of events.</a></p>
</div>

</body>
</html>
