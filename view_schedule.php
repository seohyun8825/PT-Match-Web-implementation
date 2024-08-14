<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Schedule</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['teacher_id'])) {
        header('Location: login.php');
        exit();
    }

    $teacher_id = $_SESSION['teacher_id'];

    include 'config.php';

    // 스케줄 목록 조회
    $sql = "SELECT s.matching_id, s.teacher_id, s.reservation_time, s.status, t.name AS teacher_name
            FROM schedule s
            JOIN teacher t ON s.teacher_id = t.teacher_id
            WHERE s.teacher_id='$teacher_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h1>Schedule for " . $_SESSION['teacher_id'] . "</h1>";
        echo "<table border='1'>
                <tr>
                    <th>Matching ID</th>
                    <th>Teacher Name</th>
                    <th>Reservation Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["matching_id"] . "</td>
                    <td>" . $row["teacher_name"] . "</td>
                    <td>" . $row["reservation_time"] . "</td>
                    <td>" . $row["status"] . "</td>
                    <td>";
            if ($row["status"] != 'done') {
                echo "<a href='update_schedule.php?matching_id=" . $row["matching_id"] . "&action=done'>Mark as Done</a> | ";
                echo "<a href='update_schedule.php?matching_id=" . $row["matching_id"] . "&action=cancel'>Cancel</a>";
            }
            echo "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No schedules found.";
    }

    $conn->close();
    ?>
    <a href="index.php">Back to Home</a>
</body>
</html>
