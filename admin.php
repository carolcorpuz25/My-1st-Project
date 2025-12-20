<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to database
$conn = new mysqli("localhost","root","","bakebite_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query all messages
$result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Messages</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .msg { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>

<h2>Received Messages</h2>

<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="msg">';
        echo '<strong>Name:</strong> ' . htmlspecialchars($row['name']) . '<br>';
        echo '<strong>Email:</strong> ' . htmlspecialchars($row['email']) . '<br>';
        echo '<strong>Message:</strong><br>' . nl2br(htmlspecialchars($row['message'])) . '<br>';
        echo '<small>Sent on: ' . $row['created_at'] . '</small>';
        echo '</div>';
    }
} else {
    echo "<p>No messages found.</p>";
}
?>

</body>
</html>
