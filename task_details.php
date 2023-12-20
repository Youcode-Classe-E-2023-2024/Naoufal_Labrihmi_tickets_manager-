<?php
require_once 'inc/header.php';
require_once 'App.php'; // Adjust this include based on your project structure


require_once 'Classes/Session.php';

// Initialize the $session object
$session = new Session();

// Check if the developer is not logged in
if (!$session->hasGet('user_id')) {
    header("Location: login.php");
    exit();
}

// Get user ID from the session
$user_id = $session->get('user_id');

// Check if the task ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirect to index.php or handle the situation where the ID is not provided
    header("Location: index.php");
    exit();
}

// Get the task ID from the URL
$task_id = $_GET['id'];

// Fetch the task details from the database
$taskQuery = $conn->prepare("
    SELECT todo.*, priorities.name AS priority_name, developers.name AS created_by_name
    FROM todo
    LEFT JOIN priorities ON todo.priority_id = priorities.id
    LEFT JOIN developers ON todo.created_by = developers.id
    WHERE todo.id = :task_id
");
$taskQuery->bindParam(':task_id', $task_id, PDO::PARAM_INT);
$taskQuery->execute();
$task = $taskQuery->fetch(PDO::FETCH_ASSOC);

// Check if the task with the provided ID exists
if (!$task) {
    // Redirect to index.php or handle the situation where the task is not found
    header("Location: index.php");
    exit();
}

// Fetch additional details for the task, such as developers and tags
$developerStmt = $conn->prepare("SELECT developers.name FROM developers INNER JOIN todo_developers ON developers.id = todo_developers.developer_id WHERE todo_developers.todo_id = :todo_id");
$developerStmt->bindParam(':todo_id', $task['id'], PDO::PARAM_INT);
$developerStmt->execute();
$developerNames = $developerStmt->fetchAll(PDO::FETCH_COLUMN);

$tagsQuery = $conn->prepare("SELECT tags.name FROM tags INNER JOIN todo_tags ON tags.id = todo_tags.tag_id WHERE todo_tags.todo_id = :todo_id");
$tagsQuery->bindParam(':todo_id', $task['id'], PDO::PARAM_INT);
$tagsQuery->execute();
$tags = $tagsQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <!-- Add your CSS links or stylesheets here -->
    <link rel="stylesheet" href="your-styles.css">
</head>
<body>
    <!-- Add your HTML content here for displaying task details -->
    <div class="container my-3">
        <h2>Task Details</h2>
        <div class="alert alert-info p-2">
            <h4><strong>Task name: </strong><?= htmlspecialchars($task['title']) ?></h4>
            <p><h5><strong>Description:</strong> <?= htmlspecialchars($task['description']) ?></h5></p>
            <h5>Task assigned to: <?= implode(', ', $developerNames) ?></h5>
            <h5>Priority: <?= htmlspecialchars($task['priority_name']) ?></h5>
            <h5>Created by: <?= htmlspecialchars($task['created_by_name']) ?></h5>
            <h5>Created at: <?= htmlspecialchars($task['created_at']) ?></h5>
            <!-- Add tags similar to the "All Task" section -->
            <?php if (!empty($tags)) : ?>
                <div class="mb-2">
                    <strong>Tags: </strong>
                    <?php foreach ($tags as $tag) : ?>
                        <span class="badge bg-info"><?= htmlspecialchars($tag['name']) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <!-- Add other details as needed -->
            <div class="mt-3">
                <a href="index.php" class="btn btn-info">Back to All Tasks</a>
            </div>
        </div>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Add this section to display comments -->
<div class="mt-3">
    <h3>Comments</h3>
    <ul id="commentList">
        <!-- Existing comments will be displayed here -->
    </ul>
</div>

<!-- Add this form for submitting new comments -->
<div class="mt-3">
    <h3>Add a Comment</h3>
    <form id="commentForm">
        <div class="mb-3">
            <label for="commentText" class="form-label">Comment:</label>
            <textarea class="form-control" id="commentText" name="commentText" rows="3"></textarea>
        </div>
        <button type="button" class="btn btn-primary" onclick="submitComment()">Submit Comment</button>
    </form>
</div>

<script>
    // Function to submit a new comment
    function submitComment() {
        var commentText = $('#commentText').val();

        // Check if the comment is not empty
        if (commentText.trim() !== '') {
            // Make an AJAX request to save the comment
            $.ajax({
                url: 'save_comment.php', // Replace with the actual server-side script to handle comment submission
                method: 'POST',
                data: { commentText: commentText },
                success: function (response) {
                    // If the comment is successfully saved, add it to the comment list
                    $('#commentList').append('<li>' + commentText + '</li>');
                    // Clear the textarea
                    $('#commentText').val('');
                },
                error: function (error) {
                    console.error('Error submitting comment:', error);
                }
            });
        }
    }

    // Function to load existing comments (you may need to modify this based on your server-side implementation)
    function loadComments() {
        $.ajax({
            url: 'load_comments.php', // Replace with the actual server-side script to load comments
            method: 'GET',
            success: function (response) {
                // Assuming the response is an array of comments
                var comments = response.comments;
                // Populate the comment list
                comments.forEach(function (comment) {
                    $('#commentList').append('<li>' + comment.comment_text + '</li>');
                });
            },
            error: function (error) {
                console.error('Error loading comments:', error);
            }
        });
    }

    // Load existing comments when the page loads
    $(document).ready(function () {
        loadComments();
    });
</script>
