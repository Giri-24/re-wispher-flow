<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Hospital Management System</title>
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
        }

        /* Navbar */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-name {
            color: #666;
            font-weight: 500;
        }

        .logout-btn {
            background: #ff4757;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #ff3838;
            transform: translateY(-2px);
        }

        /* Main Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Welcome Section */
        .welcome-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-section h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .welcome-section p {
            color: #666;
            font-size: 1rem;
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .stat-title {
            color: #666;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .stat-link {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-block;
            margin-top: 0.5rem;
        }

        .stat-link:hover {
            text-decoration: underline;
        }

        /* Quick Actions */
        .actions-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .actions-section h3 {
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .action-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 15px;
            padding: 1.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .action-icon {
            font-size: 2.5rem;
        }

        .action-content {
            flex: 1;
        }

        .action-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.3rem;
        }

        .action-description {
            font-size: 0.85rem;
            color: #666;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .navbar {
                padding: 1rem;
            }
            
            .welcome-section h2 {
                font-size: 1.5rem;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .actions-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Animation for cards */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card, .action-card {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .action-card:nth-child(1) { animation-delay: 0.3s; }
        .action-card:nth-child(2) { animation-delay: 0.4s; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            🏥 Hospital Management System
        </div>
        <div class="admin-info">
            <span class="admin-name">👋 Welcome, Admin</span>
            <a href="logout.php" class="logout-btn">🚪 Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-section">
            <h2>Admin Dashboard</h2>
            <p>Manage your hospital operations efficiently from one central location.</p>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">👨‍⚕️</div>
                <div class="stat-title">Total Doctors</div>
                <div class="stat-number" id="doctorCount">--</div>
                <a href="add_doctor.php" class="stat-link">Manage Doctors →</a>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-title">Total Patients</div>
                <div class="stat-number" id="patientCount">--</div>
                <a href="view_patients.php" class="stat-link">View All Patients →</a>
            </div>
        </div>

        <div class="actions-section">
            <h3>📋 Quick Actions</h3>
            <div class="actions-grid">
                <a href="add_doctor.php" class="action-card">
                    <div class="action-icon">➕</div>
                    <div class="action-content">
                        <div class="action-title">Add New Doctor</div>
                        <div class="action-description">Register a new doctor to the system</div>
                    </div>
                </a>
                
                <a href="view_patients.php" class="action-card">
                    <div class="action-icon">📋</div>
                    <div class="action-content">
                        <div class="action-title">View Patients</div>
                        <div class="action-description">Manage and view all registered patients</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Optional: Fetch actual counts from database
        // This would require additional AJAX endpoints
        // For now, you can uncomment and implement if needed
        /*
        async function fetchStats() {
            try {
                const doctorResponse = await fetch('get_doctor_count.php');
                const doctorData = await doctorResponse.json();
                document.getElementById('doctorCount').textContent = doctorData.count;
                
                const patientResponse = await fetch('get_patient_count.php');
                const patientData = await patientResponse.json();
                document.getElementById('patientCount').textContent = patientData.count;
            } catch (error) {
                console.error('Error fetching stats:', error);
                document.getElementById('doctorCount').textContent = 'N/A';
                document.getElementById('patientCount').textContent = 'N/A';
            }
        }
        
        // Fetch stats on page load
        fetchStats();
        */
        
        // Display placeholder counts (remove this when implementing real counts)
        document.getElementById('doctorCount').textContent = '0';
        document.getElementById('patientCount').textContent = '0';
    </script>
</body>
</html>