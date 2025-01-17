<?php
// Include the database connection file
// servername => localhost
// username => root
// password => empty
// database name => chatbox
$conn = mysqli_connect("localhost", "root", "", "bot");

// Check connection
if($conn === false){
	die("ERROR: Could not connect. " 
		. mysqli_connect_error());
}

// Get id from URL parameter
$page = $_GET['page'];
$id = $_GET['id'];

// Select data associated with this particular id
$result = mysqli_query($conn, "SELECT * FROM chatbot WHERE id = $id");

// Fetch the next row of a result set as an associative array
$resultData = mysqli_fetch_assoc($result);

$queries = $resultData['queries'];
$replies = $resultData['replies'];
?>

<html>
<head>
	<title>CHATBOT - iTech</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="bootstrap.min.css">
	<style>
		body{ text-align: center; }
	</style>
</head>

<body>
	<h1>CHATBOT - iTech</h1>
	<p><a href="view.php" class="btn btn-primary">View</a>
	<a href="index.php" class="btn btn-primary">Chat Now</a></p>
	<h1>Update Chat Data</h1>
	
	
	<form action="editAction.php" method="post">
		<input type="hidden" name="page" value="<?php echo $page; ?>">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<div class="form-group">
			<label for="queries">Queries:</label>
			<div>
				<input type="text" name="queries" id="queries" value="<?php echo $queries; ?>" class="form-control">
			</div>
		</div>   
		<div class="form-group">
			<label for="replies">Replies:</label>
			<div>
				<input type="text" name="replies" id="replies" value="<?php echo $replies; ?>" class="form-control">
			</div>
		</div>

		<input type="submit" name="update" value="Update" class="btn btn-primary" />
	</form>
	<footer>Chatbot iTech. 2024 All rights reserved.</footer>
</body>
</html>
