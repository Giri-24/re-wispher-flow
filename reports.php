<?php
session_start();
include("config/db.php");

$res = $conn->query("SELECT * FROM reports WHERE patient_id='$_SESSION[pid]' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reports - Hospital Management System</title>
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

        /* Reports Section */
        .reports-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .reports-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .reports-header h3 {
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

        /* Reports Grid */
        .reports-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .report-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }

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

        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-color: #667eea;
        }

        .report-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .report-info {
            margin-bottom: 1rem;
        }

        .report-name {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            word-break: break-all;
            background: white;
            padding: 8px;
            border-radius: 8px;
            font-family: monospace;
        }

        .report-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.5rem;
        }

        .report-date {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .report-size {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .download-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
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

        .empty-state p {
            margin-bottom: 1.5rem;
        }

        .book-appointment-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .book-appointment-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        /* Footer */
        .footer {
            margin-top: 2rem;
            text-align: center;
            padding: 1.5rem;
            color: white;
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
            
            .reports-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .reports-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .search-box {
                width: 100%;
            }
        }
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
            <a href="dashboard.php" class="back-btn">← Dashboard</a>
            <a href="logout.php" class="logout-btn">🚪 Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="header-section">
            <h2>
                <span>📄</span>
                My Medical Reports
            </h2>
            <p>Access and download your medical reports, prescriptions, and test results</p>
        </div>

        <?php
        // Calculate statistics
        $totalReports = $res->num_rows;
        
        // Reset pointer to fetch data
        $res->data_seek(0);
        ?>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-title">Total Reports</div>
                <div class="stat-number"><?= $totalReports ?></div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">📅</div>
                <div class="stat-title">Last Updated</div>
                <div class="stat-number" style="font-size: 1.2rem;"><?= date('M d, Y') ?></div>
            </div>
        </div>

        <div class="reports-section">
            <div class="reports-header">
                <h3>
                    <span>📋</span>
                    Available Reports
                </h3>
                <input type="text" id="searchReports" class="search-box" placeholder="🔍 Search reports...">
            </div>

            <div class="reports-grid" id="reportsGrid">
                <?php
                if($totalReports > 0) {
                    $delay = 0;
                    while($row = $res->fetch_assoc()){
                        $fileName = basename($row['file']);
                        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                        $fileIcon = getFileIcon($fileExt);
                        
                        // Get file size if file exists
                        $filePath = "uploads/" . $row['file'];
                        $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
                        $formattedSize = formatFileSize($fileSize);
                        
                        // Get report date (use current if not available)
                        $reportDate = isset($row['upload_date']) ? $row['upload_date'] : date('Y-m-d');
                        
                        echo '<div class="report-card" data-filename="' . strtolower($fileName) . '">';
                        echo '<div class="report-icon">' . $fileIcon . '</div>';
                        echo '<div class="report-info">';
                        echo '<div class="report-name">' . htmlspecialchars($fileName) . '</div>';
                        echo '<div class="report-meta">';
                        echo '<span class="report-date">📅 ' . date('F j, Y', strtotime($reportDate)) . '</span>';
                        echo '<span class="report-size">💾 ' . $formattedSize . '</span>';
                        echo '</div>';
                        echo '</div>';
                        echo '<a href="uploads/' . htmlspecialchars($row['file']) . '" class="download-btn" download>';
                        echo '📥 Download Report';
                        echo '</a>';
                        echo '</div>';
                        $delay += 0.1;
                    }
                } else {
                    echo '<div class="empty-state">';
                    echo '<div class="icon">📭</div>';
                    echo '<h3>No Reports Found</h3>';
                    echo '<p>You don\'t have any medical reports yet.</p>';
                    echo '<a href="book.php" class="book-appointment-btn">📅 Book an Appointment</a>';
                    echo '</div>';
                }
                
                function getFileIcon($ext) {
                    $ext = strtolower($ext);
                    switch($ext) {
                        case 'pdf':
                            return '📕';
                        case 'jpg':
                        case 'jpeg':
                        case 'png':
                        case 'gif':
                            return '🖼️';
                        case 'doc':
                        case 'docx':
                            return '📘';
                        case 'txt':
                            return '📄';
                        default:
                            return '📎';
                    }
                }
                
                function formatFileSize($bytes) {
                    if ($bytes == 0) return '0 B';
                    $k = 1024;
                    $sizes = ['B', 'KB', 'MB', 'GB'];
                    $i = floor(log($bytes) / log($k));
                    return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
                }
                ?>
            </div>
        </div>

        <div class="footer">
            <p>🔒 Your medical reports are securely stored and encrypted</p>
        </div>
    </div>

    <script>
        // Search functionality
        const searchInput = document.getElementById('searchReports');
        const reportCards = document.querySelectorAll('.report-card');
        
        if(searchInput) {
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                
                reportCards.forEach(card => {
                    const filename = card.getAttribute('data-filename');
                    if(filename && filename.includes(searchTerm)) {
                        card.style.display = '';
                    } else if(!searchTerm) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
        
        // Add animation delay to report cards
        document.querySelectorAll('.report-card').forEach((card, index) => {
            card.style.animationDelay = `${index * 0.05}s`;
        });
        
        // Optional: Add download tracking
        document.querySelectorAll('.download-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                // You can add analytics tracking here
                console.log('Downloading: ' + this.href);
                
                // Optional: Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '⏳ Downloading...';
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 2000);
            });
        });
        
        // Auto-refresh option (commented out)
        // setTimeout(() => {
        //     location.reload();
        // }, 30000);
    </script>
</body>
</html>