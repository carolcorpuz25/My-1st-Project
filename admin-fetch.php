<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page - BakeBite Database</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5em;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        h2 {
            color: #667eea;
            margin-bottom: 15px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #999;
            font-style: italic;
        }
        .count {
            background: #764ba2;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 BakeBite Admin Dashboard</h1>

        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Connect sa database
        $conn = new mysqli("localhost", "root", "", "bakebite_db");
        if($conn->connect_error){
            die("<div class='section'><p style='color:red;'>Connection failed: " . $conn->connect_error . "</p></div>");
        }

        // Fetch NAMES
        echo "<div class='section'>";
        echo "<h2>👤 Names <span class='count'>";
        $count_name = $conn->query("SELECT COUNT(*) as total FROM name")->fetch_assoc()['total'];
        echo $count_name;
        echo "</span></h2>";
        
        $result_name = $conn->query("SELECT * FROM name ORDER BY created_at DESC");
        if($result_name->num_rows > 0){
            echo "<table>";
            echo "<tr><th>ID</th><th>Full Name</th><th>Created At</th></tr>";
            while($row = $result_name->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-data'>No names found in database.</p>";
        }
        echo "</div>";

        // Fetch EMAILS
        echo "<div class='section'>";
        echo "<h2>📧 Emails <span class='count'>";
        $count_email = $conn->query("SELECT COUNT(*) as total FROM email")->fetch_assoc()['total'];
        echo $count_email;
        echo "</span></h2>";
        
        $result_email = $conn->query("SELECT * FROM email ORDER BY created_at DESC");
        if($result_email->num_rows > 0){
            echo "<table>";
            echo "<tr><th>ID</th><th>Email Address</th><th>Created At</th></tr>";
            while($row = $result_email->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['email_address']) . "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-data'>No emails found in database.</p>";
        }
        echo "</div>";

        // Fetch MESSAGES
        echo "<div class='section'>";
        echo "<h2>💬 Messages <span class='count'>";
        $count_message = $conn->query("SELECT COUNT(*) as total FROM message")->fetch_assoc()['total'];
        echo $count_message;
        echo "</span></h2>";
        
        $result_message = $conn->query("SELECT * FROM message ORDER BY created_at DESC");
        if($result_message->num_rows > 0){
            echo "<table>";
            echo "<tr><th>ID</th><th>Message</th><th>Created At</th></tr>";
            while($row = $result_message->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['message_text']) . "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-data'>No messages found in database.</p>";
        }
        echo "</div>";

        $conn->close();
        ?>

    </div>
</body>
</html>