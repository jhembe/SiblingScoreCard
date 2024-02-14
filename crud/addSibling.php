<?php

    require_once '../Schema/config.php';

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
