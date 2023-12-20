<?php

// Include the comments functions
include 'comments_functions.php';

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve the task ID from the query parameters
    $taskId = $_GET['taskId'];

    // Perform validation on $taskId if needed

    // Get comments for the specified task ID
    $comments = getCommentsFromDatabase($taskId);

    // Format the comments array to send back to the client
    $response = ['status' => 'success', 'comments' => $comments];

    // Send the response as JSON
    echo json_encode($response);
} else {
    // If the request method is not GET, return an error
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

?>
