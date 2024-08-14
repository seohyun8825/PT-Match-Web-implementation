<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Registration System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['teacher_id'])) {
        header('Location: login.php');
        exit();
    }
    ?>
    <h1>PT Registration System</h1>
    <a href="view_update_teacher.php">View and Update Teacher Information</a> <!-- New Link -->
    <a href="delete_teacher.php">Delete Teacher</a>
    <a href="matching_list.php">View Matching Requests</a>
    <a href="view_schedule.php">View Schedule</a>
    <a href="logout.php">Logout</a>
</body>
</html>
