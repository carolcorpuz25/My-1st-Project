<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>

<h1>Welcome, Admin!</h1>

<p>Successful login 🎉</p>

<a href="logout.php">Logout</a>

</body>
</html>
