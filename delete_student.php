<?php
require 'auth/check_auth.php';
require 'config/db.php';

if (isset($_GET['id'])) {

    $id = (int) $_GET['id'];

    $sql = "DELETE FROM students WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        'id' => $id
    ]);
}

header("Location: view_students.php");
exit();
?> 