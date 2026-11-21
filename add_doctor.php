<?php include("config/db.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 500px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
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

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.9;
            font-size: 14px;
        }

        form {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px 15px;
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

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .message {
            margin: 20px 30px 30px 30px;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .icon {
            display: inline-block;
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            .container {
                margin: 20px;
            }
            
            form {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏥 Add New Doctor</h1>
            <p>Fill in the details below to register a new doctor</p>
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label>👨‍⚕️ Full Name</label>
                <input type="text" name="name" placeholder="Enter doctor's full name" required>
            </div>
            
            <div class="form-group">
                <label>🔬 Specialization</label>
                <input type="text" name="spec" placeholder="e.g., Cardiologist, Dermatologist" required>
            </div>
            
            <div class="form-group">
                <label>📧 Email Address</label>
                <input type="email" name="email" placeholder="doctor@example.com" required>
            </div>
            
            <div class="form-group">
                <label>🔒 Password</label>
                <input type="password" name="pass" placeholder="Create a secure password" required>
            </div>
            
            <button name="add">➕ Add Doctor</button>
        </form>

        <?php
        if(isset($_POST['add'])){
            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            
            $conn->query("INSERT INTO doctors(name,specialization,email,password)
            VALUES ('$_POST[name]','$_POST[spec]','$_POST[email]','$pass')");
            
            echo '<div class="message success">✓ Doctor Added Successfully!</div>';
        }
        ?>
    </div>
</body>
</html>