<?php
include "dbconn.php";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username from the request
    $username = isset($_POST['username']) ? $_POST['username'] : 'Anonymous';

    // Directory to save uploaded images
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = basename($_FILES["userImage"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $uploadOk = 1;

    // Check if file is an image
    $check = getimagesize($_FILES["userImage"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }

    // Check file size (limit to 2MB)
    if ($_FILES["userImage"]["size"] > 2 * 1024 * 1024) {
        echo "Sorry, your file is too large.<br>";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.<br>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.<br>";
    } else {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["userImage"]["tmp_name"], $targetFilePath)) {
            echo "The file " . htmlspecialchars($fileName) . " has been uploaded.<br>";

            // Check if the username exists in the database
            $checkStmt = $conn->prepare("SELECT id FROM user_imageuploads WHERE username = ?");
            $checkStmt->bind_param("s", $username);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($result->num_rows > 0) {
                // Username exists, update the record
                $updateStmt = $conn->prepare("UPDATE user_imageuploads SET image_path = ? WHERE username = ?");
                $updateStmt->bind_param("ss", $targetFilePath, $username);
                if ($updateStmt->execute()) {
                    echo "Image path updated successfully in the database!<br>";
                } else {
                    echo "Error updating image path in the database: " . $updateStmt->error . "<br>";
                }
                $updateStmt->close();
            } else {
                // Username does not exist, insert a new record
                $insertStmt = $conn->prepare("INSERT INTO user_imageuploads (username, image_path) VALUES (?, ?)");
                $insertStmt->bind_param("ss", $username, $targetFilePath);
                if ($insertStmt->execute()) {
                    echo "Image path saved to database successfully!<br>";
                } else {
                    echo "Error saving image path to database: " . $insertStmt->error . "<br>";
                }
                $insertStmt->close();
            }

            $checkStmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }
    $conn->close();
}
?>
