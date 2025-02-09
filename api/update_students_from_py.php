<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
$conn = ""; // Your database connection details here
require 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the JSON input
    // Get the JSON input
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);

// Check if the necessary parameters are set
    if (isset($input['name']) && isset($input['level']) && isset($input['crc_hash'])) {
        $name = $input['name'];
        $level = $input['level'];
        $crc_hash = $input['crc_hash'];

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO students (name, level, student_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $name, $level, $crc_hash);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(['status' => true, 'message' => 'Data inserted successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Data insertion failed: ' . $stmt->error]);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(['status' => false, 'message' => 'Missing required parameters']);
    }


    // Close the connection
    $conn->close();
}
?>
