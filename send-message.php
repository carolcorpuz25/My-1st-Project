<?php
// Ipakita errors kung may problema
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect sa database
$conn = new mysqli("localhost","root","","bakebite_db");
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Prepare statement
    $stmt = $conn->prepare(
        "INSERT INTO messages (name, email, message, created_at) VALUES (?, ?, ?, NOW())"
    );
    if(!$stmt){
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $email, $message);

    // Execute statement
    if($stmt->execute()){
        header("Location: thank-you.html");
        exit;
    } else {
        echo "Error saving message: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
