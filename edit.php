<?php
require_once 'inc/header.php';
require_once 'App.php';

if ($request->hasGet("id")) {
    $id = $request->get("id");

    $stm = $conn->prepare("SELECT * FROM todo WHERE `id`=:id");
    $stm->bindparam(":id", $id, PDO::PARAM_INT);
    $stm->execute();
    $todo = $stm->fetch(PDO::FETCH_ASSOC);

    $developersStmt = $conn->query("SELECT * FROM developers");
} else {
    $request->header("index.php");
}
?>

<body class="container w-50 mt-5">
    <form action="handle/edit.php?id=<?php echo $id; ?>" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <textarea class="form-control" name="title" id="title" placeholder="Enter your note here"><?php echo $todo['title']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="developer_id" class="form-label">Assign to Developer:</label>
            <select class="form-select" name="developer_id" id="developer_id">
                <?php
                while ($developer = $developersStmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value=\"{$developer['id']}\" " . ($developer['id'] == $todo['developer_id'] ? 'selected' : '') . ">{$developer['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="text-center">
            <button type="submit" name="submit" class="btn btn-info mt-3">Update</button>
        </div>
    </form>
</body>
</html>
