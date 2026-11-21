<?php include("config/db.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration - Hospital Management System</title>
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

        /* Registration Container */
        .register-container {
            max-width: 500px;
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
        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .register-header .icon {
            font-size: 4rem;
            margin-bottom: 15px;
        }

        .register-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .register-header p {
            opacity: 0.9;
            font-size: 14px;
        }

        /* Form */
        .register-form {
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

        /* Register Button */
        .register-btn {
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

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .register-btn:active {
            transform: translateY(0);
        }

        /* Message Styles */
        .message {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.5s ease-out;
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        /* Responsive */
        @media (max-width: 768px) {
            .register-container {
                margin: 60px 0 20px;
            }
            
            .register-header {
                padding: 30px 20px;
            }
            
            .register-header h1 {
                font-size: 24px;
            }
            
            .register-form {
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

    <div class="register-container">
        <div class="register-header">
            <div class="icon">📝</div>
            <h1>Patient Registration</h1>
            <p>Create your account to access healthcare services</p>
        </div>
        
        <div class="register-form">
            <?php
            // EXACT ORIGINAL LOGIC - NO CHANGES
           // EXACT ORIGINAL CODE - NO CHANGES
if(isset($_POST['reg'])){
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $conn->query("INSERT INTO patients(name,email,password)
    VALUES ('$_POST[name]','$_POST[email]','$pass')");
    
    echo '<div class="message success">✓ Registered Successfully!</div>';
}
            ?>
            
            <form method="POST" id="registerForm">
                <div class="form-group">
                    <label>👤 Full Name</label>
                    <div class="input-group">
                        <span class="input-icon">👨‍⚕️</span>
                        <input type="text" name="name" id="name" placeholder="Enter your full name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>📧 Email Address</label>
                    <div class="input-group">
                        <span class="input-icon">✉️</span>
                        <input type="email" name="email" id="email" placeholder="Enter your email address" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>🔒 Password</label>
                    <div class="input-group">
                        <span class="input-icon">🔑</span>
                        <input type="password" name="password" id="password" placeholder="Create a password" required>
                    </div>
                </div>

                <button type="submit" name="reg" class="register-btn">
                    <span>✓</span> Register
                </button>
            </form>
            
            <div class="additional-links">
                <a href="login.php">Already have an account? Login here</a>
            </div>
        </div>
    </div>

    <script>
        // Simple form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if(!name || !email || !password) {
                e.preventDefault();
                alert('Please fill in all fields');
                return false;
            }
        });
    </script>
</body>
</html>