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

            // Save file path to the database
            $sql = "INSERT INTO user_imageuploads (username, image_path) VALUES ('$username', '$targetFilePath')";
            if ($conn->query($sql) === TRUE) {
                echo "Image path saved to database successfully!<br>";
            } else {
                echo "Error saving image path to database: " . $conn->error . "<br>";
            }
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }
    $conn->close();
}
?>
