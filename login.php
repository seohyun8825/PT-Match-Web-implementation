<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="POST">
        <label for="teacher_id">Teacher ID:</label><br>
        <input type="text" id="teacher_id" name="teacher_id" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <p>Don't have an account? <a href="register_teacher.php">Register here</a></p>

    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'config.php';

        $teacher_id = $_POST['teacher_id'];
        $password = $_POST['password'];

        // Check if the teacher ID and password are correct
        $sql = "SELECT * FROM teacher WHERE teacher_id='$teacher_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['teacher_id'] = $teacher_id;
                header('Location: index.php');
            } else {
                echo "Invalid teacher ID or password";
            }
        } else {
            echo "Invalid teacher ID or password";
        }

        $conn->close();
    }
    ?>
</body>
</html>
