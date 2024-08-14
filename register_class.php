<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Class</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Register New Class</h1>
    <form action="register_class.php" method="POST">
        <label for="student_id">Student ID:</label><br>
        <input type="text" id="student_id" name="student_id" required><br>
        <label for="teacher_id">Teacher ID:</label><br>
        <input type="text" id="teacher_id" name="teacher_id" required><br>
        <label for="request_time">Request PT Time:</label><br>
        <input type="datetime-local" id="request_time" name="request_time" required><br>
        <label for="reservation_time">Reservation Time:</label><br>
        <input type="datetime-local" id="reservation_time" name="reservation_time" required><br><br>
        <input type="submit" value="Register">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'config.php';

        $student_id = $_POST['student_id'];
        $teacher_id = $_POST['teacher_id'];
        $request_time = $_POST['request_time'];
        $reservation_time = $_POST['reservation_time'];

        // 새로운 Class 생성
        $sql = "INSERT INTO class (student_id, request_time) VALUES ('$student_id', '$request_time')";
        if ($conn->query($sql) === TRUE) {
            $class_id = $conn->insert_id;
            echo "New class registered successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // 새로운 Matching 생성
        $sql = "INSERT INTO matching (class_id, teacher_id, status) VALUES ('$class_id', '$teacher_id', 'pending')";
        if ($conn->query($sql) === TRUE) {
            $matching_id = $conn->insert_id;
            echo "New matching created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // 새로운 Schedule 생성
        $sql = "INSERT INTO schedule (teacher_id, reservation_time) VALUES ('$teacher_id', '$reservation_time')";
        if ($conn->query($sql) === TRUE) {
            echo "New schedule created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
    <a href="index.php">Back to Home</a>   
</body>
</html>
