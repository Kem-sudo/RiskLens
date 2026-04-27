<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - RiskLens GRC System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1e3c72;
            --primary-dark: #0f2027;
            --secondary: #2a5298;
            --accent: #4a90e2;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.05"><path fill="white" d="M10,10 L90,10 L90,90 L10,90 Z"/><circle cx="50" cy="50" r="8"/></svg>') repeat;
            pointer-events: none;
        }
        
        /* Navigation - Same as Landing Page */
        .navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            transition: all 0.3s;
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-decoration: none;
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
        
        .btn-login-nav {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 8px 25px;
            border-radius: 25px;
            font-weight: 500;
            transition: 0.3s;
            text-decoration: none;
        }
        
        .btn-login-nav:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30,60,114,0.3);
            color: white;
        }
        
        .btn-register-nav {
            background: transparent;
            border: 2px solid var(--secondary);
            color: var(--secondary);
            padding: 8px 25px;
            border-radius: 25px;
            font-weight: 500;
            transition: 0.3s;
            text-decoration: none;
        }
        
        .btn-register-nav:hover {
            background: var(--secondary);
            color: white;
        }
        
        /* Register Card */
        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            width: 100%;
            max-width: 550px;
        }
        
        .register-header {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            padding: 30px;
            text-align: center;
            color: white;
        }
        
        .register-header h1 {
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
        }
        
        .register-header p {
            margin-top: 10px;
            opacity: 0.8;
        }
        
        .register-body {
            padding: 40px;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            transition: 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 0.2rem rgba(42,82,152,0.25);
        }
        
        .btn-register {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: bold;
            width: 100%;
            color: white;
            transition: 0.3s;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }
        
        .btn-login {
            background: transparent;
            border: 2px solid var(--secondary);
            color: var(--secondary);
            padding: 10px;
            border-radius: 10px;
            width: 100%;
            font-weight: bold;
            transition: 0.3s;
            text-align: center;
            display: block;
            text-decoration: none;
        }
        
        .btn-login:hover {
            background: var(--secondary);
            color: white;
        }
        
        .password-strength {
            height: 5px;
            margin-top: 8px;
            border-radius: 5px;
            transition: 0.3s;
        }
        
        .alert {
            border-radius: 10px;
        }
        
        /* Footer */
        .footer {
            background: var(--primary-dark);
            color: white;
            padding: 30px 0 20px;
            margin-top: 50px;
        }
        
        .footer a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: 0.3s;
        }
        
        .footer a:hover {
            color: white;
        }
    </style>
</head>
<body>

<!-- Navigation - Same as Landing Page -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('landing') }}">RiskLens</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('landing') }}#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('landing') }}#modules">Modules</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('landing') }}#roles">Roles</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('landing') }}#features">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('landing') }}#contact">Contact</a></li>
            </ul>
            <div class="ms-lg-3 d-flex gap-2 mt-3 mt-lg-0">
                <a href="{{ route('login') }}" class="btn-login-nav">Login</a>
                <a href="{{ route('register') }}" class="btn-register-nav">Register</a>
            </div>
        </div>
    </div>
</nav>

<!-- Register Form -->
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh; padding-top: 100px; padding-bottom: 50px;">
    <div class="register-card">
        <div class="register-header">
            <h1>RiskLens</h1>
            <p>Create Your Account</p>
        </div>
        <div class="register-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->Role_ID }}">{{ $role->Role_Name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <div class="password-strength" id="strengthBar"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="passwordConfirm" class="form-control" required>
                    <small id="matchMessage" class="text-muted"></small>
                </div>
                <button type="submit" class="btn-register">Create Account</button>
            </form>

            <hr class="my-4">

            <a href="{{ route('login') }}" class="btn-login">Already have an account? Login</a>
            
            <div class="text-center mt-3">
                <small class="text-muted">
                    <a href="{{ route('landing') }}" class="text-decoration-none">← Back to Homepage</a>
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="text-center">
            <p class="mb-0">&copy; 2026 RiskLens - Governance, Risk & Compliance Monitoring System. All rights reserved.</p>
            <p class="small mt-2">Developed by Philip Kim Rontal | IT15/L Integrative Programming and Technologies</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const password = document.getElementById('password');
    const confirm = document.getElementById('passwordConfirm');
    const strengthBar = document.getElementById('strengthBar');
    const matchMsg = document.getElementById('matchMessage');

    password.addEventListener('input', function() {
        let strength = 0;
        if (this.value.length >= 6) strength++;
        if (this.value.match(/[a-z]+/)) strength++;
        if (this.value.match(/[A-Z]+/)) strength++;
        if (this.value.match(/[0-9]+/)) strength++;
        
        let width = '0%';
        let color = '#dc3545';
        if (strength === 1) { width = '25%'; color = '#dc3545'; }
        else if (strength === 2) { width = '50%'; color = '#ffc107'; }
        else if (strength === 3) { width = '75%'; color = '#17a2b8'; }
        else if (strength >= 4) { width = '100%'; color = '#28a745'; }
        
        strengthBar.style.width = width;
        strengthBar.style.backgroundColor = color;
        strengthBar.style.display = width !== '0%' ? 'block' : 'none';
    });

    confirm.addEventListener('input', function() {
        if (this.value === password.value && this.value !== '') {
            matchMsg.innerHTML = '<i class="fas fa-check-circle"></i> Passwords match';
            matchMsg.style.color = '#28a745';
        } else if (this.value !== '') {
            matchMsg.innerHTML = '<i class="fas fa-times-circle"></i> Passwords do not match';
            matchMsg.style.color = '#dc3545';
        } else {
            matchMsg.innerHTML = '';
        }
    });
</script>
</body>
</html>