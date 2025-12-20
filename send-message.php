<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect sa database
$conn = new mysqli("localhost", "root", "", "bakebite_db");
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Kunin ang input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Start transaction para sabay-sabay ma-insert
    $conn->begin_transaction();

    try {
        // Insert sa table 'name'
        $stmt1 = $conn->prepare("INSERT INTO name (full_name) VALUES (?)");
        $stmt1->bind_param("s", $name);
        $stmt1->execute();
        $stmt1->close();

        // Insert sa table 'email'
        $stmt2 = $conn->prepare("INSERT INTO email (email_address) VALUES (?)");
        $stmt2->bind_param("s", $email);
        $stmt2->execute();
        $stmt2->close();

        // Insert sa table 'message'
        $stmt3 = $conn->prepare("INSERT INTO message (message_text) VALUES (?)");
        $stmt3->bind_param("s", $message);
        $stmt3->execute();
        $stmt3->close();

        // I-commit kung successful lahat
        $conn->commit();
        
        // Redirect sa thank-you page
        header("Location: thank-you.html");
        exit();

    } catch (Exception $e) {
        // I-rollback kung may error
        $conn->rollback();
        echo "DB ERROR: " . $e->getMessage();
    }
}
$conn->close();
?>