<?php
$conn = new mysqli("localhost", "root", "", "bakebite_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirm_password'])) {

    $name = urlencode($_POST['name']);
    $email = urlencode($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 🔹 Check if passwords match
    if ($password !== $confirm_password) {
        header("Location: register-form.php?error=Passwords do not match&name=$name&email=$email");
        exit();
    }
}

// Check if email already exists
$check = $conn->prepare("SELECT id FROM admins WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check_result = $check->get_result();

if ($check_result->num_rows > 0) {
    header("Location: register-form.php?error=Account already exists&name=$name&email=$email");
    exit();
} 

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    $insert = $conn->prepare("INSERT INTO admins (name, email, password) VALUES (?, ?, ?)");
    $insert->bind_param("sss", $name, $email, $hashed_password);
    $insert->execute();

    // Success popup
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Account Created</title>
       <style>
body { font-family: Arial, sans-serif; background: rgba(0,0,0,0.3); display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
.popup {
    background: #fff0f0; /* light pink */
    color: #835f42; /* brown text */
    padding: 30px 40px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0,0,0,0.3);
    max-width: 400px;
    font-size: 18px;
}
.popup button {
    margin-top: 20px;
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 8px;
    background: #835f42; /* brown button */
    color: #fff;
    cursor: pointer;
    transition: 0.3s;
}
.popup button:hover { background: #5c3c2d; } /* darker brown on hover */
</style>
    </head>
    <body>
        <div class="popup">
            Account created successfully!<br>
            <button onclick="window.location.href=\'login-form.php\'">Go to Login</button>
        </div>
    </body>
    </html>
    ';
    exit();

} catch (mysqli_sql_exception $e) {
    echo "MySQL Error: " . $e->getMessage();
    exit();
}

?>
