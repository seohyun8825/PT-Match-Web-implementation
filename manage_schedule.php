<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Schedule</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Manage Schedule</h1>
    <form action="manage_schedule.php" method="POST">
        <label for="teacher_id">Teacher ID:</label><br>
        <input type="text" id="teacher_id" name="teacher_id" required><br>
        <label for="new_reservation_time">New Reservation Time:</label><br>
        <input type="datetime-local" id="new_reservation_time" name="new_reservation_time"><br><br>
        <input type="submit" value="Update Schedule">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'config.php';

        $teacher_id = $_POST['teacher_id'];
        $new_reservation_time = $_POST['new_reservation_time'];

        if (!empty($new_reservation_time)) {
            // 스케줄 업데이트
            $sql = "UPDATE schedule SET reservation_time='$new_reservation_time' WHERE teacher_id='$teacher_id'";
            if ($conn->query($sql) === TRUE) {
                echo "Schedule updated successfully";
            } else {
                echo "Error updating schedule: " . $conn->error;
            }
        }

        // 현재 스케줄 조회
        $sql = "SELECT * FROM schedule WHERE teacher_id='$teacher_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "Schedule ID: " . $row["schedule_id"]. " - Reservation Time: " . $row["reservation_time"]. "<br>";
            }
        } else {
            echo "No schedule found for this teacher.";
        }

        $conn->close();
    }
    ?>
</body>
</html>
