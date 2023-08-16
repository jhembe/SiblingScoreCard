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

// Handle adding a new sibling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $siblingName = $_POST["siblingName"];

    // Insert new sibling name into the database
    $insertQuery = "INSERT INTO siblings (name) VALUES ('$siblingName')";
    if ($conn->query($insertQuery) === TRUE) {
        echo json_encode(array("message" => "Sibling added successfully."));
    } else {
        echo json_encode(array("message" => "Error adding sibling: " . $conn->error));
    }
}

// Close the connection
$conn->close();
?>
