<?php
session_start();
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit;
    }

    // $hashed_pass = md5($password);

    // Query to check user
    $sql = "SELECT * FROM users WHERE (email = '$username' OR name = '$username') AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] === 'Admin') {
            header("Location: ../Admin/admdashboard.php");
        } elseif ($user['role'] === 'Instructor') {
            header("Location: ../Instructor/insdashboard.php");
        } elseif ($user['role'] === 'Student') {
            header("Location: ../Student/stddashboard.php");
        }
        exit;
    } else {
        echo "<script>alert('Invalid username or password!'); window.history.back();</script>";
        exit;
    }
}
?>
