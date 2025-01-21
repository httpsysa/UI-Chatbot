<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "QueriesDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$id = $_POST['id'] ?? null;
$query = $_POST['query'];
$reply = $_POST['reply'];

if ($id) {
    // Update entry
    $sql = "UPDATE FAQ SET Query=?, Reply=? WHERE ID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $query, $reply, $id);
} else {
    // Insert new entry
    $sql = "INSERT INTO FAQ (Query, Reply) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $query, $reply);
}

if ($stmt->execute()) {
    // Return updated list
    $sql = "SELECT ID AS id, Query AS query, Reply AS reply FROM FAQ";
    $result = $conn->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Failed to save entry']);
}

$stmt->close();
$conn->close();
?>