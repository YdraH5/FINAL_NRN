<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\Appartment;
use App\Models\Reservation;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationSuccess;
use Livewire\WithPagination;
use Carbon\Carbon;

class ReserveTable extends Component
{
    use WithPagination;
    public $isApprove = false;
    public $isReject = false;
    public $modal = false;
    public $search = '';
    public $currentReceipt;
    public $id;
    public $categ_id;
    public $currentStatus;
    protected $listeners = ['showReceipt'];
    public $sortDirection = "ASC";
    public $sortColumn = "created_at";
    public $perPage = 10;
    public $approved_id;
    public $rejected_id;
    // Summary properties
    public $totalReservations;
    public $approvedCount;
    public $pendingCount;
    public $rejectedCount;
    public $showConfirmApproval = false;

    public function mount()
    {
        $this->calculateSummary();
    }

    public function calculateSummary()
    {
        $this->totalReservations = DB::table('reservations')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $this->approvedCount = DB::table('reservations')
            ->where('status', 'approved')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $this->pendingCount = DB::table('reservations')
            ->where('status', 'pending')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $this->rejectedCount = DB::table('reservations')
            ->where('status', 'Rejected')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
    }

    public function doSort($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = ($this->sortDirection === 'ASC') ? 'DESC' : 'ASC';
            return;
        }
        $this->sortColumn = $column;
        $this->sortDirection = 'ASC';
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when search input is updated
    }

    public function showReceipt($receipt, $categ_id, $status, $id)
    {
        $this->modal = true;
        $this->currentReceipt = $receipt;
        $this->id = $id;
        $this->categ_id = $categ_id;
        $this->currentStatus = $status;
    }

    public function close()
    {
        $this->modal = false;
        $this->currentStatus = null;
        $this->currentReceipt = null;
        $this->id = null;
        $this->reset(['currentReceipt', 'currentStatus', 'id']); // Reset specific property
    }
    public function approve($id){
        $this->isApprove = true;
        $this->approved_id = $id;
    }
    public function approved()
        {
            // Find the reservation
            $reservation = Reservation::findOrFail($this->approved_id);
            
            // Update the apartment status to 'Reserved'
            Appartment::where('id', $reservation->apartment_id)
                ->update([
                    'status' => 'Reserved',
                    'renter_id' => $reservation->user_id
                ]);
            User::where('id', $reservation->user_id)
                ->update([
                    'role' => 'reserve'
                ]);
            // Update the reservation status to 'Approved'
            $reservation->update(['status' => 'Approved']);
            
            // Flash success message
            return redirect()->route('owner.reserve.index')->with('success', 'Payment Rejected successfully.');
        }
    public function reject($id){
        $this->isReject = true;
        $this->rejected_id = $id;
    }  
    public function rejected()
    {
        {
            // Find the reservation
            $reservation = Reservation::findOrFail($this->rejected_id);
            
            // Update the reservation status to 'Approved'
            $reservation->update(['status' => 'Rejected']);
            
            // Flash success message
            return redirect()->route('owner.reserve.index')->with('success', 'Payment Rejected successfully.');
        }
    }

    public function render()
    {
        // Base query with necessary joins
        $query = DB::table('users')
            ->join('reservations', 'users.id', '=', 'reservations.user_id')
            ->join('apartment', 'apartment.id', '=', 'reservations.apartment_id')
            ->join('buildings', 'buildings.id', '=', 'apartment.building_id')
            ->join('categories', 'categories.id', '=', 'apartment.category_id')
            ->select(
                'apartment.id as apartment_id',
                'users.id as user_id',
                'users.name as user_name',
                'users.email',
                'categories.name as categ_name',
                'categories.id as categ_id',
                'apartment.room_number',
                'buildings.name as building_name',
                DB::raw('DATE_FORMAT(reservations.check_in, "%b-%d-%Y") as check_in_date'),
                'reservations.rental_period',
                'reservations.id as reservation_id',
                'reservations.created_at',
                'reservations.check_in',
                'reservations.status as reservation_status'
            )
            ->orderBy($this->sortColumn, $this->sortDirection);

        // Search fields
        $searchFields = [
            'users.name',
            'categories.name',
            'users.email',
            'apartment.status',
            'apartment.room_number',
            'buildings.name',
            'reservations.check_in',
            'reservations.rental_period',
        ];

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($query) use ($searchFields) {
                foreach ($searchFields as $field) {
                    $query->orWhere($field, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Paginate the results
        $reservations = $query->paginate($this->perPage);

        // Conditionally render the correct view based on user role
        if (auth()->user()->role === 'admin') {
            return view('livewire.admin.reserve-table', [
                'reservations' => $reservations,
                'totalReservations' => $this->totalReservations,
                'approvedCount' => $this->approvedCount,
                'pendingCount' => $this->pendingCount,
                'rejectedCount' => $this->rejectedCount,
            ]);
        } elseif (auth()->user()->role === 'owner') {
            return view('livewire.owner.reserve-table', [
                'reservations' => $reservations,
                'totalReservations' => $this->totalReservations,
                'approvedCount' => $this->approvedCount,
                'pendingCount' => $this->pendingCount,
                'rejectedCount' => $this->rejectedCount,
            ]);
        } else {
            // Handle if user doesn't have the right role
            abort(403, 'Unauthorized action.');
        }
    }
}