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

// Handle updating scores for indicators
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $siblingId = $_POST["siblingId"];
    $punctualityScore = $_POST["punctualityScore"];
    $eatingScore = $_POST["eatingScore"];
    $homeworkScore = $_POST["homeworkScore"];

    $updateQuery = "UPDATE siblings SET punctuality_score = $punctualityScore, eating_score = $eatingScore, homework_score = $homeworkScore WHERE id = $siblingId";
    if ($conn->query($updateQuery) === TRUE) {
        echo json_encode(array("message" => "Scores updated successfully."));
    } else {
        echo json_encode(array("message" => "Error updating scores: " . $conn->error));
    }
}


function calculateOverallAverage($sibling) {
    $totalScores = $sibling["punctuality_score"] + $sibling["eating_score"] + $sibling["homework_score"];
    $average = $totalScores / 3; // Assuming there are three key indicators
    return round($average, 2); // Calculate and return average rounded to two decimal places
}

$conn->close();
?>
