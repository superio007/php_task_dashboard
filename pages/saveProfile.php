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

    // Check if the email already exists in the database
    $checkStmt = $conn->prepare("SELECT id FROM user_profiles WHERE email = ?");
    $checkStmt->bind_param("s", $data['email']);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Email exists, update the record
        $updateStmt = $conn->prepare("UPDATE user_profiles SET first_name = ?, last_name = ?, position = ?, summary = ?, mobile_number = ?, location = ?, facebook_link = ?, twitter_url = ?, instagram_url = ? WHERE email = ?");
        $updateStmt->bind_param(
            "ssssssssss",
            $data['firstName'],
            $data['lastName'],
            $data['position'],
            $data['summary'],
            $data['mobileNumber'],
            $data['location'],
            $data['facebookLink'],
            $data['twitterUrl'],
            $data['instagramUrl'],
            $data['email']
        );

        if ($updateStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Record updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $updateStmt->error]);
        }

        $updateStmt->close();
    } else {
        // Email does not exist, insert a new record
        $insertStmt = $conn->prepare("INSERT INTO user_profiles (first_name, last_name, position, summary, mobile_number, email, location, facebook_link, twitter_url, instagram_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insertStmt->bind_param(
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

        if ($insertStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Record inserted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $insertStmt->error]);
        }

        $insertStmt->close();
    }

    $checkStmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
