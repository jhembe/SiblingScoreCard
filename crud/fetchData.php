<?php
    require_once '../Schema/config.php';

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
