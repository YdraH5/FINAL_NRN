<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use App\Models\Building;
use App\Models\Appartment;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Category;
use App\Models\DueDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use Livewire\WithPagination;
use Carbon\Carbon;

class OwnerdashboardController extends Controller


{   
    use WithPagination;
    public function index()
        {
        // Room metrics
        $totalRooms = Appartment::count();
        $occupiedRooms = Appartment::whereNotNull('renter_id')->count();
        $vacantRooms = $totalRooms - $occupiedRooms;
        $occupancyRate = $totalRooms > 0 ? ($occupiedRooms / $totalRooms) * 100 : 0;
    
        // Revenue metrics
        $currentMonthRevenue = Payment::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'paid')
            ->sum('amount');
    
        $prevMonthRevenue = Payment::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->where('status', 'paid')
            ->sum('amount');
    
        $revenueChange = $prevMonthRevenue > 0 ? 
            (($currentMonthRevenue - $prevMonthRevenue) / $prevMonthRevenue) * 100 : 0;
    
        // Lease metrics
        $expiringLeases = Reservation::whereBetween('check_in', [now(), now()->addDays(30)])
            ->count();
        // In your AdminDashboardController's index method
    $overdueRenters = DueDate::with(['user', 'payment'])
    ->where('payment_due_date', '<', now())
    ->where('status', '!=', 'paid')
    ->whereHas('user', function($query) {
        $query->where('role', 'renter');
    })
    ->orderBy('payment_due_date')
    ->get()
    ->map(function($dueDate) {
        // Get the apartment through the user's reservations
        $apartment = Reservation::where('user_id', $dueDate->user_id)
            ->where('status', 'approved')
            ->with('apartment.building')
            ->first()
            ->apartment ?? null;
            
        $dueDate->apartment = $apartment;
        return $dueDate;
    })
    ->filter(function($dueDate) {
        return $dueDate->apartment !== null;
    });
      // Maintenance metrics
      $openMaintenance = Report::where('status', 'Pending')->count();
      $inProgressMaintenance = Report::where('status', 'Ongoing')->count();
      $completedMaintenance = Report::where('status', 'Fixed')->count();
  
      // Payment metrics
      $totalPayments = Payment::count();
      $paidPayments = Payment::where('status', 'paid')->count();
      $pendingPayments = Payment::where('status', 'pending')->count();
      $overduePayments = DueDate::where('payment_due_date', '<', now())
          ->where('status', '!=', 'paid')
          ->count();
      // Get leases expiring soon (next 30 days) with user and apartment info
      $expiringLease = Reservation::with(['user', 'apartment'])
      ->whereBetween('check_in', [now(), now()->addDays(30)])
      ->orderBy('check_in')
      ->get();
      // Monthly revenue data for chart
      $monthlyRevenue = Payment::select(
              DB::raw('SUM(amount) as total'), 
              DB::raw('MONTH(created_at) as month')
          )
          ->whereYear('created_at', now()->year)
          ->where('status', 'paid')
          ->groupBy(DB::raw('MONTH(created_at)'))
          ->pluck('total', 'month');
          
  
      $months = collect(range(1, 12))->mapWithKeys(function ($month) use ($monthlyRevenue) {
          return [$month => $monthlyRevenue->get($month, 0)];
      });
  
      // Recent activities
      $recentActivities = Activity::with(['subject'])
          ->latest()
          ->paginate(20);
  
  
      // Building-specific occupancy data
      $buildingOccupancy = Building::withCount([
          'apartments',
          'apartments as occupied_count' => function($query) {
              $query->whereNotNull('renter_id');
          }
      ])->get();
      // Get weekly revenue data
        $weeklyRevenue = Payment::where('status', 'paid')
            ->selectRaw('WEEK(created_at) as week, SUM(amount) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        // Get monthly revenue data
        $monthlyRevenue = Payment::where('status', 'paid')
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get yearly revenue data
        $yearlyRevenue = Payment::where('status', 'paid')
            ->selectRaw('YEAR(created_at) as year, SUM(amount) as total')
            ->groupBy('year')
            ->orderBy('year')
            ->get();
  
      // Extract specific building data (alternative approach)
      $buildingA = Building::where('name', 'A')->first();
      $buildingB = Building::where('name', 'B')->first();
  
      $buildingAOccupied = $buildingA ? $buildingA->occupied_count : 0;
      $buildingAVacant = $buildingA ? ($buildingA->apartments_count - $buildingA->occupied_count) : 0;
      
      $buildingBOccupied = $buildingB ? $buildingB->occupied_count : 0;
      $buildingBVacant = $buildingB ? ($buildingB->apartments_count - $buildingB->occupied_count) : 0;
    // Pass data to the view
    return view('owner.dashboard', compact(
            'totalRooms',
            'occupiedRooms',
            'weeklyRevenue',
            'monthlyRevenue',
            'yearlyRevenue',
            'expiringLease',
            'vacantRooms',
            'occupancyRate',
            'overdueRenters',
            'currentMonthRevenue',
            'prevMonthRevenue',
            'revenueChange',
            'expiringLeases',
            'openMaintenance',
            'inProgressMaintenance',
            'completedMaintenance',
            'totalPayments',
            'paidPayments',
            'pendingPayments',
            'overduePayments',
            'months',
            'recentActivities',
            'buildingOccupancy',
            'buildingAOccupied',
            'buildingAVacant',
            'buildingBOccupied',
            'buildingBVacant'
    ));
}
    
}
