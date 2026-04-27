<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use App\Models\RiskCategory;
use App\Models\Policy;

// CHANGE THIS LINE - Rename the class
class RiskLensDatabaseSeeder extends Seeder  // ← Make sure this says RiskLensDatabaseSeeder, not DatabaseSeeder
{
    public function run(): void
    {
        // Your existing code here...
        $roles = [
            ['Role_ID' => 1, 'Role_Name' => 'Super Admin', 'Description' => 'Level 1 - Full system access'],
            ['Role_ID' => 2, 'Role_Name' => 'System Admin', 'Description' => 'Level 2 - System administration'],
            ['Role_ID' => 3, 'Role_Name' => 'Compliance Officer', 'Description' => 'Level 3 - Compliance and audit'],
            ['Role_ID' => 4, 'Role_Name' => 'Internal Auditor', 'Description' => 'Level 3 - Internal audit and reporting'],
            ['Role_ID' => 5, 'Role_Name' => 'Department Manager', 'Description' => 'Level 4 - Department risk management'],
            ['Role_ID' => 6, 'Role_Name' => 'Employee', 'Description' => 'Level 5 - Basic user access'],
        ];
        
        foreach ($roles as $role) {
            Role::updateOrCreate(['Role_ID' => $role['Role_ID']], $role);
        }
        
        $users = [
            [
                'User_ID' => 1,
                'Role_ID' => 1,
                'Name' => 'Philip Kim Rontal',
                'Email' => 'admin@risklens.com',
                'Password' => Hash::make('password123'),
                'Status' => 'active',
                'Created_at' => now()
            ],
            [
                'User_ID' => 2,
                'Role_ID' => 2,
                'Name' => 'System Administrator',
                'Email' => 'sysadmin@risklens.com',
                'Password' => Hash::make('password123'),
                'Status' => 'active',
                'Created_at' => now()
            ],
            [
                'User_ID' => 3,
                'Role_ID' => 3,
                'Name' => 'Compliance Officer',
                'Email' => 'compliance@risklens.com',
                'Password' => Hash::make('password123'),
                'Status' => 'active',
                'Created_at' => now()
            ],
            [
                'User_ID' => 4,
                'Role_ID' => 4,
                'Name' => 'Internal Auditor',
                'Email' => 'auditor@risklens.com',
                'Password' => Hash::make('password123'),
                'Status' => 'active',
                'Created_at' => now()
            ],
            [
                'User_ID' => 5,
                'Role_ID' => 5,
                'Name' => 'Department Manager',
                'Email' => 'manager@risklens.com',
                'Password' => Hash::make('password123'),
                'Status' => 'active',
                'Created_at' => now()
            ],
            [
                'User_ID' => 6,
                'Role_ID' => 6,
                'Name' => 'John Employee',
                'Email' => 'employee@risklens.com',
                'Password' => Hash::make('password123'),
                'Status' => 'active',
                'Created_at' => now()
            ],
        ];
        
        foreach ($users as $user) {
            User::updateOrCreate(['User_ID' => $user['User_ID']], $user);
        }
        
        $categories = [
            ['Category_Name' => 'Cybersecurity', 'Description' => 'Data breaches, hacking, malware'],
            ['Category_Name' => 'Operational', 'Description' => 'Process failures, system outages'],
            ['Category_Name' => 'Compliance', 'Description' => 'Regulatory violations'],
            ['Category_Name' => 'Financial', 'Description' => 'Fraud, budget issues'],
            ['Category_Name' => 'Strategic', 'Description' => 'Business strategy risks'],
        ];
        
        foreach ($categories as $cat) {
            RiskCategory::updateOrCreate(['Category_Name' => $cat['Category_Name']], $cat);
        }
        
        $policies = [
            ['Created_by' => 1, 'Policy_Title' => 'Data Protection Policy', 'Description' => 'Guidelines for data handling'],
            ['Created_by' => 1, 'Policy_Title' => 'Access Control Policy', 'Description' => 'User access management'],
            ['Created_by' => 1, 'Policy_Title' => 'Incident Response Policy', 'Description' => 'Security incident procedures'],
        ];
        
        foreach ($policies as $policy) {
            Policy::create($policy);
        }
        
        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📝 Login credentials:');
        $this->command->info('   Super Admin: admin@risklens.com / password123');
        $this->command->info('   System Admin: sysadmin@risklens.com / password123');
        $this->command->info('   Compliance Officer: compliance@risklens.com / password123');
        $this->command->info('   Internal Auditor: auditor@risklens.com / password123');
        $this->command->info('   Manager: manager@risklens.com / password123');
        $this->command->info('   Employee: employee@risklens.com / password123');
    }
}