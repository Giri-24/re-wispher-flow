<?php
session_start();
include("config/db.php");

$res = $conn->query("SELECT * FROM doctors");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - Hospital Management System</title>
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
            position: relative;
        }

        /* Back Button */
        .back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background: white;
            color: #667eea;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            z-index: 100;
        }

        .back-btn:hover {
            transform: translateX(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        /* Main Container */
        .container {
            max-width: 600px;
            margin: 50px auto;
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

        /* Header */
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

        /* Form */
        form {
            padding: 30px;
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

        select, input[type="date"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
            background: white;
        }

        select:focus, input[type="date"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        select {
            cursor: pointer;
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="%23666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>');
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
        }

        input[type="date"] {
            cursor: pointer;
        }

        /* Date Restrictions */
        input[type="date"] {
            min-date: today;
        }

        /* Book Button */
        .book-btn {
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
        }

        .book-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .book-btn:active {
            transform: translateY(0);
        }

        /* Message */
        .message {
            margin: 20px 30px 30px 30px;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            animation: fadeIn 0.5s ease-out;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
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

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        /* Doctor Info Card */
        .doctor-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }

        .doctor-info p {
            margin: 5px 0;
            color: #666;
            font-size: 13px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .container {
                margin: 60px auto 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            form {
                padding: 20px;
            }
            
            .back-btn {
                top: 10px;
                left: 10px;
                padding: 8px 15px;
                font-size: 14px;
            }
        }

        /* Custom Calendar Icon */
        input[type="date"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
            padding: 5px;
            border-radius: 5px;
        }

        input[type="date"]::-webkit-calendar-picker-indicator:hover {
            background: #e0e0e0;
        }
    </style>
</head>
<body>
    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>

    <div class="container">
        <div class="header">
            <h1>📅 Book an Appointment</h1>
            <p>Schedule your visit with our expert doctors</p>
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label>👨‍⚕️ Select Doctor</label>
                <select name="doc" required>
                    <option value="" disabled selected>-- Choose a doctor --</option>
                    <?php while($row=$res->fetch_assoc()){ ?>
                    <option value="<?= $row['id'] ?>">
                        Dr. <?= $row['name'] ?> (<?= $row['specialization'] ?>)
                    </option>
                    <?php } ?>
                </select>
                <div class="doctor-info" style="margin-top: 10px;">
                    <p>💡 <strong>Tip:</strong> Choose a doctor based on your medical needs</p>
                </div>
            </div>

            <div class="form-group">
                <label>📆 Select Date</label>
                <input type="date" name="date" required min="<?= date('Y-m-d') ?>">
                <div class="doctor-info" style="margin-top: 10px;">
                    <p>⏰ <strong>Note:</strong> Appointments are available from tomorrow onwards</p>
                </div>
            </div>

            <button type="submit" name="book" class="book-btn">
                <span>✓</span> Confirm Appointment
            </button>
        </form>

        <?php
        if(isset($_POST['book'])){
            $conn->query("INSERT INTO appointments(patient_id,doctor_id,date,status)
            VALUES ('$_SESSION[pid]','$_POST[doc]','$_POST[date]','Pending')");
            
            echo '<div class="message success">✓ Appointment Booked Successfully! We will contact you soon.</div>';
        }
        ?>
    </div>

    <script>
        // Set minimum date to today
        const dateInput = document.querySelector('input[type="date"]');
        if(dateInput) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
        }

        // Add form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const select = document.querySelector('select[name="doc"]');
            const date = document.querySelector('input[name="date"]');
            
            if(!select.value) {
                e.preventDefault();
                alert('Please select a doctor');
                return false;
            }
            
            if(!date.value) {
                e.preventDefault();
                alert('Please select an appointment date');
                return false;
            }
            
            // Check if selected date is not in the past
            const selectedDate = new Date(date.value);
            const today = new Date();
            today.setHours(0,0,0,0);
            
            if(selectedDate < today) {
                e.preventDefault();
                alert('Please select a future date');
                return false;
            }
        });
    </script>
</body>
</html>