<?php
require 'auth/check_auth.php';
require 'config/db.php';

$sql = "SELECT * FROM students ORDER BY id DESC";
$stmt = $conn->query($sql);

$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>

  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
<h2>Students List</h2>

<div class="top-links">
    <a href="dashboard.php">Dashboard</a> |
    <a href="add_student.php">Add Student</a>
</div>
<input type="text"
       id="search"
       placeholder="Search students..."
       style="width:300px;padding:10px;margin-bottom:20px;">

<table>

    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Course</th>
        <th>Phone</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>

    <tbody id="studentTable">

    <?php foreach($students as $student): ?>

    <tr>

        <td><?= $student['id']; ?></td>

        <td><?= htmlspecialchars($student['full_name']); ?></td>

        <td><?= htmlspecialchars($student['email']); ?></td>

        <td><?= htmlspecialchars($student['course']); ?></td>

        <td><?= htmlspecialchars($student['phone']); ?></td>

        <td><?= $student['created_at']; ?></td>

        <td>

            <a class="edit"
               href="edit_student.php?id=<?= $student['id']; ?>">
               Edit
            </a>

            <a class="delete"
               href="delete_student.php?id=<?= $student['id']; ?>"
               onclick="return confirm('Delete this student?')">
               Delete
            </a>

        </td>

    </tr>

    <?php endforeach; ?>

    </tbody>

</table>
    </div>
<script>

document.getElementById("search").addEventListener("keyup", function () {

    let query = this.value;

    let xhr = new XMLHttpRequest();

    xhr.open("GET", "ajax/live_search.php?query=" + query, true);

    xhr.onload = function () {

        if (this.status == 200) {
            document.getElementById("studentTable").innerHTML = this.responseText;
        }

    };

    xhr.send();

});

</script>
</body>
</html>