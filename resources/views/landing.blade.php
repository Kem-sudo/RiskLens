<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RiskLens - Governance, Risk & Compliance Monitoring System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary: #1e3c72;
            --primary-dark: #0f2027;
            --secondary: #2a5298;
            --accent: #4a90e2;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            color: var(--dark);
        }
        
        /* Navigation */
        .navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            transition: all 0.3s;
            padding: 15px 0;
        }
        
        .navbar.scrolled {
            padding: 10px 0;
            background: white;
        }
        
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .navbar-brand img {
            height: 45px;
            margin-right: 10px;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--dark);
            margin: 0 10px;
            transition: 0.3s;
        }
        
        .nav-link:hover {
            color: var(--secondary);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 8px 25px;
            border-radius: 25px;
            font-weight: 500;
            transition: 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30,60,114,0.3);
            color: white;
        }
        
        .btn-register {
            background: transparent;
            border: 2px solid var(--secondary);
            color: var(--secondary);
            padding: 8px 25px;
            border-radius: 25px;
            font-weight: 500;
            transition: 0.3s;
        }
        
        .btn-register:hover {
            background: var(--secondary);
            color: white;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.1"><path fill="white" d="M10,10 L90,10 L90,90 L10,90 Z"/><circle cx="50" cy="50" r="8"/></svg>') repeat;
            pointer-events: none;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            color: white;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        .hero-stats {
            display: flex;
            gap: 30px;
            margin-top: 40px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        .hero-image {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        /* Section Styles */
        .section {
            padding: 80px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .section-title p {
            color: #666;
            font-size: 1.1rem;
        }
        
        /* Module Cards */
        .module-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s;
            height: 100%;
        }
        
        .module-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .module-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .module-icon i {
            font-size: 40px;
            color: white;
        }
        
        .module-card h4 {
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .module-card p {
            color: #666;
            line-height: 1.6;
        }
        
        /* Role Cards */
        .role-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: 0.3s;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .role-card:hover {
            transform: translateY(-5px);
        }
        
        .role-level {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--primary);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }
        
        .role-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        
        .role-icon i {
            font-size: 35px;
            color: white;
        }
        
        .role-card h4 {
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .role-card .badge {
            margin-bottom: 15px;
            padding: 5px 12px;
        }
        
        .role-card ul {
            text-align: left;
            padding-left: 20px;
            margin-top: 15px;
        }
        
        .role-card li {
            margin: 8px 0;
            color: #666;
        }
        
        /* Feature Section */
        .feature-item {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .feature-icon i {
            font-size: 28px;
            color: white;
        }
        
        .feature-content h4 {
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .feature-content p {
            color: #666;
        }
        
        /* CTA Section */
        .cta {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            text-align: center;
            padding: 60px 0;
        }
        
        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        
        .cta p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        .btn-cta {
            background: white;
            color: var(--primary);
            padding: 12px 35px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 1.1rem;
            transition: 0.3s;
            border: none;
        }
        
        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            color: var(--primary);
        }
        
        /* Footer */
        .footer {
            background: var(--primary-dark);
            color: white;
            padding: 50px 0 20px;
        }
        
        .footer h5 {
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .footer a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: 0.3s;
        }
        
        .footer a:hover {
            color: white;
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            margin-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            .section {
                padding: 50px 0;
            }
            .hero-stats {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
    <span>RiskLens</span>
</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#modules">Modules</a></li>
                <li class="nav-item"><a class="nav-link" href="#roles">Roles</a></li>
                <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
            </ul>
            <div class="ms-lg-3 d-flex gap-2 mt-3 mt-lg-0">
                <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                <a href="{{ route('register') }}" class="btn btn-register">Register</a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section id="home" class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="hero-content" data-aos="fade-right">
    <h1>RiskLens</h1>
    <p>Governance, Risk & Compliance Monitoring System</p>
    <!-- Rest of hero content -->
</div>
                <div class="d-flex gap-3">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">Get Started</a>
                    <a href="#modules" class="btn btn-outline-light btn-lg">Learn More</a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['total_risks'] ?? 0 }}</div>
                        <div class="stat-label">Risks Identified</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['open_incidents'] ?? 0 }}</div>
                        <div class="stat-label">Open Incidents</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['compliance_rate'] ?? 0 }}%</div>
                        <div class="stat-label">Compliance Rate</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="hero-image text-center">
                    <i class="fas fa-shield-alt" style="font-size: 300px; opacity: 0.8;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modules Section -->
<section id="modules" class="section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>System Modules</h2>
            <p>Comprehensive modules for complete GRC management</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="module-card">
                    <div class="module-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4>Risk Identification & Assessment</h4>
                    <p>Identify, assess, and prioritize organizational risks with automated scoring and risk matrices.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="module-card">
                    <div class="module-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h4>Compliance Monitoring</h4>
                    <p>Track compliance with policies and regulations through automated monitoring and reporting.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="module-card">
                    <div class="module-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h4>Internal Audit Module</h4>
                    <p>Conduct and track internal audits with comprehensive findings and remediation tracking.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="module-card">
                    <div class="module-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h4>Policy Management</h4>
                    <p>Create, manage, and distribute organizational policies with acknowledgment tracking.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="module-card">
                    <div class="module-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h4>Incident Tracking</h4>
                    <p>Report and track operational and compliance incidents with real-time status updates.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="module-card">
                    <div class="module-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h4>Analytics & Reporting</h4>
                    <p>Generate comprehensive reports and dashboards for data-driven decision making.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Target Users / Roles Section -->
<section id="roles" class="section" style="background: var(--light);">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Target Users</h2>
            <p>Role-based access for different organizational levels</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="role-card">
                    <div class="role-level">1</div>
                    <div class="role-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <h4>Super Admin</h4>
                    <span class="badge bg-danger">Level 1</span>
                    <ul>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Manage User Accounts</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Assign Roles & Permissions</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Configure System Settings</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> View System Logs</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="role-card">
                    <div class="role-level">2</div>
                    <div class="role-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h4>System Administrator</h4>
                    <span class="badge bg-warning">Level 2</span>
                    <ul>
                        <li><i class="fas fa-check-circle text-success me-2"></i> System Configuration</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> User Management</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Backup & Maintenance</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Security Monitoring</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="role-card">
                    <div class="role-level">3</div>
                    <div class="role-icon">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <h4>Compliance Officer</h4>
                    <span class="badge bg-info">Level 3</span>
                    <ul>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Monitor Compliance Status</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Review Policy Adherence</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Generate Compliance Reports</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> View Risk Dashboard</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="role-card">
                    <div class="role-level">3</div>
                    <div class="role-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4>Internal Auditor</h4>
                    <span class="badge bg-info">Level 3</span>
                    <ul>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Review Compliance Reports</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Access Audit Logs</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Conduct Internal Audits</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Generate Audit Reports</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="role-card">
                    <div class="role-level">4</div>
                    <div class="role-icon">
                        <i class="fas fa-chart-simple"></i>
                    </div>
                    <h4>Department Manager</h4>
                    <span class="badge bg-success">Level 4</span>
                    <ul>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Identify Department Risks</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Submit Risk Assessment</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Monitor Incident Reports</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> View Risk Reports</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="role-card">
                    <div class="role-level">5</div>
                    <div class="role-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4>Employee</h4>
                    <span class="badge bg-secondary">Level 5</span>
                    <ul>
                        <li><i class="fas fa-check-circle text-success me-2"></i> View Company Policies</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Acknowledge Policies</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Report Incidents</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Track Incident Status</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Key Features</h2>
            <p>Powerful features to manage your GRC processes</p>
        </div>
        <div class="row">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Authentication & Authorization</h4>
                        <p>Secure login with role-based access control and permission management.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-shield-virus"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Input Validation & Security</h4>
                        <p>Protection against SQL injection, XSS attacks, and CSRF threats.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Logging & Monitoring</h4>
                        <p>Comprehensive audit trails and activity logging for accountability.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-session"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Session Management</h4>
                        <p>Secure session handling with timeout and concurrent session control.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Data Access Control</h4>
                        <p>Fine-grained data access based on user roles and permissions.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Email Notifications</h4>
                        <p>Automated alerts and notifications via SMTP integration.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Technology Stack -->
<section class="section" style="background: var(--light);">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Technology Stack</h2>
            <p>Built with modern and reliable technologies</p>
        </div>
        <div class="row text-center g-4">
            <div class="col-md-3 col-6" data-aos="flip-left" data-aos-delay="100">
                <i class="fab fa-laravel" style="font-size: 60px; color: #ff2d20;"></i>
                <h5 class="mt-3">Laravel</h5>
                <p class="text-muted">Backend Framework</p>
            </div>
            <div class="col-md-3 col-6" data-aos="flip-left" data-aos-delay="200">
                <i class="fas fa-database" style="font-size: 60px; color: #00758f;"></i>
                <h5 class="mt-3">MySQL</h5>
                <p class="text-muted">Database</p>
            </div>
            <div class="col-md-3 col-6" data-aos="flip-left" data-aos-delay="300">
                <i class="fab fa-js" style="font-size: 60px; color: #f7df1e;"></i>
                <h5 class="mt-3">JavaScript</h5>
                <p class="text-muted">Frontend</p>
            </div>
            <div class="col-md-3 col-6" data-aos="flip-left" data-aos-delay="400">
                <i class="fab fa-bootstrap" style="font-size: 60px; color: #7952b3;"></i>
                <h5 class="mt-3">Bootstrap</h5>
                <p class="text-muted">UI Framework</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta">
    <div class="container" data-aos="zoom-in">
        <h2>Ready to Get Started?</h2>
        <p>Join RiskLens today and take control of your organization's governance, risk, and compliance.</p>
        <a href="{{ route('register') }}" class="btn btn-cta">Create Free Account</a>
    </div>
</section>

<!-- Footer -->
<footer id="contact" class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="d-flex align-items-center mb-3">
    <h4 class="mb-0">RiskLens</h4>
</div>
                <div class="mt-3">
                    <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="me-3"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#modules">Modules</a></li>
                    <li><a href="#roles">Roles</a></li>
                    <li><a href="#features">Features</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>Modules</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Risk Management</a></li>
                    <li><a href="#">Compliance Monitoring</a></li>
                    <li><a href="#">Internal Audit</a></li>
                    <li><a href="#">Policy Management</a></li>
                    <li><a href="#">Incident Tracking</a></li>
                </ul>
            </div>
            <div class="col-lg-3 mb-4">
                <h5>Contact Info</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-envelope me-2"></i> support@risklens.com</li>
                    <li><i class="fas fa-phone me-2"></i> +63 (2) 1234 5678</li>
                    <li><i class="fas fa-map-marker-alt me-2"></i> Manila, Philippines</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 RiskLens - Governance, Risk & Compliance Monitoring System. All rights reserved.</p>
            <p class="small">Developed by Philip Kim Rontal | IT15/L Integrative Programming and Technologies</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 1000,
        once: true
    });
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>
</body>
</html>