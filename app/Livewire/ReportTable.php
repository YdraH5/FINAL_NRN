<?php

namespace App\Livewire;
use App\Models\Report;
use Livewire\Component;
use Livewire\Attributes\Validate; 
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ReportTable extends Component
{
    use WithPagination;

    public $search = "";
    public Report $selectedReport;

    #[Validate('required|min:5|max:50')] 
    public $status = '';
    public $id;
    public $sortDirection="ASC";
    public $sortColumn ="name";
    public $perPage = 10;
    public $deleteId;
    public $isDeleting = false;
    public function delete($id){
        $this->isDeleting = true;
        $this->deleteId = $id;
    }
    // public function deleted(){
    //     $delete = Category::find($this->deleteId)->delete();
    //     if($delete){
    //         $this->reset();
    //         return redirect()->route('owner.categories.index')->with('success','Category deleted successfully.');
    //     }
    //     $this->isDeleting=false;
    // }
    public function deleted(){
        try {
            $report = Report::findOrFail($this->id);
            $report->delete();
            
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.reports.index')->with('success', 'Report deleted successfully');
            } elseif (auth()->user()->role === 'owner') {
                return redirect()->route('owner.reports.index')->with('success', 'Report deleted successfully');
            }
        } catch (\Exception $e) {
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.reports.index')->with('error', 'Failed to delete report');
            } elseif (auth()->user()->role === 'owner') {
                return redirect()->route('owner.reports.index')->with('error', 'Failed to delete report');
            }
        }
    }
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
    public function edit($id){
        $this->id = $id;
    }
    public function action()
    {
        $this->validate([
            'status' => 'required|min:5|max:50',
        ]);
        $update = DB::table('reports')
                    ->where('id', $this->id)
                    ->update(['status' => $this->status]);
                $this->reset(); // Reset the component if the update was successful
                if (auth()->user()->role === 'admin') {
                    return redirect()->route('admin.reports.index')->with('success', 'Report Action submitted successfully');

                } elseif (auth()->user()->role === 'owner') {
                    return redirect()->route('owner.reports.index')->with('success', 'Report Action submitted successfully');

                } else {
                    // Handle if user doesn't have the right role
                    abort(403, 'Unauthorized action.');
                }
                           
    }
    public function render()
    {
        $query = DB::table('reports')
            ->leftJoin('users', 'users.id', '=', 'reports.user_id')
            ->leftJoin('apartment', 'apartment.renter_id', '=', 'reports.user_id')
            ->leftjoin('buildings','buildings.id', '=', 'apartment.building_id')
            ->select(
                'users.name',
                'reports.id',
                'reports.report_category',
                'buildings.name as building_name',
                'reports.description',
                'reports.is_anonymous',
                'reports.status',
                'apartment.room_number',
                'reports.created_at as date'
            )
            ->whereNull('reports.deleted_at')
            ->orderByRaw("CASE WHEN reports.status = 'Solved' THEN 1 ELSE 0 END")
            ->orderBy($this->sortColumn, $this->sortDirection);
        // Filter based on the search search
        if (!empty($this->search)) {
            $query->where('users.name', 'like', '%' . $this->search . '%')
                ->orWhere('reports.report_category', 'like', '%' . $this->search . '%')
                ->orWhere('reports.description', 'like', '%' . $this->search . '%')
                ->orWhere('reports.status', 'like', '%' . $this->search . '%')
                ->orWhere('buildings.name', 'like', '%' . $this->search . '%')
                ->orWhere('reports.created_at', 'like', '%' . $this->search . '%')
                ->orWhere('apartment.room_number', 'like', '%' . $this->search . '%');
                
        }

        $reports = $query->paginate($this->perPage);

        if (auth()->user()->role === 'admin') {
            return view('livewire.admin.report-table', compact('reports'));

        } elseif (auth()->user()->role === 'owner') {
            return view('livewire.owner.report-table', compact('reports'));

        } else {
            // Handle if user doesn't have the right role
            abort(403, 'Unauthorized action.');
        }
    }
}
