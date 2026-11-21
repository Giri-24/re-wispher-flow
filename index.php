<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System - Quality Healthcare Services</title>
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
            overflow-x: hidden;
        }

        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .bg-animation .circle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        /* Main Container */
        .container {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Hero Section */
        .hero {
            max-width: 1200px;
            width: 100%;
            background: white;
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header Section */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1%, transparent 1%);
            background-size: 50px 50px;
            animation: shimmer 60s linear infinite;
        }

        @keyframes shimmer {
            from {
                transform: translate(0, 0);
            }
            to {
                transform: translate(50px, 50px);
            }
        }

        .header h1 {
            font-size: 3rem;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        /* Stats Section */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: #e0e0e0;
        }

        .stat-item {
            background: white;
            padding: 30px 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Main Content */
        .main-content {
            padding: 50px 40px;
            background: white;
        }

        .welcome-text {
            text-align: center;
            margin-bottom: 40px;
        }

        .welcome-text h2 {
            color: #333;
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .welcome-text p {
            color: #666;
            font-size: 1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Portal Cards */
        .portals {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .portal-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: block;
            position: relative;
        }

        .portal-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .portal-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .portal-card:hover::before {
            transform: scaleX(1);
        }

        .card-icon {
            font-size: 4rem;
            text-align: center;
            padding: 40px 20px 20px;
        }

        .card-content {
            padding: 20px 30px 30px;
            text-align: center;
        }

        .card-content h3 {
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .card-content p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .card-btn {
            display: inline-block;
            padding: 10px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .portal-card:hover .card-btn {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        /* Feature Section */
        .features {
            margin-top: 60px;
            padding-top: 40px;
            border-top: 1px solid #e0e0e0;
        }

        .features h3 {
            text-align: center;
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 30px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
        }

        .feature-item {
            text-align: center;
            padding: 20px;
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .feature-item h4 {
            color: #333;
            margin-bottom: 10px;
        }

        .feature-item p {
            color: #666;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        /* Footer */
        .footer {
            background: #f8f9fa;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }

        .footer p {
            color: #666;
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
            
            .header p {
                font-size: 1rem;
            }
            
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .main-content {
                padding: 30px 20px;
            }
            
            .portals {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .card-icon {
                padding: 30px 20px 15px;
            }
            
            .card-content {
                padding: 15px 20px 25px;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }

        /* Animation for cards */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .portal-card {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }

        .portal-card:nth-child(1) { animation-delay: 0.2s; }
        .portal-card:nth-child(2) { animation-delay: 0.3s; }
        .portal-card:nth-child(3) { animation-delay: 0.4s; }
    </style>
</head>
<body>
    <div class="bg-animation">
        <div class="circle" style="width: 300px; height: 300px; top: -100px; left: -100px; animation-duration: 25s;"></div>
        <div class="circle" style="width: 200px; height: 200px; bottom: -50px; right: -50px; animation-duration: 20s;"></div>
        <div class="circle" style="width: 150px; height: 150px; top: 50%; left: 10%; animation-duration: 30s;"></div>
        <div class="circle" style="width: 100px; height: 100px; bottom: 20%; right: 15%; animation-duration: 22s;"></div>
    </div>

    <div class="container">
        <div class="hero">
            <div class="header">
                <h1>🏥 Hospital Management System</h1>
                <p>Your trusted partner in quality healthcare management</p>
            </div>

            <div class="stats">
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Emergency Care</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Expert Doctors</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Happy Patients</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Secure System</div>
                </div>
            </div>

            <div class="main-content">
                <div class="welcome-text">
                    <h2>Welcome to Our Healthcare Portal</h2>
                    <p>Access your personalized healthcare services with just one click</p>
                </div>

                <div class="portals">
                    <!-- Patient Portal -->
                    <div class="portal-card" onclick="location.href='register.php'">
                        <div class="card-icon">👨‍👩‍👧‍👦</div>
                        <div class="card-content">
                            <h3>Patient Portal</h3>
                            <p>Register or login to book appointments, view medical records, and manage your health</p>
                            <div style="margin-top: 15px;">
                                <a href="register.php" class="card-btn">Register →</a>
                                <a href="login.php" style="margin-left: 10px; color: #667eea; text-decoration: none;">Login</a>
                            </div>
                        </div>
                    </div>

                    <!-- Doctor Portal -->
                    <div class="portal-card" onclick="location.href='doctor_login.php'">
                        <div class="card-icon">👨‍⚕️</div>
                        <div class="card-content">
                            <h3>Doctor Portal</h3>
                            <p>Access your dashboard, manage appointments, and upload patient reports securely</p>
                            <a href="doctor_login.php" class="card-btn">Doctor Login →</a>
                        </div>
                    </div>

                    <!-- Admin Portal -->
                    <div class="portal-card" onclick="location.href='admin_login.php'">
                        <div class="card-icon">👑</div>
                        <div class="card-content">
                            <h3>Admin Portal</h3>
                            <p>Manage doctors, view all patients, and oversee hospital operations</p>
                            <a href="admin_login.php" class="card-btn">Admin Login →</a>
                        </div>
                    </div>
                </div>

                <div class="features">
                    <h3>Why Choose Us?</h3>
                    <div class="features-grid">
                        <div class="feature-item">
                            <div class="feature-icon">📅</div>
                            <h4>Easy Booking</h4>
                            <p>Book appointments online with your preferred doctors</p>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">📊</div>
                            <h4>Digital Records</h4>
                            <p>Access your medical history and reports anytime</p>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">🔒</div>
                            <h4>Secure & Private</h4>
                            <p>Your health information is protected with bank-level security</p>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">💬</div>
                            <h4>24/7 Support</h4>
                            <p>Round-the-clock assistance for all your healthcare needs</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <p>© 2024 Hospital Management System | Committed to Excellence in Healthcare</p>
            </div>
        </div>
    </div>

    <script>
        // Smooth card click handling
        document.querySelectorAll('.portal-card').forEach(card => {
            card.addEventListener('click', function(e) {
                // Don't trigger if clicking on links inside
                if(e.target.tagName !== 'A') {
                    const link = this.querySelector('a');
                    if(link) {
                        window.location.href = link.href;
                    }
                }
            });
        });
        
        // Add hover effect on stats
        document.querySelectorAll('.stat-item').forEach(stat => {
            stat.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            stat.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>