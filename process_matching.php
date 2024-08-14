<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Matching</title>
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

    if (isset($_GET['class_id']) && isset($_GET['action'])) {
        include 'config.php';

        $class_id = $_GET['class_id'];
        $action = $_GET['action'];

        if ($action == 'accept') {
            // 매칭 요청 수락 처리
            $sql = "SELECT reservation_time FROM class WHERE class_id='$class_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $reserved_time = $row["reservation_time"];

                // Check if the class_id is already in the matching table
                $check_sql = "SELECT * FROM matching WHERE class_id='$class_id'";
                $check_result = $conn->query($check_sql);

                if ($check_result->num_rows == 0) {
                    // matching 테이블에 데이터 삽입
                    $sql = "INSERT INTO matching (class_id, teacher_id, status, reserved_time) VALUES ('$class_id', '$teacher_id', 'accepted', '$reserved_time')";
                    if ($conn->query($sql) === TRUE) {
                        // Get the last inserted matching_id
                        $matching_id = $conn->insert_id;

                        // schedule 테이블에 데이터 삽입
                        $sql = "INSERT INTO schedule (matching_id, teacher_id, reservation_time, status) VALUES ('$matching_id', '$teacher_id', '$reserved_time', 'pending')";
                        $conn->query($sql);
                        echo "Matching request accepted successfully.";
                    } else {
                        echo "Error updating matching request: " . $conn->error;
                    }
                } else {
                    echo "Matching request already accepted.";
                }
            }
        }

        $conn->close();
    }
    ?>

    <a href="matching_list.php">Back to Matching Requests</a>
</body>
</html>
