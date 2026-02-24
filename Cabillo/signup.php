<?php
session_start();


if (isset($_SESSION['username'])) {
    header("Location: Dashboard.php");
    exit();
}

$error = "";
$success = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    }
    
    elseif (strlen($username) < 3 || strlen($username) > 20) {
        $error = "Username must be between 3 and 20 characters.";
    }
    
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    }
 
    elseif (strlen($password) < 6 || strlen($password) > 20) {
        $error = "Password must be between 6 and 20 characters.";
    }
    
    elseif ($password !== $confirm_password) {
        $error = "Password and confirm password do not match.";
    }
    else {
        $users_file = 'users.json';
        if (file_exists($users_file)) {
            $users = json_decode(file_get_contents($users_file), true);
            if ($users === null) {
                $users = [];
            }
        } else {
            $users = [];
        }
        
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                $error = "Username already exists.";
                break;
            }
            if ($user['email'] === $email) {
                $error = "Email already registered.";
                break;
            }
        }
        
        if (empty($error)) {
            $new_user = [
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $users[] = $new_user;
            file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));
            $success = "Registration successful! <a href='login.php'>Click here to login</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup - Library E-Resources System</title>
</head>
<body>
    <h2>Library E-Resources System - Sign Up</h2>
    
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    
    <?php if (!empty($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>
    
    <form action="signup.php" method="POST">
        <p>Username: * <input type="text" name="username" minlength="3" maxlength="20" required></p>
        <p>Email: * <input type="email" name="email" required></p>
        <p>Password: * <input type="password" name="password" minlength="6" maxlength="20" required></p>
        <p>Confirm Password: * <input type="password" name="confirm_password" minlength="6" maxlength="20" required></p>
        <p><input type="submit" value="Sign Up"></p>
    </form>
    
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>

