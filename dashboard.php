<?php
require 'auth/check_auth.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<link rel="stylesheet" href="assets/css/style.css">
<body>
<div class="container">

    <h1>Welcome, <?= $_SESSION['username']; ?></h1>

    <p>Student Management System Dashboard</p>

    <div class="dashboard-links">

        <a href="add_student.php">Add Student</a>

        <a href="view_students.php">View Students</a>

        <a href="auth/logout.php">Logout</a>

    </div>

</div>
</html>