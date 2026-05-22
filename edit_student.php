<?php
require 'auth/check_auth.php';
require 'config/db.php';

if (!isset($_GET['id'])) {
    header("Location: view_students.php");
    exit();
}

$id = (int) $_GET['id'];

$sql = "SELECT * FROM students WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $id]);

$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Student not found");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    $phone = trim($_POST['phone']);

    $updateSql = "UPDATE students
                  SET full_name = :full_name,
                      email = :email,
                      course = :course,
                      phone = :phone
                  WHERE id = :id";

    $updateStmt = $conn->prepare($updateSql);

    $result = $updateStmt->execute([
        'full_name' => $full_name,
        'email' => $email,
        'course' => $course,
        'phone' => $phone,
        'id' => $id
    ]);

    if ($result) {

        $message = "Student updated successfully";

        // Refresh updated data
        $stmt->execute(['id' => $id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

    } else {
        $message = "Update failed";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">

    <h2>Edit Student</h2>

    <form method="POST">

        <input type="text"
               name="full_name"
               value="<?= htmlspecialchars($student['full_name']); ?>"
               required>

        <input type="email"
               name="email"
               value="<?= htmlspecialchars($student['email']); ?>"
               required>

        <input type="text"
               name="course"
               value="<?= htmlspecialchars($student['course']); ?>"
               required>

        <input type="text"
               name="phone"
               value="<?= htmlspecialchars($student['phone']); ?>">

        <button type="submit">Update Student</button>

    </form>

    <?php if($message): ?>
        <p class="message"><?= $message ?></p>
    <?php endif; ?>

    <br>

    <a href="view_students.php">← Back</a>

</div>

</body>
</html>