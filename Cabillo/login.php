<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: Dashboard.php");
    exit();
}

$error = "";
$post_result = "";
$get_result = "";

// Process POST form (Login)
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
    $login_input = trim($_POST['login_input']);
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']);
    
    if (empty($login_input) || empty($password)) {
        $error = "All fields are required.";
    }
    elseif (strpos($login_input, '@') !== false && !filter_var($login_input, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
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
        
        $authenticated = false;
        $username = "";
        
        foreach ($users as $user) {
            if ($user['username'] === $login_input || $user['email'] === $login_input) {
                if (password_verify($password, $user['password'])) {
                    $authenticated = true;
                    $username = $user['username'];
                }
                break;
            }
        }
        
        if ($authenticated) {
            $_SESSION['username'] = $username;
            $_SESSION['login_time'] = date('Y-m-d H:i:s');
            
            if ($remember_me) {
                setcookie('remember_username', $username, time() + (30 * 24 * 60 * 60), '/');
                setcookie('remember_login', 'true', time() + (30 * 24 * 60 * 60), '/');
            }
            
            header("Location: Dashboard.php");
            exit();
        } else {
            $error = "Invalid username/email or password.";
        }
    }
    
    $post_result = "<h3>POST Data Received:</h3><pre>" . print_r($_POST, true) . "</pre>";
}

// Process GET form
if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET)) {
    $get_result = "<h3>GET Data Received:</h3><pre>" . print_r($_GET, true) . "</pre>";
}

$prefill_username = "";
if (isset($_COOKIE['remember_username'])) {
    $prefill_username = htmlspecialchars($_COOKIE['remember_username']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Library E-Resources System</title>
</head>
<body>
    <h2>Library E-Resources System - Login</h2>
    
    <?php if (isset($_COOKIE['remember_username'])): ?>
        <p>Welcome back! We remembered your username: <?php echo $prefill_username; ?></p>
    <?php endif; ?>
    
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    
    <!-- POST Form -->
    <h3>POST Method (Login)</h3>
    <form action="login.php" method="POST">
        <p>Username or Email: * <input type="text" name="login_input" value="<?php echo $prefill_username; ?>" required></p>
        <p>Password: * <input type="password" name="password" required></p>
        <p><input type="checkbox" name="remember_me" value="1" id="remember"> <label for="remember">Remember me (using cookies)</label></p>
        <p><input type="submit" value="Login"></p>
    </form>
    
    <!-- GET Form -->
    <h3>GET Method (Search)</h3>
    <form action="login.php" method="GET">
        <p>Search: <input type="text" name="search"></p>
        <p>Category: <input type="text" name="category"></p>
        <p><input type="submit" value="Search via GET"></p>
    </form>
    
    <?php echo $post_result; ?>
    <?php echo $get_result; ?>
    
    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
</body>
</html>

