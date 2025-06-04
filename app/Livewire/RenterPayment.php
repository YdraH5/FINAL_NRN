<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class RenterPayment extends Component
{

    public $paymentId;
    public $dueDate;
    public $page ='history';
    public $search = '';
    public $sortDirection = "ASC";
    public $sortColumn = "created_at"; // Default sort column

    public function doSort($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = ($this->sortDirection === 'ASC') ? 'DESC' : 'ASC';
            return;
        }
        $this->sortColumn = $column;
        $this->sortDirection = 'ASC';
    }
    public function render()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->day(25);

        $query = DB::table('payments')
            ->join('due_dates', 'payments.id', '=', 'due_dates.payment_id')
            ->select(
                'payments.id',
                'payments.category',
                'payments.payment_method',
                'payments.status',
                'payments.amount',
                'payments.created_at',
                'due_dates.payment_due_date'
            )
            ->where('payments.user_id', auth()->id())
            ->orderBy($this->sortColumn, $this->sortDirection);

        // Search fields
        $searchFields = [
            'payments.category',
            'payments.payment_method',
            'payments.status',
            'payments.amount',
            'due_dates.payment_due_date',
        ];

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($query) use ($searchFields) {
                foreach ($searchFields as $field) {
                    // Handle amount field separately if it's numeric
                    if ($field === 'payments.amount') {
                        if (is_numeric($this->search)) {
                            $query->orWhere($field, 'like', '%' . $this->search . '%');
                        }
                    } else {
                        $query->orWhere($field, 'like', '%' . $this->search . '%');
                    }
                }
            });
        }

        $payments = $query->get();
        return view('livewire.renter.renter-payment', compact('payments'));
    }
    
}
