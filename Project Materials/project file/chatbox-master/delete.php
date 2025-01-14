<?php
// Include the database connection file
// servername => localhost
// username => root
// password => empty
// database name => chatbox
$conn = mysqli_connect("localhost", "root", "", "bot");

// Get id parameter value from URL
$page = $_GET['page'];
$id = $_GET['id'];

// Delete row from the database table
$result = mysqli_query($conn, "DELETE FROM chatbot WHERE id = $id");

// Redirect to the main display page (index.php in our case)
//header("Location: view.php?page=$page");
?>

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
	<h1>CHATBOT - iTech</h1>

	<?php
    // Display success message
    echo "<div class='alert alert-success'>Data deleted successfully.</div>";
    ?>
	
	<p><a href="view.php?page=<?php echo $page; ?>" class="btn btn-primary">View</a>
	<a href="index.php" class="btn btn-primary">Chat Now</a></p>
	
	
</body>
</html>
