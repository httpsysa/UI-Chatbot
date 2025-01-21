<?php
$conn = new mysqli('localhost', 'root', '', 'QueriesDB');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT ID AS id, Query AS query, Reply AS reply FROM FAQ");
if ($result) {
    $entries = [];
    while ($row = $result->fetch_assoc()) {
        $entries[] = $row;
    }
    echo json_encode($entries);
} else {
    echo json_encode(['error' => $conn->error]);
}
?>
