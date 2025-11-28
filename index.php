<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "SELECT id, full_name, password FROM users WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">>
    <title>Municipality Incident Reporting - Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="login-page">  
    <div class="login-container">  
        <div class="login-card">
            <div class="app-header">
                <h1 class="app-title">Municipality Incident Reporting</h1>
                <p class="app-subtitle">Web-App</p>
                <div class="app-logo">
                    <img src="logowo.png" alt="">
                </div>
            </div>

            
            <h2 class="welcome-title">Welcome Back!</h2>
            <p class="login-subtitle">Please login to continue</p>
            
            <?php if (isset($error)): ?>
                <div class="error-message" style="color: red; margin-bottom: 15px;"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form class="login-form" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <div class="form-options">
                    <label class="checkbox-label">
                        <input type="checkbox" id="remember" name="remember">
                        <span class="checkmark"></span>
                        Remember Me
                    </label>
                        <a href="forgot_password.php" class="forgot-link">Forgot password?</a>

                </div>
                
                <button type="submit" class="login-btn">Login</button>
                
                <p class="signup-link">Don't have an account? <a href="signup.php">Sign Up</a></p>
            </form>
        </div>
    </div>
</body>
</html>