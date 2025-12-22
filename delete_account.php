<?php
session_start();

// Check if admin is logged in
if(!isset($_SESSION['admin_id'])){
    header("Location: login-form.php");
    exit();
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $conn = new mysqli("localhost","root","","bakebite_db");
    if($conn->connect_error){ die("Connection failed: " . $conn->connect_error); }

    // Optional: Prevent admin from deleting self
    if($id == $_SESSION['admin_id']){
        header("Location: admin.php?error=You cannot delete your own account");
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM admins WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: admin.php?success=Account deleted successfully");
    exit();
}
?>
