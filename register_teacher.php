<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Teacher</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Register New Teacher</h1>
    <form action="register_teacher.php" method="POST">
        <label for="teacher_id">Teacher ID:</label><br>
        <input type="text" id="teacher_id" name="teacher_id" required><br>
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="birth_date">Birth Date:</label><br>
        <input type="date" id="birth_date" name="birth_date" required><br>
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" required><br>
        <label for="gender">Gender:</label><br>
        <input type="text" id="gender" name="gender" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'config.php';

        $teacher_id = $_POST['teacher_id'];
        $name = $_POST['name'];
        $birth_date = $_POST['birth_date'];
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $age = date_diff(date_create($birth_date), date_create('today'))->y;

        $sql = "INSERT INTO teacher (teacher_id, name, birth_date, age, phone, gender, password) VALUES ('$teacher_id', '$name', '$birth_date', $age, '$phone', '$gender', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "New teacher registered successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>
</html>
