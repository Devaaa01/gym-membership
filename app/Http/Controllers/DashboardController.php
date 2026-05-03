<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Membership;
use App\Models\GymClass;
use App\Models\Payment;
use App\Models\ClassBooking;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers      = Member::count();
        $activeMembers     = Member::where('status', 'active')->count();
        $activeMemberships = Membership::where('status', 'active')->count();
        $expiringThisMonth = Membership::where('status', 'active')
            ->whereBetween('end_date', [now(), now()->endOfMonth()])
            ->count();

        $monthlyRevenue = Payment::where('status', 'paid')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');

        $totalRevenue = Payment::where('status', 'paid')->sum('amount');

        $upcomingClasses = GymClass::with('trainer')
            ->where('status', 'scheduled')
            ->where('schedule', '>=', now())
            ->orderBy('schedule')
            ->take(5)
            ->get();

        $recentMembers = Member::latest()->take(5)->get();

        $recentPayments = Payment::with(['member', 'membership.plan'])
            ->latest()
            ->take(5)
            ->get();

        // Revenue chart data (last 6 months)
        $revenueChart = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenueChart[] = [
                'month'   => $month->format('M Y'),
                'revenue' => Payment::where('status', 'paid')
                    ->whereMonth('payment_date', $month->month)
                    ->whereYear('payment_date', $month->year)
                    ->sum('amount'),
            ];
        }

        return view('dashboard', compact(
            'totalMembers', 'activeMembers', 'activeMemberships',
            'expiringThisMonth', 'monthlyRevenue', 'totalRevenue',
            'upcomingClasses', 'recentMembers', 'recentPayments', 'revenueChart'
        ));
    }
}
