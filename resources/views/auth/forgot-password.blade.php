<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - RiskLens</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f5f7fb;">
<div class="container d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="card shadow-sm" style="max-width:460px; width:100%; border-radius:12px;">
        <div class="card-body p-4">
            <h4 class="mb-2">Forgot Password</h4>
            <p class="text-muted mb-4">Enter your email and we will send a reset link.</p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            @if(session('reset_link'))
                <div class="alert alert-info">
                    <div class="small mb-1">Development reset link:</div>
                    <a href="{{ session('reset_link') }}" class="small">{{ session('reset_link') }}</a>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>
                <button type="submit" class="btn btn-dark w-100">Send Reset Link</button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="small text-decoration-none">Back to Login</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
