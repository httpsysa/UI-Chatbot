<!DOCTYPE html>
<html>

<head>
    <title>CHATBOT - iTech</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.min.css">
	<style>
		body{ font: 14px sans-serif; text-align: center; }
	</style>
</head>

<body>
	<?php
	// Include the database connection file
	// servername => localhost
	// username => root
	// password => empty
	// database name => chatbox
	$conn = mysqli_connect("localhost", "root", "", "bot");



	if (isset($_POST['update'])) {
		// Escape special characters in a string for use in an SQL statement
		$page = $_POST['page'];
		$id = mysqli_real_escape_string($conn, $_POST['id']);
		$queries = mysqli_real_escape_string($conn, $_POST['queries']);
		$replies = mysqli_real_escape_string($conn, $_POST['replies']);

		$insert_queries = htmlentities($queries);
		$insert_replies = htmlentities($replies);
		
		// Check for empty fields
		if (empty($insert_queries) || empty($insert_replies)) {
			if (empty($insert_queries)) {
				echo "<div class='alert alert-danger'>Queries field is empty.</div>";
				
			}
			
			if (empty($insert_replies)) {
				echo "<div class='alert alert-danger'>Replies field is empty.</div>";
			}

			// Show link to the previous page
            echo "<a href='javascript:self.history.back();'>Go Back</a>";
		} else {
			// Update the database table
			$result = mysqli_query($conn, "UPDATE chatbot SET `queries` = '$queries', `replies` = '$replies' WHERE `id` = $id");
	?>
	<h1>CHATBOT - iTech</h1>
	<p><a href="view.php?page=<?php echo $page; ?>" class="btn btn-primary">View</a>
	<a href="index.php" class="btn btn-primary">Chat Now</a></p>
	<?php		
			if($result){
				// Display success message
				echo "<div class='alert alert-success'>Data updated successfully.</div>";
			} else{
				// Display error message
				echo "ERROR: Hush! Sorry $sql. " 
				. mysqli_error($conn);
			}
		}
	}
	?>
</body>
</html>