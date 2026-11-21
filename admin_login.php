<?php
session_start();
include("config/db.php");

if(isset($_POST['login'])){
    $username = $_POST['user'];
    $password = $_POST['pass'];

    $res = $conn->query("SELECT * FROM admin WHERE username='$username'");
    $row = $res->fetch_assoc();

    // ✅ Simple password check (for now) - EXACT ORIGINAL LOGIC
    if($row && $password == $row['password']){
        $_SESSION['admin'] = 1;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "❌ Login Failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Hospital Management System</title>
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
            margin: 0 10px;
        }

        .additional-links a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* Demo Credentials */
        .demo-credentials {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
        }

        .demo-credentials p {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .demo-item {
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
            <div class="icon">👑</div>
            <h1>Admin Login</h1>
            <p>Access the administrative dashboard</p>
        </div>
        
        <div class="login-form">
            <?php
            // EXACT ORIGINAL LOGIC - Display error message exactly as original
            // COMPLETELY UNCHANGED - Same as your original
if(isset($_POST['login'])){
    $username = $_POST['user'];
    $password = $_POST['pass'];

    $res = $conn->query("SELECT * FROM admin WHERE username='$username'");
    $row = $res->fetch_assoc();

    if($row && $password == $row['password']){
        $_SESSION['admin'] = 1;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "❌ Login Failed!";
    }
}
            ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>👤 Username</label>
                    <div class="input-group">
                        <span class="input-icon">👨‍💼</span>
                        <input type="text" name="user" placeholder="Enter admin username" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label>🔒 Password</label>
                    <div class="input-group">
                        <span class="input-icon">🔑</span>
                        <input type="password" name="pass" placeholder="Enter admin password" required>
                    </div>
                </div>

                <button type="submit" name="login" class="login-btn">
                    <span>→</span> Login to Admin Panel
                </button>
            </form>
            
            <div class="additional-links">
                <a href="login.php">Patient Login</a>
                <a href="doctor_login.php">Doctor Login</a>
            </div>

            <div class="demo-credentials">
                <p>📋 Demo Credentials (for testing):</p>
                <div>
                    <span class="demo-item">Username: admin</span>
                    <span class="demo-item">Password: admin123</span>
                </div>
                <p style="font-size: 10px; margin-top: 8px; color: #888;">💡 Contact system administrator for credentials</p>
            </div>
        </div>
    </div>

    <script>
        // Simple form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const username = document.querySelector('input[name="user"]').value;
            const password = document.querySelector('input[name="pass"]').value;
            
            if(!username || !password) {
                e.preventDefault();
                alert('Please fill in both username and password fields');
                return false;
            }
        });
        
        // Auto-focus on username field
        document.querySelector('input[name="user"]').focus();
    </script>
</body>
</html>