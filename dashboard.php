<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard - Hospital Management System</title>
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
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo span {
            font-size: 1.8rem;
        }

        .patient-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .patient-name {
            color: #666;
            font-weight: 500;
            background: #f0f0f0;
            padding: 8px 15px;
            border-radius: 20px;
        }

        .logout-btn {
            background: #ff4757;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .logout-btn:hover {
            background: #ff3838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 71, 87, 0.3);
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
            text-align: center;
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
            text-align: center;
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

        .stat-status {
            color: #28a745;
            font-size: 0.85rem;
            font-weight: 500;
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
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .action-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 1.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            overflow: hidden;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .action-card:hover::before {
            left: 100%;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .action-icon {
            font-size: 2.5rem;
            background: rgba(255,255,255,0.2);
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .action-content {
            flex: 1;
        }

        .action-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
            margin-bottom: 0.3rem;
        }

        .action-description {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.9);
        }

        .arrow {
            color: white;
            font-size: 1.5rem;
            opacity: 0.7;
            transition: transform 0.3s ease;
        }

        .action-card:hover .arrow {
            transform: translateX(5px);
        }

        /* Recent Appointments */
        .recent-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .recent-section h3 {
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .appointment-list {
            overflow-x: auto;
        }

        .appointment-table {
            width: 100%;
            border-collapse: collapse;
        }

        .appointment-table th,
        .appointment-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .appointment-table th {
            background: #f8f9fa;
            color: #666;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .appointment-table td {
            color: #333;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state p {
            margin-top: 10px;
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
            
            .appointment-table th,
            .appointment-table td {
                padding: 8px;
                font-size: 0.85rem;
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
            <span>🏥</span>
            Hospital Management System
        </div>
        <div class="patient-info">
            <span class="patient-name">👋 Welcome, <?= isset($_SESSION['patient_name']) ? $_SESSION['patient_name'] : 'Patient' ?></span>
            <a href="logout.php" class="logout-btn">🚪 Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-section">
            <h2>Patient Dashboard</h2>
            <p>Manage your appointments and access medical reports from one place</p>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">📅</div>
                <div class="stat-title">Total Appointments</div>
                <div class="stat-number" id="totalAppointments">--</div>
                <div class="stat-status">All time</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">⏳</div>
                <div class="stat-title">Pending Appointments</div>
                <div class="stat-number" id="pendingAppointments">--</div>
                <div class="stat-status">Awaiting confirmation</div>
            </div>
        </div>

        <div class="actions-section">
            <h3>📋 Quick Actions</h3>
            <div class="actions-grid">
                <a href="book.php" class="action-card">
                    <div class="action-icon">📅</div>
                    <div class="action-content">
                        <div class="action-title">Book Appointment</div>
                        <div class="action-description">Schedule a new appointment with our doctors</div>
                    </div>
                    <div class="arrow">→</div>
                </a>
                
                <a href="reports.php" class="action-card">
                    <div class="action-icon">📊</div>
                    <div class="action-content">
                        <div class="action-title">View Reports</div>
                        <div class="action-description">Access your medical reports and history</div>
                    </div>
                    <div class="arrow">→</div>
                </a>

                <a href="dictation.php" class="action-card">
                    <div class="action-icon">🎙️</div>
                    <div class="action-content">
                        <div class="action-title">Voice Dictation</div>
                        <div class="action-description">Convert your speech into editable text</div>
                    </div>
                    <div class="arrow">→</div>
                </a>
            </div>
        </div>

        <div class="recent-section">
            <h3>📋 Recent Appointments</h3>
            <div class="appointment-list" id="appointmentList">
                <div class="empty-state">
                    <div style="font-size: 3rem;">📅</div>
                    <p>No recent appointments found</p>
                    <a href="book.php" style="color: #667eea; text-decoration: none; margin-top: 10px; display: inline-block;">Book your first appointment →</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fetch appointment statistics and recent appointments
        // This would typically come from an API endpoint
        // For demo purposes, we'll show placeholder data
        
        async function fetchPatientData() {
            try {
                // Example API call - replace with your actual endpoint
                // const response = await fetch('get_patient_appointments.php');
                // const data = await response.json();
                
                // Placeholder data (remove this when connecting to real API)
                const data = {
                    total: 0,
                    pending: 0,
                    appointments: []
                };
                
                // Update stats
                document.getElementById('totalAppointments').textContent = data.total;
                document.getElementById('pendingAppointments').textContent = data.pending;
                
                // Update appointments list
                if(data.appointments && data.appointments.length > 0) {
                    renderAppointments(data.appointments);
                }
            } catch (error) {
                console.error('Error fetching patient data:', error);
                document.getElementById('totalAppointments').textContent = '0';
                document.getElementById('pendingAppointments').textContent = '0';
            }
        }
        
        function renderAppointments(appointments) {
            const container = document.getElementById('appointmentList');
            const table = `
                <table class="appointment-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Doctor</th>
                            <th>Specialization</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${appointments.map(apt => `
                            <tr>
                                <td>${apt.date}</td>
                                <td>Dr. ${apt.doctor_name}</td>
                                <td>${apt.specialization}</td>
                                <td><span class="status-badge status-${apt.status.toLowerCase()}">${apt.status}</span></td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;
            container.innerHTML = table;
        }
        
        // Fetch data on page load
        fetchPatientData();
    </script>
</body>
</html>