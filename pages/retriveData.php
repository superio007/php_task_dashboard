<?php
// Get the JSON input
include "dbconn.php";
$requestBody = file_get_contents("php://input");

// Decode the JSON input
$data = json_decode($requestBody, true);

// Check if variables are present in the JSON
if (isset($data['type']) && isset($data['year'])) {
    // Retrieve variables (optional use based on your logic)
    $type = $data['type'];
    $year = $data['year'];

    // Query to fetch data
    $sql = "
        SELECT end_year, MAX(" . $type . ") AS max_" . $type . "
        FROM insights_data
        WHERE relevance IS NOT NULL AND end_year <= $year
        GROUP BY end_year
        ORDER BY end_year ASC
        LIMIT 10;
    ";

    $result = $conn->query($sql);

    // Initialize arrays
    $labels = [];
    $values = [];

    if ($result && $result->num_rows > 0) {
        // Fetch data and store in arrays
        $count = 0; // For generating labels
        while ($row = $result->fetch_assoc()) {
            // Generate label names
            $labels[] = (int) $row["end_year"];
            $values[] = (float) $row["max_" . $type . ""]; // Store intensity
            $count++;
        }

        // Close the database connection
        $conn->close();

        // Respond with the arrays
        echo json_encode([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'labels' => $labels,
            'values' => $values
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No data found or query failed',
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
