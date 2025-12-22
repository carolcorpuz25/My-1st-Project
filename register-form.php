<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BakeBite</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #835f42;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 450px;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo h1 {
            color: #667eea;
            font-size: 36px;
            margin-bottom: 10px;
        }
        
        .logo p {
            color: #999;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .submit-button {
            width: 100%;
            padding: 15px;
            background: #835f42;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .link a {
            color: #667eea;
            text-decoration: none;
        }

        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }

        .success-message {
            background: #e0ffe0;
            color: #2d862d;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
}

    </style>
</head>
<body>

<div class="login-container">
    <div class="logo">
        <h1>🍰 BakeBite</h1>
        <p>Admin Registration</p>
    </div>

    <?php if(isset($_GET['error'])): ?>
    <div class="error-message">
        <?= htmlspecialchars($_GET['error']) ?>
    </div>
<?php endif; ?>

<?php if(isset($_GET['success'])): ?>
    <div class="success-message">
        <?= htmlspecialchars($_GET['success']) ?>
    </div>
<?php endif; ?> 



    <form action="register_process.php" method="POST">
        <div class="form-group">

        <div class="form-group">
           <input type="text" name="name" placeholder="Full Name" 
           class="form-input"
           value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>" required>
        </div>

        <div class="form-group">
           <input type="email" name="email" placeholder="Email" 
           class="form-input"
           value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>" required>
        </div>

        <div class="form-group">
            <input type="password" name="password" placeholder="Password" class="form-input" required>
        </div>

        <div class="form-group">
            <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-input" required>
        </div>

        <button type="submit" class="submit-button">Register</button>
    </form>

    <div class="link">
        Already have an account? <a href="login-form.php">Login</a>
    </div>
</div>

</body>
</html>
