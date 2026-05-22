<?php
require '../config/db.php';

$search = $_GET['query'] ?? '';

$sql = "SELECT * FROM students
        WHERE full_name LIKE :search
        OR email LIKE :search
        OR course LIKE :search
        ORDER BY id DESC";

$stmt = $conn->prepare($sql);

$stmt->execute([
    'search' => "%$search%"
]);

$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($students) {

    foreach ($students as $student) {

        echo "
        <tr>
            <td>{$student['id']}</td>
            <td>" . htmlspecialchars($student['full_name']) . "</td>
            <td>" . htmlspecialchars($student['email']) . "</td>
            <td>" . htmlspecialchars($student['course']) . "</td>
            <td>" . htmlspecialchars($student['phone']) . "</td>
            <td>{$student['created_at']}</td>

            <td>
                <a class='edit'
                   href='edit_student.php?id={$student['id']}'>
                   Edit
                </a>

                <a class='delete'
                   href='delete_student.php?id={$student['id']}'
                   onclick='return confirm(\"Delete this student?\")'>
                   Delete
                </a>
            </td>
        </tr>
        ";
    }

} else {

    echo "
    <tr>
        <td colspan='7'>No students found</td>
    </tr>
    ";
}
?>