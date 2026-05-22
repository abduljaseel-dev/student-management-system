<?php
session_start();
require '../config/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM admins WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['username' => $username]);

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['username'] = $admin['username'];

        header("Location: ../dashboard.php");
        exit();

    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
<div class="login-box">
    <h2>Admin Login</h2>

    <form method="POST">

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>

    </form>

    <?php if($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

</div>
    </div>
</body>
</html>