<?php

namespace App\Livewire;

use App\Models\Nearby;  // Make sure to import the Nearby model
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class NearbyEstablishment extends Component
{
    use WithPagination;
    use WithFileUploads; // Include the WithFileUploads trait

    public $search,$id,$deleteId,$name,$description,$distance,$image_url;
    public $isDeleting = false;
    public $sortDirection = "ASC";
    public $sortColumn = "name";
    public $perPage = 10;

    public $isEditing = false;
    public function edit($id){
        $this->isEditing = true;
        $this->id = $id;
        // to set the value of current data to the public variables
        $nearby = Nearby::find($id);
          // Assign the announcement's data to the component's public properties
        $this->name = $nearby->name;
        $this->description = $nearby->description;
        $this->distance = $nearby->distance;
        $this->image_url = $nearby->image_url;
    }
   
    public function update()
    {
        // Validate inputs
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'distance' => 'required|numeric',
            'image_url' => ($this->image_url instanceof \Illuminate\Http\UploadedFile) 
                ? 'required|image|max:2048' 
                : 'nullable',
        ]);

        // Find the existing record
        $nearby = Nearby::find($this->id);

        $updateData = [
            'name' => $this->name,
            'description' => $this->description,
            'distance' => $this->distance,
        ];

        // Only update image if a new one was provided
        if ($this->image_url instanceof \Illuminate\Http\UploadedFile) {
            // Delete old image if it exists
            if ($nearby->image_url && Storage::disk('public')->exists($nearby->image_url)) {
                Storage::disk('public')->delete($nearby->image_url);
            }
            
            $imagePath = $this->image_url->store('uploads/nearby', 'public');
            $updateData['image_url'] = $imagePath;
        }

        // Update the record
        $nearby->update($updateData);

        // Reset the form and state
        $this->isEditing = false;
        $this->reset();

        // Flash success message
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.nearby-establishment.index')->with('success', 'Nearby establishment updated successfully.');

        } elseif (auth()->user()->role === 'owner') {
            return redirect()->route('owner.nearby-establishment.index')->with('success', 'Nearby establishment updated successfully.');

        } else {
            // Handle if user doesn't have the right role
            abort(403, 'Unauthorized action.');
        }
    }
    

    public function delete($id){
        $this->isDeleting = true;
        $this->deleteId = $id;
    }
    public function deleted(){
        $delete = Nearby::find($this->deleteId)->delete();
        if($delete){
            session()->flash('success', 'Nearby Establishment deleted successfully in the system.');
            $this->reset();
        }
        $this->isDeleting = false;
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

    public function render()
    {
        $nearbyEstablishments = Nearby::select(
            'id',
            'name',
            'description',
            'distance',
            'image_url',
            DB::raw('DATE_FORMAT(created_at, "%b-%d-%Y") as date')
        )->orderBy($this->sortColumn, $this->sortDirection);

        if ($this->search) {
            $nearbyEstablishments->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->orWhere('distance', 'like', '%' . $this->search . '%')
                ->orWhere('created_at', 'like', '%' . $this->search . '%');
        }

        $nearbyEstablishments = $nearbyEstablishments->paginate($this->perPage);
        
        // Conditionally render the correct view based on user role

        if (auth()->user()->role === 'admin') {
            return view('livewire.admin.nearby-establishment', [
                'nearbyEstablishments' => $nearbyEstablishments
            ]);
        } elseif (auth()->user()->role === 'owner') {
            return view('livewire.owner.nearby-establishment', [
                'nearbyEstablishments' => $nearbyEstablishments
            ]);
        } else {
            // Handle if user doesn't have the right role
            abort(403, 'Unauthorized action.');
        }
    }
}
