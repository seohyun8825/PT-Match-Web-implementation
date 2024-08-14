<?php
$servername = "localhost";
$username = "db2020230057";
$password = "smart8825@naver.com";
$dbname = "db2020230057";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
