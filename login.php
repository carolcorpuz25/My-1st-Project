<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Bake Bite</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* LOGIN PAGE STYLING */
        body {
            background: var(--light-pink-color);
            font-family: 'Poppins', sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: 120px auto;
            padding: 40px;
            background: #fff;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .login-container h2 {
            font-size: 2rem;
            margin-bottom: 25px;
            color: var(--dark-color, #333);
        }

        .login-container form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .login-container .form-input {
            padding: 12px 15px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 10px;
            outline: none;
            transition: 0.3s;
        }

        .login-container .form-input:focus {
            border-color: var(--primary-color, #ff6b6b);
            box-shadow: 0 0 5px rgba(255,107,107,0.5);
        }

        .login-container .submit-button {
            padding: 12px 20px;
            font-size: 1rem;
            background: var(--primary-color, #ff6b6b);
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-container .submit-button:hover {
            background: brown;
        }

        .login-container p {
            margin-top: 15px;
            font-size: 0.9rem;
        }

        .login-container p a {
            color: var(--primary-color, #ff6b6b);
            text-decoration: none;
        }

        .login-container p a:hover {
            text-decoration: underline;
        }

        @media screen and (max-width: 500px) {
            .login-container {
                margin: 80px 20px;
                padding: 30px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>

        <form action="login_process.php" method="POST">
            <input type="email" name="email" placeholder="Email" class="form-input" required>
            <input type="password" name="password" placeholder="Password" class="form-input" required>

            <button type="submit" class="submit-button">Login</button>
        </form>

        <p>
            <a href="index.html">Back to Home</a>
        </p>
    </div>

</body>
</html>
