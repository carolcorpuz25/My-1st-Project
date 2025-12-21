<?php
$conn = new mysqli("localhost", "root", "", "bakebite_db");

if(isset($_POST['submit'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);
    
    $query = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";
    $conn->query($query);
    
    echo "Message sent successfully!";
}
?>