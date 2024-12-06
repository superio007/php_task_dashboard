<?php
session_start(); // Start the session

// Check if the data is sent via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = isset($_POST['email']) ? $_POST['email'] : null;

  // Validate inputs
  if ($email) {
    $_SESSION['email'] = $email; // Add data to the session
    echo json_encode(['status' => 'success', 'message' => 'Data added to session']);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
