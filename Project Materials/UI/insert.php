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
        
        // Taking all 2 values from the form data(input)
        $queries =  $_REQUEST['queries'];
        $replies = $_REQUEST['replies'];

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
            // If all the fields are filled (not empty) 

            // Performing insert query execution
            $sql = "INSERT INTO chatbot VALUES ('','$insert_queries', '$insert_replies')";

            if(mysqli_query($conn, $sql)){
                // Display success message
                echo "<div class='alert alert-success'>Data added successfully.</div>";
                echo "<a href='view.php' class='btn btn-primary'>View Data</a>";
            } else{
                // Display error message
                echo "ERROR: Hush! Sorry $sql. " 
                . mysqli_error($conn);
            }
            // Close connection
            mysqli_close($conn);
        }
        ?>
</body>

</html>