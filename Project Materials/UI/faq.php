<?php
// Database connection
$servername = "localhost";
$username = "root"; // Your DB username
$password = ""; // Your DB password
$dbname = "QueriesDB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    
}


// Fetch queries and replies
$sql = "SELECT ID, Query, Reply FROM FAQ";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .faq {
            margin: 20px;
        }
        .faq h2 {
            color: #333;
        }
        .faq-item {
            margin-bottom: 15px;
        }
        .query {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .reply {
            margin-left: 15px;
        }
    </style>
</head>
<body>
    <div class="faq">
        <h2>Frequently Asked Questions</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='faq-item'>";
                echo "<div class='query'>" . $row["ID"] . ". " . $row["Query"] . "</div>";
                echo "<div class='reply'>" . $row["Reply"] . "</div>";
                echo "</div>";
            }
        } else {
            echo "No FAQs available.";
        }
        $conn->close();    
        ?>
    </div>
</body>
</html>