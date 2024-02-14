<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "scoreCardTest";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch sibling data
$query = "SELECT * FROM siblings";
$result = $conn->query($query);

$siblings = array();
while ($row = $result->fetch_assoc()) {
    $siblings[] = $row;
}

// Return fetched sibling data as JSON
echo json_encode($siblings);

$conn->close();
?>
