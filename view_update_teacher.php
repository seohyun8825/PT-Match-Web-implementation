<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View and Update Teacher Information</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>View and Update Teacher Information</h1>
    <?php
    session_start();
    if (!isset($_SESSION['teacher_id'])) {
        header('Location: login.php');
        exit();
    }

    include 'config.php';

    $teacher_id = $_SESSION['teacher_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle update
        $name = $_POST['name'];
        $birth_date = $_POST['birth_date'];
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];

        $update_fields = [];

        if (!empty($name)) {
            $update_fields[] = "name='$name'";
        }
        if (!empty($birth_date)) {
            $age = date_diff(date_create($birth_date), date_create('today'))->y;
            $update_fields[] = "birth_date='$birth_date', age=$age";
        }
        if (!empty($phone)) {
            $update_fields[] = "phone='$phone'";
        }
        if (!empty($gender)) {
            $update_fields[] = "gender='$gender'";
        }

        if (!empty($update_fields)) {
            $update_query = "UPDATE teacher SET " . implode(', ', $update_fields) . " WHERE teacher_id='$teacher_id'";
            if ($conn->query($update_query) === TRUE) {
                echo "Teacher information updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "No fields to update";
        }
    }

    // Fetch teacher information
    $sql = "SELECT * FROM teacher WHERE teacher_id='$teacher_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No results found";
        exit();
    }

    $conn->close();
    ?>
    <a href="index.php">Back to Home</a>
    <form action="view_update_teacher.php" method="POST">
        <label for="teacher_id">Teacher ID:</label><br>
        <input type="text" id="teacher_id" name="teacher_id" value="<?php echo $row['teacher_id']; ?>" readonly><br>
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>"><br>
        <label for="birth_date">Birth Date:</label><br>
        <input type="date" id="birth_date" name="birth_date" value="<?php echo $row['birth_date']; ?>"><br>
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>"><br>
        <label for="gender">Gender:</label><br>
        <input type="text" id="gender" name="gender" value="<?php echo $row['gender']; ?>"><br><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>
