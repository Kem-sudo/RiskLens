<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use App\Models\Incident;
use App\Models\Compliance;
use App\Models\Audit;

class LandingPageController extends Controller
{
    public function index()
    {
        // Get statistics for the landing page
        $stats = [
            'total_risks' => Risk::count(),
            'open_incidents' => Incident::where('Status', '!=', 'Closed')->count(),
            'compliance_rate' => $this->calculateComplianceRate(),
            'total_audits' => Audit::count(),
        ];
        
        return view('landing', compact('stats'));
    }
    
    private function calculateComplianceRate()
    {
        $total = Compliance::count();
        if ($total == 0) return 0;
        
        $compliant = Compliance::where('Status', 'Compliant')->count();
        return round(($compliant / $total) * 100);
    }
}