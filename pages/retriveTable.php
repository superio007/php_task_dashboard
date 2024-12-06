<?php
// Include the database connection
include "dbconn.php";

// Get the JSON input
$requestBody = file_get_contents("php://input");

// Decode the JSON input
$data = json_decode($requestBody, true);

// Check if the 'year' variable is present in the JSON
if (isset($data['year']) && isset($data['start']) && isset($data['end'])) {
    $year = $data['year'];
    $start = (int)$data['start']; // Ensure these are integers
    $end = (int)$data['end'];

    // Calculate the limit (number of rows to fetch)
    $limit = $end - $start;

    // Prepare SQL query
    $sql = "SELECT * FROM `insights_data` WHERE end_year = $year LIMIT $start, $limit";

    // Execute query
    $result = $conn->query($sql);

    if ($result) {
        $tableContents = $result->fetch_all(MYSQLI_ASSOC);
        $conn->close();

        // Respond with the region counts
        echo json_encode([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'regionCounts' => $tableContents
        ]);
    } else {
        // Handle SQL error
        echo json_encode([
            'status' => 'error',
            'message' => 'SQL error: ' . $conn->error
        ]);
    }
} else {
    // Handle missing variables
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid JSON input or missing variables'
    ]);
}
?>
