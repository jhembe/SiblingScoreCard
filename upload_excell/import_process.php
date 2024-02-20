<?php
require 'vendor/autoload.php'; // Include the PhpSpreadsheet library

use PhpOffice\PhpSpreadsheet\IOFactory;

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "scoreCardTest";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the uploaded Excel file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["excelFile"]) && $_FILES["excelFile"]["error"] == UPLOAD_ERR_OK) {
        $excelFile = $_FILES["excelFile"]["tmp_name"];

        // Load the Excel file using PhpSpreadsheet
        $excelObj = IOFactory::load($excelFile);
        $worksheet = $excelObj->getActiveSheet();

        // Prepare a statement for insertion
        $insertQuery = $conn->prepare("INSERT INTO doctors (name, punctuality_score, revenue_score, satisfaction_score, overall_average) VALUES (?, ?, ?, ?, ?)");

        // Loop through the rows and insert data into the database
        $highestRow = $worksheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            $name = $worksheet->getCell('A' . $row)->getValue();
            $punctualityScore = $worksheet->getCell('B' . $row)->getValue();
            $revenueScore = $worksheet->getCell('C' . $row)->getValue();
            $satisfaction = $worksheet->getCell('D' . $row)->getValue();
            $overallAverage = $worksheet->getCell('E' . $row)->getValue();

            // Bind parameters and execute the statement
            $insertQuery->bind_param("sdddd", $name, $punctualityScore, $revenueScore, $satisfaction, $overallAverage);
            if ($insertQuery->execute()) {
                // Data inserted successfully
            } else {
                echo "Error inserting data: " . $conn->error;
            }
        }

        // Redirect back to upload.html with a success message
        header("Location: index.php?message=Data%20import%20successful");
        exit();
    } else {
        echo "Error uploading file.";
    }
}

// Close the connection
$conn->close();
?>
