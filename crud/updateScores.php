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

// Handle updating scores for indicators
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $siblingId = $_POST["siblingId"];
    $punctualityScore = $_POST["punctualityScore"];
    $eatingScore = $_POST["eatingScore"];
    $homeworkScore = $_POST["homeworkScore"];

    // Get current scores and number of entries
    $getScoresQuery = "SELECT punctuality_score, eating_score, homework_score, num_entries, overall_average FROM siblings WHERE id = $siblingId";
    $scoresResult = $conn->query($getScoresQuery);

    if ($scoresResult->num_rows > 0) {
        $scoresData = $scoresResult->fetch_assoc();
        $currentNumEntries = $scoresData["num_entries"];
        $newNumEntries = $currentNumEntries + 1;

        $previousAverage = $currentNumEntries > 0 ? $scoresData["overall_average"] : 0;
        $newPunctualityScore = ($scoresData["punctuality_score"] * $currentNumEntries + $punctualityScore) / $newNumEntries;
        $newEatingScore = ($scoresData["eating_score"] * $currentNumEntries + $eatingScore) / $newNumEntries;
        $newHomeworkScore = ($scoresData["homework_score"] * $currentNumEntries + $homeworkScore) / $newNumEntries;

        // Update scores, previous average, and number of entries
        $updateQuery = "UPDATE siblings SET punctuality_score = $newPunctualityScore, eating_score = $newEatingScore, homework_score = $newHomeworkScore, previous_average = $previousAverage, overall_average = ($punctualityScore + $eatingScore + $homeworkScore) / 3, num_entries = $newNumEntries WHERE id = $siblingId";

        if ($conn->query($updateQuery) === TRUE) {
            echo json_encode(array("message" => "Scores updated successfully."));
        } else {
            echo json_encode(array("message" => "Error updating scores: " . $conn->error));
        }
    } else {
        echo json_encode(array("message" => "Sibling not found."));
    }
}

// Close the connection
$conn->close();
?>
