<?php
require_once '../App.php';

if ($request->hasPost("submit") && $request->hasGet("id")) {
    $id = $request->get("id");
    $title = $request->clean("title");
    $developerId = $request->clean("developer_id");

    $validation->validate("title", $title, ["Required", "Str"]);
    $validation->validate("developer_id", $developerId, ["Int"]);

    $errors = $validation->getError();

    if (empty($errors)) {
        $stm = $conn->prepare("SELECT * FROM todo WHERE `id`=:id");
        $stm->bindparam(":id", $id, PDO::PARAM_INT);
        $out = $stm->execute();

        if ($out) {
            $stm = $conn->prepare("UPDATE todo SET `title`=:title, `developer_id`=:developer_id WHERE id=:id");
            $stm->bindparam(":id", $id, PDO::PARAM_INT);
            $stm->bindparam(":title", $title, PDO::PARAM_STR);
            $stm->bindparam(":developer_id", $developerId, PDO::PARAM_INT);
            $todo_update = $stm->execute();

            if ($todo_update) {
                $session->set("success", "Data is Updated Successfully");
                $request->header("../index.php");
            } else {
                $session->set("error", "Data is not Updated");
                $request->header("../edit.php?id=$id");
            }
        } else {
            $session->set("error", "Data is not Found");
            $request->header("../index.php");
        }
    } else {
        $session->set("errors", $errors);
        $request->header("../edit.php?id=$id");
    }
} else {
    $session->set("error", "Error");
    $request->header("../index.php");
}
?>
