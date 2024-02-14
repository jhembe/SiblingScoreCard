<?php
    require_once '../Schema/config.php';

    // Handle updating scores for indicators
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $doctorId = $_POST["doctorId"];
        $punctualityScore = $_POST["punctualityScore"];
        $revenueScore = $_POST["revenueScore"];
        $satisfiabilityScore = $_POST["satisfiabilityScore"];

        // Get current scores and number of entries
        $getScoresQuery = "SELECT punctuality_score, revenue_score, satisfaction_score, num_entries, overall_average FROM doctors WHERE id = $doctorId";
        $scoresResult = $conn->query($getScoresQuery);

        if ($scoresResult->num_rows > 0) {
            $scoresData = $scoresResult->fetch_assoc();
            $currentNumEntries = $scoresData["num_entries"];
            $newNumEntries = $currentNumEntries + 1;

            $previousAverage = $currentNumEntries > 0 ? $scoresData["overall_average"] : 0;
            $newPunctualityScore = ($scoresData["punctuality_score"] * $currentNumEntries + $punctualityScore) / $newNumEntries;
            $newRevenueScore = ($scoresData["revenue_score"] * $currentNumEntries + $revenueScore) / $newNumEntries;
            $newSatisfactionScore = ($scoresData["satisfaction_score"] * $currentNumEntries + $satisfiabilityScore) / $newNumEntries;

            // Update scores, previous average, and number of entries
            $updateQuery = "UPDATE doctors SET punctuality_score = $newPunctualityScore, revenue_score = $newRevenueScore, satisfaction_score = $newSatisfactionScore, previous_average = $previousAverage, overall_average = ($punctualityScore + $revenueScore + $satisfiabilityScore) / 3, num_entries = $newNumEntries WHERE id = $doctorId";

            if ($conn->query($updateQuery) === TRUE) {
                echo json_encode(array("message" => "Scores updated successfully."));
            } else {
                echo json_encode(array("message" => "Error updating scores: " . $conn->error));
            }
        } else {
            echo json_encode(array("message" => "Doctor not found."));
        }
    }

    // Close the connection
    $conn->close();
?>
