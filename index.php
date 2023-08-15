<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sibling";

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

// Handle adding scores
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $siblingId = $_POST["siblingId"];
    $score = $_POST["score"];

    $updateQuery = "UPDATE siblings SET score = score + $score WHERE id = $siblingId";
    if ($conn->query($updateQuery) === TRUE) {
        echo json_encode(array("message" => "Score added successfully."));
    } else {
        echo json_encode(array("message" => "Error adding score: " . $conn->error));
    }
}

$conn->close();
?>
