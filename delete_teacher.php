<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Teacher</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Delete Teacher</h1>
    <?php
    session_start();
    if (!isset($_SESSION['teacher_id'])) {
        header('Location: login.php');
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'config.php';

        $teacher_id = $_SESSION['teacher_id'];

        // Delete teacher record
        $sql = "DELETE FROM teacher WHERE teacher_id='$teacher_id'";

        if ($conn->query($sql) === TRUE) {
            // If deletion is successful, redirect to login page
            session_destroy(); // Destroy session to log out the user
            header('Location: login.php');
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }

        $conn->close();
    } else {
        // Display confirmation form
        echo "<p>Are you sure you want to delete your account?</p>";
        echo "<form action='delete_teacher.php' method='POST'>";
        echo "<input type='submit' value='Delete'>";
        echo "</form>";
    }
    ?>
    <a href="index.php">Back to Home</a>
</body>
</html>
