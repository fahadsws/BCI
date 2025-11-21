<?php

namespace App\Livewire\Common;

use App\Models\Quotations;
use App\Models\Invoices;
use App\Models\Items;
use App\Models\Leads;
use App\Models\ParkGates;
use App\Models\Parks;
use App\Models\Resorts;
use App\Models\Taxis;
use App\Models\Tours;
use App\Models\Zones;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

#[Title('Dashboard')]
#[Layout('components.layouts.common-app')]
class Dashboard extends Component
{
    public $dashboardData = [];

    public function mount()
    {
        $user = Auth::guard('web')->user();

        $commonData = [
            'parks' => Parks::count(),
            'zones' => Zones::count(),
            'taxis' => Taxis::count(),
            'gates' => ParkGates::count(),
            'resorts' => Resorts::count(),
            'items' => Items::count(),
            'projects' => Tours::count(),
        ];
        $userData = [
            'leads' => Leads::where('user_id', $user->id)->count(),
            'Invoice' => Invoices::where('user_id', $user->id)->count(),
            'Estimate' => Quotations::where('user_id', $user->id)->count(),
        ];
        $adminDashboard = [
            ['title' => 'Park', 'value' => $commonData['parks'], 'route' => route('common.park')],
            ['title' => 'Zone', 'value' => $commonData['zones'], 'route' => route('common.zone')],
            ['title' => 'Taxi', 'value' => $commonData['taxis'], 'route' => route('common.taxi')],
            ['title' => 'Gates', 'value' => $commonData['gates'], 'route' => route('common.gates')],
            ['title' => 'Resort', 'value' => $commonData['resorts'], 'route' => route('common.resort')],
            ['title' => 'Items', 'value' => $commonData['items'], 'route' => route('common.item')],
            ['title' => 'Project', 'value' => $commonData['projects'], 'route' => route('common.tour')],
        ];

        $userDashboard = [
            ['title' => 'Leads', 'value' => $userData['leads'], 'route' => route('common.lead')],
            ['title' => 'Invoice', 'value' => $userData['Invoice'], 'route' => route('common.invoice')],
            ['title' => 'Estimate', 'value' => $userData['Estimate'], 'route' => route('common.quotation')],
        ];

        $this->dashboardData = $user->hasRole('admin')  ? $adminDashboard : $userDashboard;
    }

    public function render()
    {
        return view('livewire.common.dashboard');
    }
}
