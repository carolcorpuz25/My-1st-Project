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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #667eea;
            font-size: 28px;
        }

        .header h1 i {
            margin-right: 10px;
        }

        .logout-btn {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.2s;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .stat-icon.purple {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-icon.pink {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-info h3 {
            color: #888;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .stat-info p {
            color: #333;
            font-size: 32px;
            font-weight: 700;
        }

        .messages-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .section-title {
            color: #333;
            font-size: 24px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .message-card {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .message-card:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .message-info {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .message-info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 14px;
        }

        .message-info-item i {
            color: #667eea;
        }

        .message-text {
            color: #333;
            line-height: 1.6;
            margin: 15px 0;
            padding: 15px;
            background: white;
            border-radius: 8px;
        }

        .message-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #e0e0e0;
        }

        .message-date {
            color: #999;
            font-size: 13px;
        }

        .delete-btn {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 8px 18px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: transform 0.2s;
            text-decoration: none;
        }

        .delete-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 3px 10px rgba(245, 87, 108, 0.4);
        }

        .no-messages {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .no-messages i {
            font-size: 64px;
            margin-bottom: 20px;
            color: #ddd;
        }

        .no-messages p {
            font-size: 18px;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            .stats {
                grid-template-columns: 1fr;
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
