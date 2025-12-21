<?php
session_start();

// Check if admin is logged in
 if(!isset($_SESSION['admin_id'])) {
   header("Location: login-form.php");
   exit();
}

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to database
$conn = new mysqli("localhost","root","","bakebite_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle logout
if(isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    
    // Redirect using JavaScript as backup
    echo "<script>window.location.href='login-form.php';</script>";
    exit();
}

// Get statistics
$total_messages = $conn->query("SELECT COUNT(*) as count FROM messages")->fetch_assoc()['count'];
$today_messages = $conn->query("SELECT COUNT(*) as count FROM messages WHERE DATE(created_at) = CURDATE()")->fetch_assoc()['count'];

// Query all messages
$result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BakeBite</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
:root {
    --cream: #F3ECE6;   
    --pink:  #E3A6B1;  
    --peach: #E8B892;  
    --brown: #4A3223;  
    --choco: #7A4E32;  
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: var(--cream);
    min-height: 100vh;
    padding: 20px;
}

.container {
    max-width: 1200px;
    margin: auto;
}

/* HEADER */
.header {
    background: linear-gradient(135deg, var(--pink), var(--peach));
    padding: 25px 30px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h1 {
    color: var(--brown);
    font-size: 30px;
    font-weight: 700;
}

.logout-btn {
    background: var(--brown);
    color: #fff;
    padding: 12px 26px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}

.logout-btn:hover {
    background: var(--choco);
}

/* STATS */
.stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px,1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: #fff;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 20px;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--peach);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--brown);
    font-size: 24px;
}

.stat-info h3 {
    color: #888;
    font-size: 14px;
}

.stat-info p {
    color: var(--brown);
    font-size: 34px;
    font-weight: 700;
}

/* MESSAGES */
.messages-section {
    background: #fff;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.section-title {
    color: var(--brown);
    font-size: 24px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.message-card {
    background: var(--choco);
    border-left: 6px solid var(--peach);
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 15px;
    transition: 0.3s;
}

.message-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.message-info {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.message-info-item {
    color: var(--pink);
    font-size: 14px;
    display: flex;
    gap: 8px;
    align-items: center;
}

.message-text {
    background: #fff;
    padding: 15px;
    border-radius: 12px;
    margin: 15px 0;
    color: #333;
}

.message-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.message-date {
    font-size: 13px;
    color: #999;
}

.delete-btn {
    background: var(--pink);
    color: var(--brown);
    padding: 8px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: 0.3s;
}

.delete-btn:hover {
    background: var(--peach);
}

/* EMPTY */
.no-messages {
    text-align: center;
    padding: 60px;
    color: #aaa;
}

.no-messages i {
    font-size: 60px;
    margin-bottom: 15px;
}

/* MOBILE */
@media(max-width:768px){
    .header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
}
</style>

</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-cake-candles"></i>BakeBite Admin</h1>
            <a href="?logout=true" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Messages</h3>
                    <p><?php echo $total_messages; ?></p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon pink">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-info">
                    <h3>Today's Messages</h3>
                    <p><?php echo $today_messages; ?></p>
                </div>
            </div>
        </div>

        <div class="messages-section">
            <h2 class="section-title">
                <i class="fas fa-inbox"></i>
                Received Messages
            </h2>

            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="message-card">';
                    
                    echo '<div class="message-info">';
                    echo '<div class="message-info-item">';
                    echo '<i class="fas fa-user"></i>';
                    echo '<strong>' . htmlspecialchars($row['name']) . '</strong>';
                    echo '</div>';
                    echo '<div class="message-info-item">';
                    echo '<i class="fas fa-envelope"></i>';
                    echo htmlspecialchars($row['email']);
                    echo '</div>';
                    echo '</div>';
                    
                    echo '<div class="message-text">';
                    echo nl2br(htmlspecialchars($row['message']));
                    echo '</div>';
                    
                    echo '<div class="message-footer">';
                    echo '<span class="message-date">';
                    echo '<i class="far fa-clock"></i> ' . date('F j, Y - g:i A', strtotime($row['created_at']));
                    echo '</span>';
                    echo '<a href="?delete=' . $row['id'] . '" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this message?\')">';
                    echo '<i class="fas fa-trash"></i> Delete';
                    echo '</a>';
                    echo '</div>';
                    
                    echo '</div>';
                }
            } else {
                echo '<div class="no-messages">';
                echo '<i class="fas fa-inbox"></i>';
                echo '<p>No messages yet. Check back later!</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
