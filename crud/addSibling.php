<?php

    require_once '../Schema/config.php';

    // Handle adding a new doctor
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $doctorName = $_POST["doctorName"];
        // $doctorName = 'Kenshi';


        // Insert new doctor's name into the database
        $insertQuery = "INSERT INTO doctors (name) VALUES ('$doctorName')";
        if ($conn->query($insertQuery) === TRUE) {
            echo json_encode(array("message" => "Doctor added successfully."));
        } else {
            echo json_encode(array("message" => "Error adding Doctor: " . $conn->error));
        }
    }

    // Close the connection
    $conn->close();
?>
