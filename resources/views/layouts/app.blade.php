<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RiskLens - @yield('title', 'GRC System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-main: #f5f7fb;
            --surface: #ffffff;
            --surface-soft: #f8fafc;
            --primary: #1f2937;
            --primary-soft: #374151;
            --text-main: #111827;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --shadow-soft: 0 6px 18px rgba(17, 24, 39, 0.06);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-main);
            color: var(--text-main);
        }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #111827 0%, #1f2937 100%);
            color: #fff;
            position: fixed;
            height: 100%;
            padding: 20px 0;
            box-shadow: 10px 0 30px rgba(17, 24, 39, 0.18);
        }
        
        .sidebar h3 { text-align: center; margin-bottom: 5px; font-weight: 600; font-size: 1.5rem; }
        .sidebar .subtitle { text-align: center; font-size: 11px; opacity: 0.6; margin-bottom: 20px; }
        .sidebar hr { margin: 15px 0; border-color: rgba(255,255,255,0.1); }
        
        .sidebar a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: block;
            padding: 11px 25px;
            transition: 0.2s ease;
            font-size: 14px;
            border-left: 3px solid transparent;
        }
        
        .sidebar a:hover { background: rgba(255,255,255,0.08); color: white; }
        .sidebar a.active {
            background: rgba(255,255,255,0.14);
            border-left: 3px solid #93c5fd;
            color: white;
        }
        .sidebar a i { width: 25px; margin-right: 10px; }
        
        .btn-logout {
            background: none;
            border: none;
            color: rgba(255,255,255,0.8);
            width: 100%;
            text-align: left;
            padding: 11px 25px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.2s ease;
        }
        
        .btn-logout:hover { background: rgba(255,255,255,0.08); color: white; }
        
        /* Main Content */
        .main-content { margin-left: 260px; padding: 24px; }
        
        /* Top Bar */
        .top-bar {
            background: var(--surface);
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
        }
        
        .top-bar h5 { font-weight: 600; margin: 0; color: var(--text-main); }
        
        /* Cards */
        .card {
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: var(--shadow-soft);
            background: var(--surface);
        }
        
        .card-header {
            background: var(--surface-soft);
            border-bottom: 1px solid var(--border);
            padding: 12px 20px;
            font-weight: 600;
            font-size: 14px;
            color: var(--text-main);
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        
        .card-body { padding: 20px; }
        
        /* Forms */
        .form-label { font-size: 14px; font-weight: 500; color: var(--text-main); margin-bottom: 5px; }
        .form-control { border-radius: 8px; border: 1px solid #d1d5db; padding: 9px 12px; font-size: 14px; }
        .form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15); }
        
        /* Buttons */
        .btn-dark {
            background: var(--primary);
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-size: 14px;
            font-weight: 500;
        }
        .btn-dark:hover { background: var(--primary-soft); }
        .btn-outline-secondary { border-radius: 8px; font-size: 14px; }
        
        /* Table */
        .table { margin: 0; font-size: 13px; }
        .table th { font-weight: 600; color: #374151; border-bottom-width: 1px; }
        .table td { vertical-align: middle; color: #4b5563; }
        
        /* Alerts */
        .alert { border-radius: 10px; font-size: 14px; padding: 10px 15px; border: none; box-shadow: var(--shadow-soft); }
        
        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            margin-top: 30px;
            color: var(--text-muted);
            font-size: 12px;
            border-top: 1px solid var(--border);
        }
        
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    @php
        $currentRole = session('role_name');
        $roleAliases = config('access.role_aliases', []);
        $normalizedRole = $roleAliases[$currentRole] ?? $currentRole;
        $rolePermissions = config('access.permissions.' . $normalizedRole, []);
        $can = function (string $permission) use ($rolePermissions): bool {
            return in_array($permission, $rolePermissions, true);
        };
    @endphp

    <div>
        <h3>RiskLens</h3>
        <div class="subtitle">GRC System</div>
    </div>
    <hr>
    
    <!-- Dashboard -->
    @if($can('dashboard.view'))
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    @endif
    
    <!-- Risk Management -->
    @if($can('risks.view'))
    <a href="{{ route('risks.index') }}" class="{{ request()->routeIs('risks.*') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i> Risk Management
    </a>
    @endif
    
    <!-- Compliance -->
    @if($can('compliance.view'))
    <a href="{{ route('compliance.index') }}" class="{{ request()->routeIs('compliance.*') ? 'active' : '' }}">
        <i class="fas fa-check-circle"></i> Compliance
    </a>
    @endif

    @if($can('incidents.view'))
    <a href="{{ route('incidents.index') }}" class="{{ request()->routeIs('incidents.*') ? 'active' : '' }}">
        <i class="fas fa-exclamation-triangle"></i> Incidents
    </a>
    @endif

    @if($can('policies.view'))
    <a href="{{ route('policies.index') }}" class="{{ request()->routeIs('policies.*') ? 'active' : '' }}">
        <i class="fas fa-file-alt"></i> Policies
    </a>
    @endif

    @if($can('audits.view'))
    <a href="{{ route('audits.index') }}" class="{{ request()->routeIs('audits.*') ? 'active' : '' }}">
        <i class="fas fa-clipboard-list"></i> Audits
    </a>
    @endif
    
    <hr>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>

<div class="main-content">
    <div class="top-bar">
        <h5>@yield('title', 'Dashboard')</h5>
        <div class="text-muted small">
            <i class="fas fa-user me-1"></i> {{ session('user_name') }} ({{ session('role_name') }})
        </div>
    </div>

    @php
        $errorMessage = session('error');
    @endphp
    @if($errorMessage && $errorMessage !== 'You do not have permission to access this page.')
        <div class="alert alert-danger">{{ $errorMessage }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>