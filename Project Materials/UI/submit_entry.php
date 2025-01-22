<?php
require 'db_connection.php';
$id = $_POST['id'] ?? null;
$query = trim($_POST['query'] ?? '');
$reply = trim($_POST['reply'] ?? '');

header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "QueriesDB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Handle database connection error
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Validate POST data
$id = $_POST['id'] ?? null;
$query = trim($_POST['query'] ?? '');
$reply = trim($_POST['reply'] ?? '');

if (empty($query) || empty($reply)) {
    echo json_encode(['error' => 'Query and Reply fields cannot be empty.']);
    exit;
}

// Check for duplicate query
if ($id) {
    $checkSql = "SELECT COUNT(*) AS count FROM FAQ WHERE Query = ? AND ID != ?";
    $checkStmt = $conn->prepare($checkSql);
    if (!$checkStmt) {
        echo json_encode(['error' => 'Failed to prepare duplicate check: ' . $conn->error]);
        exit;
    }
    $checkStmt->bind_param("si", $query, $id);
} else {
    $checkSql = "SELECT COUNT(*) AS count FROM FAQ WHERE Query = ?";
    $checkStmt = $conn->prepare($checkSql);
    if (!$checkStmt) {
        echo json_encode(['error' => 'Failed to prepare duplicate check: ' . $conn->error]);
        exit;
    }
    $checkStmt->bind_param("s", $query);
}

if (!$checkStmt->execute()) {
    echo json_encode(['error' => 'Failed to execute duplicate check.']);
    exit;
}

$checkResult = $checkStmt->get_result();
$duplicate = $checkResult->fetch_assoc()['count'] > 0;

if ($duplicate) {
    echo json_encode(['error' => 'This query already exists.']);
    $checkStmt->close();
    $conn->close();
    exit;
}

$checkStmt->close();

// Insert or Update entry
if ($id) {
    $sql = "UPDATE FAQ SET Query = ?, Reply = ? WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => 'Failed to prepare update statement: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("ssi", $query, $reply, $id);
} else {
    $sql = "INSERT INTO FAQ (Query, Reply) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => 'Failed to prepare insert statement: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("ss", $query, $reply);
}

if ($stmt->execute()) {
    $sql = "SELECT ID AS id, Query AS query, Reply AS reply FROM FAQ";
    $result = $conn->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Failed to save entry: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>