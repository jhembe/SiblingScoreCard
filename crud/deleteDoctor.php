<?php
    require_once '../Schema/config.php';


    // Handle updating scores for indicators
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $doctorId = $_POST["doctorId"];

    // Update scores, previous average, and number of entries
        $updateQuery = "DELETE FROM doctors WHERE id = $doctorId";
        
        if ($conn->query($updateQuery) === TRUE) {
            echo json_encode(array("message" => "Doctor Deleted successfully."));
            }
            else {
                echo json_encode(array("message" => "Error deleting the doctor: " . $conn->error));
            }
        } 
    
    else {
        echo json_encode(array("message" => "Doctor not found."));
    }


    // Close the connection
    $conn->close();
?>
