<?php
    require_once '../Schema/config.php';

    // Fetch Doctors data
    $query = "SELECT * FROM doctors";
    $result = $conn->query($query);

    $doctors = array();
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }

    // Return fetched doctors data as JSON array
    echo json_encode($doctors);

    $conn->close();
?>
