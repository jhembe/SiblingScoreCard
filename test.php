// Handle updating scores for indicators
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $siblingId = $_POST["siblingId"];
    $punctualityScore = $_POST["punctualityScore"];
    $eatingScore = $_POST["eatingScore"];
    $homeworkScore = $_POST["homeworkScore"];

    // Get current scores and number of entries
    $getScoresQuery = "SELECT punctuality_score, eating_score, homework_score, cumulative_average, num_entries FROM siblings WHERE id = $siblingId";
    $scoresResult = $conn->query($getScoresQuery);

    if ($scoresResult->num_rows > 0) {
        $scoresData = $scoresResult->fetch_assoc();
        $currentNumEntries = $scoresData["num_entries"];
        $newNumEntries = $currentNumEntries + 1;

        $previousCumulativeAverage = $scoresData["cumulative_average"];
        $currentAverageScore = ($punctualityScore + $eatingScore + $homeworkScore) / 3;

        // Weighted average calculation for cumulative average
        $cumulativeAverage = ($currentAverageScore + $previousCumulativeAverage * $currentNumEntries) / $newNumEntries;

        // Update scores, cumulative average, and number of entries
        $updateQuery = "UPDATE siblings SET punctuality_score = $punctualityScore, eating_score = $eatingScore, homework_score = $homeworkScore, cumulative_average = $cumulativeAverage, num_entries = $newNumEntries WHERE id = $siblingId";

        if ($conn->query($updateQuery) === TRUE) {
            echo json_encode(array("message" => "Scores updated successfully."));
        } else {
            echo json_encode(array("message" => "Error updating scores: " . $conn->error));
        }
    } else {
        echo json_encode(array("message" => "Sibling not found."));
    }
}
