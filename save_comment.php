<?php

// Include the comments functions
include 'comments_functions.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the comment details from the POST data
    $taskId = $_POST['taskId'];
    $commentText = $_POST['commentText'];
    $postedBy = $_POST['postedBy']; // Assuming you have a way to determine the user posting the comment

    // Perform validation on $taskId, $commentText, and $postedBy if needed

    // Save the comment to the database
    $commentId = saveCommentToDatabase($taskId, $commentText, $postedBy);

    // Send a response back to the client
    if ($commentId) {
        echo json_encode(['status' => 'success', 'commentId' => $commentId]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save comment']);
    }
} else {
    // If the request method is not POST, return an error
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

?>
