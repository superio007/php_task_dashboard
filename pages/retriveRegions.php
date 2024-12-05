<?php
// Include the database connection
include "dbconn.php";

// Get the JSON input
$requestBody = file_get_contents("php://input");

// Decode the JSON input
$data = json_decode($requestBody, true);

// Check if the 'year' variable is present in the JSON
if (isset($data['year'])) {
    $year = $data['year'];

    // Prepare the SQL query to fetch regions where end_year <= year
    $sql = "SELECT region FROM insights_data WHERE end_year <= ? LIMIT 300";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind the year parameter to the query
    $stmt->bind_param("i", $year);

    // Execute the query
    $stmt->execute();

    // Fetch all results
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    // Function to count regions
    function getRegionCounts($data) {
        $regionCounts = [];
        foreach ($data as $item) {
            if ($item['region'] !== null) {
                if (isset($regionCounts[$item['region']])) {
                    $regionCounts[$item['region']]++;
                } else {
                    $regionCounts[$item['region']] = 1;
                }
            }
        }
        return $regionCounts;
    }

    // Get region counts
    $regionCounts = getRegionCounts($rows);

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Respond with the region counts
    echo json_encode([
        'status' => 'success',
        'message' => 'Data retrieved successfully',
        'regionCounts' => $regionCounts
    ]);
} else {
    // Handle missing variables
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid JSON input or missing variables'
    ]);
}
?>
