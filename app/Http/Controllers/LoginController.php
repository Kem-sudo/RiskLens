<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class LoginController extends Controller
{
    public function showLogin()
    {
        // CHANGE THIS - look for auth/login.blade.php
        return view('auth.login');  // ← Changed from 'login' to 'auth.login'
    }
    
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $user = User::where('Email', $request->email)->first();
        
        if ($user && Hash::check($request->password, $user->Password)) {
            
            if ($user->Status !== 'active') {
                return back()->with('error', 'Your account is inactive. Please contact administrator.');
            }
            
            session(['user_id' => $user->User_ID]);
            session(['user_name' => $user->Name]);
            session(['user_email' => $user->Email]);
            session(['role_id' => $user->Role_ID]);
            session(['role_name' => $user->role->Role_Name ?? 'Unknown']);
            session(['is_logged_in' => true]);
            
            return redirect()->route('dashboard')->with('success', 'Welcome back, ' . $user->Name . '!');
        }
        
        return back()->with('error', 'Invalid email or password.');
    }
    
    public function dashboard()
{
    if (!session('is_logged_in')) {
        return redirect()->route('login');
    }
    
    $totalRisks = \App\Models\Risk::count();
    $openIncidents = \App\Models\Incident::whereIn('Status', ['Open', 'In Progress'])->count();
    $completedAudits = Schema::hasColumn('audits', 'Status')
        ? \App\Models\Audit::where('Status', 'Completed')->count()
        : \App\Models\Audit::count();
    
    $totalCompliance = \App\Models\Compliance::count();
    $compliantCount = \App\Models\Compliance::where('Status', 'Compliant')->count();
    $complianceRate = $totalCompliance > 0 ? round(($compliantCount / $totalCompliance) * 100) : 0;

    $riskLevelChart = [
        'Low' => \App\Models\Risk::where('Risk_Level', 'Low')->count(),
        'Medium' => \App\Models\Risk::where('Risk_Level', 'Medium')->count(),
        'High' => \App\Models\Risk::where('Risk_Level', 'High')->count(),
        'Critical' => \App\Models\Risk::where('Risk_Level', 'Critical')->count(),
    ];

    $complianceStatusChart = [
        'Compliant' => \App\Models\Compliance::where('Status', 'Compliant')->count(),
        'Non-Compliant' => \App\Models\Compliance::where('Status', 'Non-Compliant')->count(),
        'Partial' => \App\Models\Compliance::where('Status', 'Partial')->count(),
        'Under Review' => \App\Models\Compliance::where('Status', 'Under Review')->count(),
    ];

    $recentActivities = [];
    $latestRisk = \App\Models\Risk::latest('Created_at')->first();
    if ($latestRisk) {
        $recentActivities[] = ['message' => 'New risk logged: ' . $latestRisk->Risk_Title, 'time' => date('M d, Y H:i', strtotime($latestRisk->Created_at))];
    }
    $latestIncident = \App\Models\Incident::latest('Reported_Date')->first();
    if ($latestIncident) {
        $recentActivities[] = ['message' => 'Incident reported: ' . $latestIncident->Incident_Title, 'time' => date('M d, Y H:i', strtotime($latestIncident->Reported_Date))];
    }
    $latestCompliance = \App\Models\Compliance::latest('created_at')->first();
    if ($latestCompliance) {
        $recentActivities[] = ['message' => 'Compliance record #' . $latestCompliance->Compliance_ID . ' updated', 'time' => date('M d, Y H:i', strtotime($latestCompliance->created_at))];
    }
    $latestAudit = \App\Models\Audit::latest('created_at')->first();
    if ($latestAudit) {
        $recentActivities[] = ['message' => 'Audit created: ' . $latestAudit->Audit_Title, 'time' => date('M d, Y H:i', strtotime($latestAudit->created_at))];
    }
    
    return view('dashboard', [
        'name' => session('user_name'),
        'email' => session('user_email'),
        'role' => session('role_name'),
        'joinedDate' => now()->format('F j, Y'),
        'totalRisks' => $totalRisks,
        'openIncidents' => $openIncidents,
        'completedAudits' => $completedAudits,
        'complianceRate' => $complianceRate,
        'riskLevelChart' => $riskLevelChart,
        'complianceStatusChart' => $complianceStatusChart,
        'recentActivities' => $recentActivities,
    ]);
}
    
    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}