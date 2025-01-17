<!DOCTYPE html>
<html>

<head>
    <title>CHATBOT - iTech</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
        table { border-collapse: initial; }
        table td, table th { padding: 10px; text-align: left; }
        body{ text-align: center; }
    </style>
</head>

<body>
    <h1>CHATBOT - iTech</h1>
    <p><a href="addform.php" class="btn btn-primary">Add New Data</a>
    <a href="index.php" class="btn btn-primary">Chat Now</a></p>
    <?php

        // servername => localhost
        // username => root
        // password => empty
        // database name => bot
        $conn = mysqli_connect("localhost", "root", "", "bot");
        
        // Check connection
        if($conn === false){
            die("ERROR: Could not connect. " 
                . mysqli_connect_error());
        }
        ?>
    <?php
            $limit = 5;  //set  Number of entries to show in a page.
            // Look for a GET variable page if not found default is 1.        
            if (isset($_GET["page"])) {    
            $page  = $_GET["page"];    
            }    
            else { $page=1;    
            } 
            //determine the sql LIMIT starting number for the results on the displaying page  
            $page_index = ($page-1) * $limit;      // 0

            $result=mysqli_query($conn,"select * from chatbot ORDER BY id limit $page_index, $limit");
            
        ?>
    <?php
    // Fetch data in descending order (lastest entry first)
    //$result = mysqli_query($conn, "SELECT * FROM chatbot ORDER BY id ASC");
    ?>
    <table width='100%' border=0 cellspacing="1" cellpadding="1">
        <COLGROUP>
            <COL style="width:10%">
            <COL style="width:35%">
            <COL style="width:35%">
            <COL style="width:20%">
        </COLGROUP>
		<tr bgcolor='#cccccc'>
            <th><strong>ID</strong></th>
			<th><strong>Queries</strong></th>
			<th><strong>Replies</strong></th>
            <th colspan="2">Action</th>
		</tr>
		<?php
		// Fetch the next row of a result set as an associative array
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<tr  bgcolor='#eeeeee'>";
			echo "<td>".$row['id']."</td>";
			echo "<td>".$row['queries']."</td>";
			echo "<td>".$row['replies']."</td>";
            echo "<td><a href=\"edit.php?page=$page&id=$row[id]\">Edit</a> | 
			<a href=\"delete.php?page=$page&id=$row[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td></tr>";
		}
		?>
	</table>
    <br />
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            
        <?php
        $all_data=mysqli_query($conn,"select count(*) from chatbot ORDER BY id");
        $user_count = mysqli_fetch_row($all_data);   // say total count 9  
        $total_records = $user_count[0];   //9
        $total_pages = ceil($total_records / $limit);    // 9/3=  3
        
        if($page >= 2){
            echo "<li class='page-item'><a href='view.php?page=".($page-1)."' class='page-link' href='#' tabindex='-1'>Previous</a></li>";
        } else {
            echo "<li class='page-item disabled'><a class='page-link' href='#' tabindex='-1'>Previous</a></li>";
        }
        for ($i=1; $i<=$total_pages; $i++) {  
            if($i == $page){
                echo "<li class='page-item active'> <a class='page-link' href='#' tabindex='-1'> ".$page." <span class='sr-only'>(current)</span></a></li>";
            }else{
               echo "<li class='page-item'><a class='page-link' href='view.php?page=".$i."'>".$i."</a></li>";
            }
        
        }; 
        if($page<$total_pages) {
            echo "<li class='page-item'><a href='view.php?page=".($page+1)."' class='page-link'>Next</a></li>";   
        } else {
            echo "<li class='page-item disabled'><a href='#' class='page-link'>Next</a></li>";
        }
        ?>
        </ul>
    </nav>

    <?php
       // Close connection
       mysqli_close($conn);
     ?>
     <footer>Chatbot iTech. 2024 All rights reserved.</footer>
</body>

</html>