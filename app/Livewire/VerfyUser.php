<?php

namespace App\Livewire;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class VerfyUser extends Component
{
    use WithPagination;
    public $search;
    public $sortDirection="ASC";
    public $sortColumn ="name";
    public $perPage = 10;

    public function doSort($column){
        if($this->sortColumn === $column){
            $this->sortDirection = ($this->sortDirection === 'ASC')? 'DESC':'ASC';
            return;
        }
        $this->sortColumn = $column;
        $this->sortDirection = 'ASC';
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when search input is updated
    }
public function verifyUser($userId)
{
    try {
        $user = User::findOrFail($userId);
        $user->forceFill([
            'email_verified_at' => now()
        ])->save();
        
        session()->flash('success', 'User email verified successfully!');
        
        // For Livewire 3
        $this->dispatch('user-verified');
        
        // Optional: If you want immediate UI update
        $this->js('window.location.reload()'); 
        
    } catch (\Exception $e) {
        session()->flash('error', 'Error: '.$e->getMessage());
    }
}
    public function render()
    {
        $user = User::select(
            'name',
            'id',
            'email',
            'role',
            'email_verified_at',
            DB::raw('DATE_FORMAT(created_at, "%b-%d-%Y") as date')
        )
        ->whereNull('email_verified_at')  // Only show unverified users
        ->orderBy($this->sortColumn, $this->sortDirection);

        if ($this->search) {
            $user->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('role', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            });
        }

        $users = $user->paginate($this->perPage);
        
        return view('livewire.owner.verfy-user', [
            'users' => $users
        ]);
    }
}
