<?php

namespace App\Livewire;
use Livewire\Attributes\Validate; 
use App\Models\Report;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
class ViewReport extends Component
{
    use WithPagination;
    public $isViewing= false;
    public $id;
    public $viewReport;
    public $sortDirection = "DESC"; // Default to newest first
    public $sortColumn = "created_at";
    public $search = '';
    #[Validate('required|min:5|max:50')] 
    public $status;

    #[Validate('required|max:50')] 
    public $ticket;

    #[Validate('required|max:150')] 
    public $description;

    #[Validate('required')] 
    public $date;

    #[Validate('required')] 
    public $report_category;
    public function view($id){
        $this->isViewing= true;
        $this->id = $id;
        $this->viewReport = Report::find($id);
        $this->report_category = $this->viewReport->report_category;
        $this->status = $this->viewReport->status;
        $this->ticket = $this->viewReport->ticket;
        $this->description = $this->viewReport->description;
        $this->date = $this->viewReport->created_at;
    }


    public function render()
    {
        $user = auth()->user();
        
        $query = Report::where('user_id', $user->id);
        
        // Apply search
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('id', 'like', '%'.$this->search.'%')
                  ->orWhere('report_category', 'like', '%'.$this->search.'%')
                  ->orWhere('description', 'like', '%'.$this->search.'%')
                  ->orWhere('status', 'like', '%'.$this->search.'%')
                  ->orWhere('created_at', 'like', '%'.$this->search.'%');
            });
        }
        
        // Apply sorting
        $query->orderBy($this->sortColumn, $this->sortDirection);
        
        $reports = $query->get();
        
        return view('livewire.renter.view-report', [
            'reports' => $reports
        ]);
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
}
