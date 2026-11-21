<?php
session_start();
include("config/db.php");

if(isset($_POST['up'])){
    $file = $_FILES['f']['name'];
    move_uploaded_file($_FILES['f']['tmp_name'], "uploads/".$file);
    
    $conn->query("INSERT INTO reports(patient_id,doctor_id,file)
    VALUES ('$_POST[pid]','$_SESSION[did]','$file')");
    
    $uploadSuccess = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Medical Report - Doctor Portal</title>
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
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Upload Card */
        .upload-card {
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
        .upload-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .upload-header .icon {
            font-size: 4rem;
            margin-bottom: 15px;
        }

        .upload-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .upload-header p {
            opacity: 0.9;
            font-size: 14px;
        }

        /* Form */
        .upload-form {
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
            z-index: 1;
        }

        input[type="text"],
        input[type="number"] {
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

        /* File Upload Area */
        .file-upload-area {
            border: 2px dashed #e0e0e0;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .file-upload-area:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }

        .file-upload-area.drag-over {
            border-color: #667eea;
            background: #f0f2ff;
        }

        .upload-icon {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .upload-text {
            color: #666;
            font-size: 14px;
        }

        .upload-text .browse-text {
            color: #667eea;
            font-weight: 600;
            cursor: pointer;
        }

        .file-info {
            margin-top: 15px;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 8px;
            display: none;
        }

        .file-info.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        .file-name {
            font-weight: 600;
            color: #333;
            word-break: break-all;
        }

        .file-size {
            color: #666;
            font-size: 12px;
            margin-top: 5px;
        }

        input[type="file"] {
            display: none;
        }

        /* Upload Button */
        .upload-btn {
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

        .upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .upload-btn:active {
            transform: translateY(0);
        }

        .upload-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Success Message */
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.5s ease-out;
            border-left: 4px solid #28a745;
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
            border-left: 4px solid #dc3545;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Patient Suggestions */
        .patient-suggestions {
            margin-top: 5px;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            position: absolute;
            width: calc(100% - 30px);
            z-index: 10;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .patient-suggestions.show {
            display: block;
        }

        .suggestion-item {
            padding: 10px 15px;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .suggestion-item:hover {
            background: #f0f0f0;
        }

        /* File Type Badge */
        .file-type-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 10px;
        }

        .badge-pdf {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-image {
            background: #dbeafe;
            color: #2563eb;
        }

        .badge-doc {
            background: #d1fae5;
            color: #059669;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .upload-header {
                padding: 30px 20px;
            }
            
            .upload-header h1 {
                font-size: 24px;
            }
            
            .upload-form {
                padding: 30px 20px;
            }
            
            .navbar {
                padding: 1rem;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Tooltip */
        .tooltip {
            position: absolute;
            background: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            margin-bottom: 5px;
            white-space: nowrap;
            display: none;
            z-index: 1000;
        }

        .input-group:hover .tooltip {
            display: block;
        }
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
            <a href="doctor_dashboard.php" class="back-btn">← Dashboard</a>
            <a href="logout.php" class="logout-btn">🚪 Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="upload-card">
            <div class="upload-header">
                <div class="icon">📤</div>
                <h1>Upload Medical Report</h1>
                <p>Share important medical documents with your patients</p>
            </div>
            
            <div class="upload-form">
                <?php if(isset($uploadSuccess)): ?>
                <div class="success-message">
                    <i>✓</i>
                    <span>Report uploaded successfully! The patient can now access it.</span>
                </div>
                <?php endif; ?>
                
                <form method="POST" enctype="multipart/form-data" id="uploadForm">
                    <div class="form-group">
                        <label>👤 Patient ID</label>
                        <div class="input-group">
                            <span class="input-icon">🆔</span>
                            <input type="number" name="pid" id="patientId" placeholder="Enter patient ID" required>
                            <span class="tooltip">Enter the unique ID of the patient</span>
                        </div>
                        <div id="patientSuggestions" class="patient-suggestions"></div>
                        <div style="font-size: 12px; color: #666; margin-top: 5px;">
                            💡 You can find the Patient ID in the appointments list
                        </div>
                    </div>

                    <div class="form-group">
                        <label>📄 Select File</label>
                        <div class="file-upload-area" id="dropZone">
                            <div class="upload-icon">📁</div>
                            <div class="upload-text">
                                Drag & drop your file here or 
                                <span class="browse-text" onclick="document.getElementById('fileInput').click()">browse</span>
                            </div>
                            <div class="upload-text" style="font-size: 12px; margin-top: 10px;">
                                Supported formats: PDF, JPG, PNG, DOC, DOCX (Max 10MB)
                            </div>
                        </div>
                        <input type="file" name="f" id="fileInput" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        <div class="file-info" id="fileInfo">
                            <div class="file-name" id="fileName"></div>
                            <div class="file-size" id="fileSize"></div>
                        </div>
                    </div>

                    <button type="submit" name="up" class="upload-btn" id="uploadBtn">
                        <span>📤</span> Upload Report
                    </button>
                </form>

                <div style="margin-top: 25px; padding: 15px; background: #f8f9fa; border-radius: 10px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                        <span>📋</span>
                        <strong style="color: #333;">Upload Guidelines:</strong>
                    </div>
                    <ul style="margin-left: 25px; color: #666; font-size: 13px; line-height: 1.6;">
                        <li>Ensure the file is not corrupted before uploading</li>
                        <li>Use descriptive file names for easy identification</li>
                        <li>Maximum file size: 10MB</li>
                        <li>Supported formats: PDF, JPG, PNG, DOC, DOCX</li>
                        <li>Reports are automatically linked to the patient's profile</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // File upload handling
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const uploadBtn = document.getElementById('uploadBtn');
        
        // Drag and drop events
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('drag-over');
        });
        
        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('drag-over');
        });
        
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('drag-over');
            const files = e.dataTransfer.files;
            if(files.length > 0) {
                fileInput.files = files;
                handleFileSelect(files[0]);
            }
        });
        
        // File selection handler
        fileInput.addEventListener('change', (e) => {
            if(e.target.files.length > 0) {
                handleFileSelect(e.target.files[0]);
            }
        });
        
        function handleFileSelect(file) {
            // Validate file type
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            const maxSize = 10 * 1024 * 1024; // 10MB
            
            if(!allowedTypes.includes(file.type)) {
                alert('Invalid file type! Please upload PDF, JPG, PNG, DOC, or DOCX files.');
                fileInput.value = '';
                fileInfo.classList.remove('show');
                return;
            }
            
            if(file.size > maxSize) {
                alert('File is too large! Maximum size is 10MB.');
                fileInput.value = '';
                fileInfo.classList.remove('show');
                return;
            }
            
            // Display file info
            fileName.textContent = file.name;
            const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
            fileSize.textContent = `${sizeInMB} MB`;
            fileInfo.classList.add('show');
            
            // Add file type badge
            const fileExt = file.name.split('.').pop().toLowerCase();
            let badgeClass = '';
            if(fileExt === 'pdf') badgeClass = 'badge-pdf';
            else if(['jpg', 'jpeg', 'png'].includes(fileExt)) badgeClass = 'badge-image';
            else if(['doc', 'docx'].includes(fileExt)) badgeClass = 'badge-doc';
            
            const existingBadge = document.querySelector('.file-type-badge');
            if(existingBadge) existingBadge.remove();
            
            const badge = document.createElement('span');
            badge.className = `file-type-badge ${badgeClass}`;
            badge.textContent = fileExt.toUpperCase();
            fileName.appendChild(badge);
        }
        
        // Patient ID validation and suggestions
        const patientIdInput = document.getElementById('patientId');
        const suggestionsDiv = document.getElementById('patientSuggestions');
        
        // Fetch patient suggestions (you can implement this with AJAX)
        // This is a placeholder for real patient search functionality
        async function fetchPatientSuggestions(query) {
            if(query.length < 1) {
                suggestionsDiv.classList.remove('show');
                return;
            }
            
            // You can implement AJAX call to fetch patients
            // Example:
            // const response = await fetch(`get_patients.php?q=${query}`);
            // const patients = await response.json();
            
            // For demo, we'll just show a message
            suggestionsDiv.innerHTML = '<div class="suggestion-item">💡 Enter a valid patient ID from your appointments</div>';
            suggestionsDiv.classList.add('show');
        }
        
        let typingTimer;
        patientIdInput.addEventListener('input', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                fetchPatientSuggestions(patientIdInput.value);
            }, 500);
        });
        
        // Close suggestions when clicking outside
        document.addEventListener('click', (e) => {
            if(e.target !== patientIdInput) {
                suggestionsDiv.classList.remove('show');
            }
        });
        
        // Form validation
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            const patientId = document.getElementById('patientId').value;
            const file = document.getElementById('fileInput').files[0];
            
            if(!patientId) {
                e.preventDefault();
                alert('Please enter Patient ID');
                return false;
            }
            
            if(!file) {
                e.preventDefault();
                alert('Please select a file to upload');
                return false;
            }
            
            // Show loading state
            uploadBtn.innerHTML = '<span class="loading"></span> Uploading...';
            uploadBtn.disabled = true;
        });
        
        // Preview file on drop
        function previewFile(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Optional: Add file preview functionality
                console.log('File ready for upload:', file.name);
            };
            reader.readAsDataURL(file);
        }
        
        // Add click handler for browse text
        document.querySelector('.browse-text').addEventListener('click', (e) => {
            e.stopPropagation();
            fileInput.click();
        });
        
        // Auto-fill patient ID from URL parameter (optional)
        const urlParams = new URLSearchParams(window.location.search);
        const patientIdParam = urlParams.get('patient_id');
        if(patientIdParam) {
            patientIdInput.value = patientIdParam;
        }
    </script>
</body>
</html>