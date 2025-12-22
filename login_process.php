<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "bakebite_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_POST['email'], $_POST['password'])) {
    header("Location: login-form.php?error=1");
    exit();
}

$email = trim($_POST['email']);
$password = $_POST['password'];

// Query admin by email
$stmt = $conn->prepare("SELECT id, email, password FROM admins WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    // email not found
    header("Location: login-form.php?error=1");
    exit();
}

$admin = $result->fetch_assoc();

// verify password
if (!password_verify($password, $admin['password'])) {
    header("Location: login-form.php?error=1");
    exit();
}

// SUCCESS LOGIN
$_SESSION['admin_id']    = $admin['id'];
$_SESSION['admin_email'] = $admin['email'];

header("Location: admin.php");
exit();
