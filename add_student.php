<?php
require 'auth/check_auth.php';
require 'config/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    $phone = trim($_POST['phone']);

    $sql = "INSERT INTO students (full_name, email, course, phone)
            VALUES (:full_name, :email, :course, :phone)";

    $stmt = $conn->prepare($sql);

    $result = $stmt->execute([
        'full_name' => $full_name,
        'email' => $email,
        'course' => $course,
        'phone' => $phone
    ]);

    if ($result) {
        $message = "Student added successfully";
    } else {
        $message = "Failed to add student";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>

<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">

    <h2>Add Student</h2>

    <form method="POST">

        <input type="text" name="full_name" placeholder="Full Name" required>

        <input type="email" name="email" placeholder="Email" required>

        <input type="text" name="course" placeholder="Course" required>

        <input type="text" name="phone" placeholder="Phone">

        <button type="submit">Add Student</button>

    </form>

    <?php if($message): ?>
        <p class="message"><?= $message ?></p>
    <?php endif; ?>

    <br>

    <a href="dashboard.php">← Back to Dashboard</a>

</div>

</body>
</html>