<?php
session_start();
include("config/db.php");

if(isset($_POST['login'])){
    $res=$conn->query("SELECT * FROM doctors WHERE email='$_POST[email]'");
    $row=$res->fetch_assoc();
    
    if($row && password_verify($_POST['pass'],$row['password'])){
        $_SESSION['did']=$row['id'];
        $_SESSION['doctor_name']=$row['name']; // Store doctor name for display
        header("Location: doctor_dashboard.php");
        exit(); // Always add exit after header redirect
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Login - Hospital Management System</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
        }

        /* Back to Home Button */
        .home-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            z-index: 100;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .home-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-5px);
        }

        /* Login Container */
        .login-container {
            max-width: 450px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header */
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .login-header .icon {
            font-size: 4rem;
            margin-bottom: 15px;
        }

        .login-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .login-header p {
            opacity: 0.9;
            font-size: 14px;
        }

        /* Form */
        .login-form {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        label i {
            margin-right: 8px;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            color: #999;
            font-size: 18px;
        }

        input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        input::placeholder {
            color: #bbb;
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 15px;
            cursor: pointer;
            color: #999;
            font-size: 18px;
            user-select: none;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        /* Login Button */
        .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        /* Error Message */
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.5s ease-in-out;
            border-left: 4px solid #dc3545;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .error-message i {
            font-size: 20px;
        }

        /* Additional Links */
        .additional-links {
            margin-top: 25px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .additional-links a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .additional-links a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* Demo Credentials */
        .demo-credentials {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            border: 1px solid #e0e0e0;
        }

        .demo-credentials p {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .demo-credentials .credential {
            font-family: monospace;
            font-size: 11px;
            color: #333;
            background: white;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
            margin: 3px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                margin: 60px 0 20px;
            }
            
            .login-header {
                padding: 30px 20px;
            }
            
            .login-header h1 {
                font-size: 24px;
            }
            
            .login-form {
                padding: 30px 20px;
            }
            
            .home-btn {
                top: 10px;
                left: 10px;
                padding: 8px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <a href="index.php" class="home-btn">
        ← Back to Home
    </a>

    <div class="login-container">
        <div class="login-header">
            <div class="icon">👨‍⚕️</div>
            <h1>Doctor Login</h1>
            <p>Access your professional dashboard</p>
        </div>
        
        <div class="login-form">
            <?php if(isset($_POST['login']) && !$row): ?>
            <div class="error-message">
                <i>⚠️</i>
                <span>Invalid email or password. Please try again.</span>
            </div>
            <?php endif; ?>
            
            <form method="POST" id="loginForm">
                <div class="form-group">
                    <label>📧 Email Address</label>
                    <div class="input-group">
                        <span class="input-icon">✉️</span>
                        <input type="email" name="email" placeholder="doctor@hospital.com" required autocomplete="email">
                    </div>
                </div>

                <div class="form-group">
                    <label>🔒 Password</label>
                    <div class="input-group">
                        <span class="input-icon">🔑</span>
                        <input type="password" name="pass" id="password" placeholder="Enter your password" required>
                        <span class="password-toggle" onclick="togglePassword()">👁️</span>
                    </div>
                </div>

                <button type="submit" name="login" class="login-btn">
                    <span>→</span> Login to Dashboard
                </button>
            </form>
            
            <div class="additional-links">
                <a href="forgot_password.php">Forgot Password?</a>
                <span style="color: #ddd; margin: 0 10px;">|</span>
                <a href="patient_login.php">Patient Login</a>
                <span style="color: #ddd; margin: 0 10px;">|</span>
                <a href="admin_login.php">Admin Login</a>
            </div>
            
            <div class="demo-credentials">
                <p>📋 Demo Credentials (for testing):</p>
                <span class="credential">Email: doctor@hospital.com</span>
                <span class="credential">Password: doctor123</span>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = '👁️';
            }
        }
        
        // Add client-side validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.querySelector('input[name="email"]').value;
            const password = document.querySelector('input[name="pass"]').value;
            
            if (!email || !password) {
                e.preventDefault();
                alert('Please enter both email and password');
                return false;
            }
            
            if (!email.includes('@')) {
                e.preventDefault();
                alert('Please enter a valid email address');
                return false;
            }
        });
        
        // Optional: Add enter key support
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const form = document.getElementById('loginForm');
                if (form) {
                    form.submit();
                }
            }
        });
    </script>
</body>
</html>