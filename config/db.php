<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "lms_project";
$port = 3307; // REMOVE IF YOUR PORT IS NOT 3307

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
