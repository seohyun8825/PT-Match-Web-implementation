<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matching Requests</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['teacher_id'])) {
        header('Location: login.php');
        exit();
    }

    include 'config.php';

    // 매칭 요청 목록 조회
    $sql = "SELECT c.class_id, c.student_id, s.name AS student_name, c.reservation_time
            FROM class c
            JOIN student s ON c.student_id = s.student_id
            LEFT JOIN matching m ON c.class_id = m.class_id
            WHERE m.class_id IS NULL";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Class ID: " . $row["class_id"] . " - Student: " . $row["student_name"] . " - Requested Time: " . $row["reservation_time"] . "<br>";
            echo "<a href='process_matching.php?class_id=" . $row["class_id"] . "&action=accept'>Accept</a><br><br>";
        }
    } else {
        echo "No matching requests found.";
    }

    $conn->close();
    ?>
     <a href="index.php">Back to Home</a>
</body>
</html>
