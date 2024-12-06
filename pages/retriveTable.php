<?php
// Include the database connection
include "dbconn.php";

// Get the JSON input
$requestBody = file_get_contents("php://input");

// Decode the JSON input
$data = json_decode($requestBody, true);

// Check if required variables are present
if (isset($data['year']) && isset($data['start']) && isset($data['end'])) {
    $year = (int)$data['year'];
    $start = (int)$data['start'];
    $end = (int)$data['end'];

    // Optional sorting parameters
    $column = isset($data['column']) ? $data['column'] : null;
    $order = isset($data['order']) ? strtoupper($data['order']) : null;

    // Validate column name for sorting to prevent SQL injection
    $allowedColumns = ['topic', 'sector', 'source', 'city'];
    if ($column && !in_array($column, $allowedColumns)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid column for sorting'
        ]);
        exit;
    }

    // Default LIMIT
    $limit = $end - $start;

    // Base query
    $sql = "SELECT * FROM `insights_data` WHERE end_year = $year";

    // Append sorting if specified
    if ($column && $order) {
        $sql .= " ORDER BY $column $order";
    }

    // Append LIMIT clause
    $sql .= " LIMIT $start, $limit";

    // Execute query
    $result = $conn->query($sql);

    if ($result) {
        $tableContents = $result->fetch_all(MYSQLI_ASSOC);
        $conn->close();

        // Respond with the data
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
