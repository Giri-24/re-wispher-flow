<?php
include("config/db.php");

$res = $conn->query("SELECT * FROM patients ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients - Admin Panel</title>
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

        .admin-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-name {
            color: #666;
            font-weight: 500;
            background: #f0f0f0;
            padding: 8px 15px;
            border-radius: 20px;
        }

        .back-btn {
            background: #667eea;
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

        .back-btn:hover {
            background: #5a67d8;
            transform: translateY(-2px);
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
        }

        /* Main Container */
        .container {
            max-width: 1400px;
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

        /* Patients Section */
        .patients-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .patients-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .patients-header h3 {
            color: #333;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-box {
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 14px;
            width: 300px;
            transition: all 0.3s ease;
        }

        .search-box:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
        }

        .patients-table {
            width: 100%;
            border-collapse: collapse;
        }

        .patients-table th,
        .patients-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .patients-table th {
            background: #f8f9fa;
            color: #666;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .patients-table td {
            color: #333;
        }

        .patients-table tbody tr {
            transition: background 0.2s ease;
        }

        .patients-table tbody tr:hover {
            background: #f8f9fa;
            transform: translateX(2px);
        }

        /* Patient Avatar */
        .patient-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .patient-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .patient-details {
            display: flex;
            flex-direction: column;
        }

        .patient-name {
            font-weight: 600;
            color: #333;
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
            padding: 6px 12px;
            border-radius: 6px;
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

        .btn-email {
            background: #48bb78;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-email:hover {
            background: #38a169;
            transform: translateY(-1px);
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-active {
            background: #d4edda;
            color: #155724;
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

        .empty-state h3 {
            color: #666;
            margin-bottom: 0.5rem;
        }

        /* Footer */
        .footer {
            margin-top: 2rem;
            text-align: center;
            padding: 1.5rem;
            color: white;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .page-btn {
            padding: 8px 15px;
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #666;
        }

        .page-btn:hover {
            border-color: #667eea;
            color: #667eea;
        }

        .page-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }

        /* Responsive */
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
            
            .patients-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .search-box {
                width: 100%;
            }
            
            .patients-table th,
            .patients-table td {
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

        .stat-card, .patients-section {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        .stat-card { animation-delay: 0.1s; }
        .patients-section { animation-delay: 0.2s; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <span>🏥</span>
            Admin Panel
        </div>
        <div class="admin-info">
            <span class="admin-name">👑 Admin</span>
            <a href="admin_dashboard.php" class="back-btn">← Dashboard</a>
            <a href="logout.php" class="logout-btn">🚪 Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="header-section">
            <h2>
                <span>👥</span>
                Patient Management
            </h2>
            <p>View and manage all registered patients in the system</p>
        </div>

        <?php
        $totalPatients = $res->num_rows;
        $res->data_seek(0);
        ?>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">👨‍👩‍👧‍👦</div>
                <div class="stat-title">Total Patients</div>
                <div class="stat-number"><?= $totalPatients ?></div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">📅</div>
                <div class="stat-title">Registered Today</div>
                <div class="stat-number" id="todayCount">--</div>
            </div>
        </div>

        <div class="patients-section">
            <div class="patients-header">
                <h3>
                    <span>📋</span>
                    Registered Patients List
                </h3>
                <input type="text" id="searchPatients" class="search-box" placeholder="🔍 Search by name or email...">
            </div>

            <div class="table-container">
                <table class="patients-table" id="patientsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Email Address</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="patientsBody">
                        <?php
                        if($totalPatients > 0) {
                            $counter = 1;
                            while($row = $res->fetch_assoc()){
                                // Get initials for avatar
                                $initials = strtoupper(substr($row['name'], 0, 2));
                                $email = htmlspecialchars($row['email']);
                                $name = htmlspecialchars($row['name']);
                                
                                echo '<tr data-name="' . strtolower($name) . '" data-email="' . strtolower($email) . '">';
                                echo '<td style="font-weight: 600; color: #667eea;">#' . $counter . '</td>';
                                echo '<td>';
                                echo '<div class="patient-info">';
                                echo '<div class="patient-avatar">' . $initials . '</div>';
                                echo '<div class="patient-details">';
                                echo '<div class="patient-name">' . $name . '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</td>';
                                echo '<td>';
                                echo '<a href="mailto:' . $email . '" style="color: #667eea; text-decoration: none;">' . $email . '</a>';
                                echo '</td>';
                                echo '<td><span class="badge badge-active">● Active</span></td>';
                                echo '<td>';
                                echo '<div class="action-buttons">';
                                echo '<a href="patient_details.php?id=' . $row['id'] . '" class="btn-view">👁️ View</a>';
                                echo '<a href="mailto:' . $email . '" class="btn-email">✉️ Email</a>';
                                echo '</div>';
                                echo '</td>';
                                echo '</tr>';
                                $counter++;
                            }
                        } else {
                            echo '<tr><td colspan="5"><div class="empty-state">';
                            echo '<div class="icon">👥</div>';
                            echo '<h3>No Patients Found</h3>';
                            echo '<p>No patients have registered yet.</p>';
                            echo '</div></td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php if($totalPatients > 10): ?>
            <div class="pagination" id="pagination">
                <!-- Pagination will be added dynamically -->
            </div>
            <?php endif; ?>
        </div>

        <div class="footer">
            <p>🔒 All patient data is securely stored and managed</p>
        </div>
    </div>

    <script>
        // Search functionality
        const searchInput = document.getElementById('searchPatients');
        const tableRows = document.querySelectorAll('#patientsBody tr');
        
        if(searchInput) {
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                let visibleCount = 0;
                
                tableRows.forEach(row => {
                    const name = row.getAttribute('data-name');
                    const email = row.getAttribute('data-email');
                    
                    if((name && name.includes(searchTerm)) || (email && email.includes(searchTerm))) {
                        row.style.display = '';
                        visibleCount++;
                    } else if(!searchTerm) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                // Show message if no results
                const emptyMessage = document.getElementById('noResultsMessage');
                if(visibleCount === 0 && searchTerm) {
                    if(!emptyMessage) {
                        const tbody = document.getElementById('patientsBody');
                        const messageRow = document.createElement('tr');
                        messageRow.id = 'noResultsMessage';
                        messageRow.innerHTML = '<td colspan="5"><div class="empty-state"><div class="icon">🔍</div><h3>No Results Found</h3><p>No patients matching "' + searchTerm + '" were found.</p></div></td>';
                        tbody.appendChild(messageRow);
                    }
                } else if(emptyMessage) {
                    emptyMessage.remove();
                }
            });
        }
        
        // Calculate today's registrations (this would normally come from database)
        function calculateTodayRegistrations() {
            // This is a placeholder - you would typically query the database for today's registrations
            // For demo purposes, we'll set a random number
            const todayCount = document.getElementById('todayCount');
            if(todayCount) {
                // You can replace this with actual data from your database
                // For now, showing a placeholder
                todayCount.textContent = '0';
            }
        }
        
        calculateTodayRegistrations();
        
        // Add animation to table rows
        document.querySelectorAll('#patientsBody tr').forEach((row, index) => {
            if(row.querySelector('.empty-state')) return;
            row.style.animation = `fadeInUp 0.3s ease-out forwards`;
            row.style.opacity = '0';
            row.style.animationDelay = `${index * 0.05}s`;
        });
        
        // Export functionality (optional)
        function exportToCSV() {
            const rows = document.querySelectorAll('#patientsBody tr');
            let csvContent = "ID,Name,Email,Status\n";
            
            rows.forEach(row => {
                if(row.querySelector('.empty-state')) return;
                const cells = row.querySelectorAll('td');
                if(cells.length >= 4) {
                    const id = cells[0].innerText;
                    const name = cells[1].querySelector('.patient-name')?.innerText || '';
                    const email = cells[2].innerText.replace('mailto:', '');
                    const status = cells[3].innerText;
                    csvContent += `${id},${name},${email},${status}\n`;
                }
            });
            
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'patients_list.csv';
            a.click();
            URL.revokeObjectURL(url);
        }
        
        // Add export button dynamically (optional)
        const patientsHeader = document.querySelector('.patients-header');
        if(patientsHeader && document.querySelectorAll('#patientsBody tr').length > 0) {
            const exportBtn = document.createElement('button');
            exportBtn.innerHTML = '📊 Export CSV';
            exportBtn.className = 'btn-view';
            exportBtn.style.background = '#48bb78';
            exportBtn.style.marginLeft = '10px';
            exportBtn.onclick = exportToCSV;
            patientsHeader.appendChild(exportBtn);
        }
        
        // Tooltip for email links
        document.querySelectorAll('a[href^="mailto:"]').forEach(link => {
            link.addEventListener('mouseenter', () => {
                const email = link.textContent;
                link.title = `Send email to ${email}`;
            });
        });
    </script>
</body>
</html>