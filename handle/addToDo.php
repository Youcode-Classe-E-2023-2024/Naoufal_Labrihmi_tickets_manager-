<?php
require_once '../App.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have appropriate validation and sanitation in place
    $title = $_POST['title'];
    $developer_ids = isset($_POST['developer_ids']) ? $_POST['developer_ids'] : [];
    $priority_id = $_POST['priority_id'];
    $tags = isset($_POST['tags']) ? $_POST['tags'] : [];

    // Perform your database insertion
    $stm = $conn->prepare("INSERT INTO todo (title, priority_id, created_at, status) VALUES (:title, :priority_id, NOW(), 'todo')");
    $stm->bindParam(':title', $title, PDO::PARAM_STR);
    $stm->bindParam(':priority_id', $priority_id, PDO::PARAM_INT);

    $success = $stm->execute();

    if ($success) {
        $newTaskId = $conn->lastInsertId();

        // Insert tags into todo_tags table
        foreach ($tags as $tagId) {
            $tagStmt = $conn->prepare("INSERT INTO todo_tags (todo_id, tag_id) VALUES (:todo_id, :tag_id)");
            $tagStmt->bindParam(':todo_id', $newTaskId, PDO::PARAM_INT);
            $tagStmt->bindParam(':tag_id', $tagId, PDO::PARAM_INT);
            $tagStmt->execute();
        }

        // Insert developers into todo_developers table
        foreach ($developer_ids as $developer_id) {
            $insertTodoDevelopers = $conn->prepare("INSERT INTO todo_developers (todo_id, developer_id) VALUES (:todo_id, :developer_id)");
            $insertTodoDevelopers->bindParam(':todo_id', $newTaskId, PDO::PARAM_INT);
            $insertTodoDevelopers->bindParam(':developer_id', $developer_id, PDO::PARAM_INT);
            $insertTodoDevelopers->execute();
        }

        // Fetch the priority name
        $priorityStmt = $conn->prepare("SELECT name FROM priorities WHERE id = :priority_id");
        $priorityStmt->bindParam(':priority_id', $priority_id, PDO::PARAM_INT);
        $priorityStmt->execute();
        $priority = $priorityStmt->fetch(PDO::FETCH_ASSOC);

        // Fetch tags for the new task
        $tagsStmt = $conn->prepare("SELECT tags.name FROM tags INNER JOIN todo_tags ON tags.id = todo_tags.tag_id WHERE todo_tags.todo_id = :todo_id");
        $tagsStmt->bindParam(':todo_id', $newTaskId, PDO::PARAM_INT);
        $tagsStmt->execute();
        $tagsList = $tagsStmt->fetchAll(PDO::FETCH_COLUMN);

        // Fetch developers for the new task
        $developersStmt = $conn->prepare("SELECT developers.name FROM developers WHERE developers.id IN (" . implode(',', $developer_ids) . ")");
        $developersStmt->execute();
        $developersList = $developersStmt->fetchAll(PDO::FETCH_COLUMN);

        $newTask = array(
            'id' => $newTaskId,
            'title' => $title,
            'created_at' => date('Y-m-d H:i:s'),
            'status' => 'todo',
            'priority_id' => $priority_id,
            'priority_name' => $priority['name'], // Add the priority's name to the new task
            'tags' => $tagsList, // Add the selected tags to the new task
            'developer_names' => $developersList, // Add the selected developer names to the new task
        );

        $response = array('success' => true, 'newTask' => $newTask);
    } else {
        $response = array('success' => false, 'error' => 'Failed to add task.');
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} else {
    header('Location: ../index.php'); // Redirect if accessed directly
    exit;
}
?>
