<?php
header('Content-Type: application/json');

// Database connection
include 'dbconn.php';

try {
    // Get the raw POST data
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate required fields
    if (empty($data['firstName']) || empty($data['lastName']) || empty($data['email'])) {
        echo json_encode(['success' => false, 'message' => 'First name, last name, and email are required.']);
        exit;
    }

    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO user_profiles (first_name, last_name, position, summary, mobile_number, email, location, facebook_link, twitter_url, instagram_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssssssss",
        $data['firstName'],
        $data['lastName'],
        $data['position'],
        $data['summary'],
        $data['mobileNumber'],
        $data['email'],
        $data['location'],
        $data['facebookLink'],
        $data['twitterUrl'],
        $data['instagramUrl']
    );

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
