<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Schedule</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['teacher_id'])) {
        header('Location: login.php');
        exit();
    }

    if (isset($_GET['matching_id']) && isset($_GET['action'])) {
        include 'config.php';

        $matching_id = $_GET['matching_id'];
        $action = $_GET['action'];

        if ($action == 'done') {
            $status = 'done';
            // 스케줄 상태 업데이트
            $sql = "UPDATE schedule SET status='$status' WHERE matching_id='$matching_id' AND teacher_id='{$_SESSION['teacher_id']}'";
            if ($conn->query($sql) === TRUE) {
                echo "Schedule status updated successfully to '$status'.";
            } else {
                echo "Error updating schedule status: " . $conn->error;
            }
        } elseif ($action == 'cancel') {
            // 스케줄 및 매칭 삭제
            $sql = "DELETE FROM schedule WHERE matching_id='$matching_id' AND teacher_id='{$_SESSION['teacher_id']}'";
            if ($conn->query($sql) === TRUE) {
                $sql = "DELETE FROM matching WHERE matching_id='$matching_id'";
                if ($conn->query($sql) === TRUE) {
                    echo "Schedule and matching request cancelled successfully.";
                } else {
                    echo "Error deleting matching request: " . $conn->error;
                }
            } else {
                echo "Error deleting schedule: " . $conn->error;
            }
        }

        $conn->close();
    }
    ?>

    <a href="view_schedule.php">Back to Schedule</a>
</body>
</html>
