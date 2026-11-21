<?php
session_start();
include("config/db.php");

$res=$conn->query("SELECT * FROM appointments WHERE doctor_id='$_SESSION[did]'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard - Appointments</title>
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

        .doctor-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .doctor-name {
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

        /* Header Section */
        .header-section {
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

        .header-section h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-section p {
            color: #666;
            font-size: 1rem;
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

        /* Appointments Table */
        .appointments-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .appointments-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .appointments-header h3 {
            color: #333;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-box {
            padding: 8px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 14px;
            width: 250px;
            transition: all 0.3s ease;
        }

        .search-box:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .table-container {
            overflow-x: auto;
        }

        .appointments-table {
            width: 100%;
            border-collapse: collapse;
        }

        .appointments-table th,
        .appointments-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .appointments-table th {
            background: #f8f9fa;
            color: #666;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .appointments-table td {
            color: #333;
        }

        .appointments-table tr:hover {
            background: #f8f9fa;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
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

        .status-completed {
            background: #cce5ff;
            color: #004085;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-view {
            background: #667eea;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-view:hover {
            background: #5a67d8;
            transform: translateY(-1px);
        }

        .btn-upload {
            background: #48bb78;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-upload:hover {
            background: #38a169;
            transform: translateY(-1px);
        }

        /* Upload Card */
        .upload-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .upload-section:hover {
            transform: translateY(-5px);
        }

        .upload-section h3 {
            color: white;
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        .upload-section p {
            color: rgba(255,255,255,0.9);
            margin-bottom: 1.5rem;
        }

        .upload-btn {
            background: white;
            color: #667eea;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-state p {
            margin-bottom: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .navbar {
                padding: 1rem;
            }
            
            .header-section h2 {
                font-size: 1.5rem;
            }
            
            .appointments-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .search-box {
                width: 100%;
            }
            
            .appointments-table th,
            .appointments-table td {
                padding: 10px;
                font-size: 0.85rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
        }

        /* Animation */
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

        .stat-card, .appointments-section, .upload-section {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        .stat-card { animation-delay: 0.1s; }
        .appointments-section { animation-delay: 0.2s; }
        .upload-section { animation-delay: 0.3s; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <span>🏥</span>
            Doctor Portal
        </div>
        <div class="doctor-info">
            <span class="doctor-name">👨‍⚕️ Dr. <?= isset($_SESSION['doctor_name']) ? $_SESSION['doctor_name'] : 'Doctor' ?></span>
            <a href="logout.php" class="logout-btn">🚪 Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="header-section">
            <h2>
                <span>📋</span>
                My Appointments
            </h2>
            <p>View and manage all your scheduled appointments with patients</p>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">📅</div>
                <div class="stat-title">Total Appointments</div>
                <div class="stat-number" id="totalAppointments">--</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">⏳</div>
                <div class="stat-title">Pending</div>
                <div class="stat-number" id="pendingAppointments">--</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-title">Completed</div>
                <div class="stat-number" id="completedAppointments">--</div>
            </div>
        </div>

        <div class="appointments-section">
            <div class="appointments-header">
                <h3>
                    <span>👥</span>
                    Patient Appointments
                </h3>
                <input type="text" id="searchInput" class="search-box" placeholder="🔍 Search by patient ID...">
            </div>
            
            <div class="table-container">
                <table class="appointments-table" id="appointmentsTable">
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="appointmentsBody">
                        <?php
                        $hasAppointments = false;
                        while($row=$res->fetch_assoc()){
                            $hasAppointments = true;
                            $status = isset($row['status']) ? $row['status'] : 'Pending';
                            $statusClass = strtolower($status);
                        ?>
                        <tr>
                            <td>
                                <strong>#<?= $row['patient_id'] ?></strong>
                            </td>
                            <td>
                                <?= date('F j, Y', strtotime($row['date'])) ?>
                            </td>
                            <td>
                                <?= date('g:i A', strtotime($row['date'])) ?>
                            </td>
                            <td>
                                <span class="status-badge status-<?= $statusClass ?>">
                                    <?= $status ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="patient_details.php?id=<?= $row['patient_id'] ?>" class="btn-view">👁️ View</a>
                                    <a href="upload_report.php?patient_id=<?= $row['patient_id'] ?>&appointment_id=<?= $row['id'] ?>" class="btn-upload">📄 Upload Report</a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
                <?php if(!$hasAppointments): ?>
                <div class="empty-state">
                    <div class="icon">📅</div>
                    <p>No appointments scheduled yet</p>
                    <p style="font-size: 0.9rem;">Check back later for new appointments</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="upload-section">
            <h3>📄 Upload Medical Reports</h3>
            <p>Quickly upload and manage patient reports, prescriptions, and medical documents</p>
            <a href="upload.php" class="upload-btn">
                <span>📤</span> Upload New Report
            </a>
        </div>
    </div>

    <script>
        // Calculate statistics from the table data
        function updateStatistics() {
            const rows = document.querySelectorAll('#appointmentsBody tr');
            const total = rows.length;
            let pending = 0;
            let completed = 0;
            
            rows.forEach(row => {
                const statusCell = row.querySelector('.status-badge');
                if(statusCell) {
                    const status = statusCell.textContent.trim().toLowerCase();
                    if(status === 'pending') pending++;
                    if(status === 'completed') completed++;
                }
            });
            
            document.getElementById('totalAppointments').textContent = total;
            document.getElementById('pendingAppointments').textContent = pending;
            document.getElementById('completedAppointments').textContent = completed;
        }
        
        // Search functionality
        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('#appointmentsBody tr');
            
            rows.forEach(row => {
                const patientId = row.cells[0].textContent.toLowerCase();
                if(patientId.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        // Add event listener for search
        document.getElementById('searchInput').addEventListener('keyup', searchTable);
        
        // Update statistics when page loads
        document.addEventListener('DOMContentLoaded', updateStatistics);
        
        // Optional: Refresh data every 30 seconds
        // setInterval(() => {
        //     location.reload();
        // }, 30000);
    </script>
</body>
</html>