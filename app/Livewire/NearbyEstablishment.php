<?php

namespace App\Livewire;

use App\Models\Nearby;  // Make sure to import the Nearby model
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
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
    
    public function edit($id)
    {
        $this->isEditing = true;
        $this->id = $id;
        $nearby = Nearby::find($id);
        
        $this->name = $nearby->name;
        $this->description = $nearby->description;
        $this->distance = $nearby->distance;
        $this->image_url = null; // Reset the image upload field
        // Note: Don't set the existing image_url here to avoid overwriting
    }
    
    public function update()
    {
        // Find the record first
        $nearby = Nearby::findOrFail($this->id);

        // Validate with conditional image rule
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'distance' => 'required|numeric|min:0',
            'image_url' => 'nullable|sometimes|image|max:2048', // Make image optional for update
        ]);

        // Prepare update data
        $updateData = [
            'name' => $this->name,
            'description' => $this->description,
            'distance' => $this->distance,
        ];

        // Handle image update if new image is provided
        if ($this->image_url instanceof \Illuminate\Http\UploadedFile) {
            // Delete old image if it exists
            if ($nearby->image_url && Storage::disk('public')->exists($nearby->image_url)) {
                Storage::disk('public')->delete($nearby->image_url);
            }
            
            // Store new image
            $imagePath = $this->image_url->store('uploads/nearby', 'public');
            $updateData['image_url'] = $imagePath;
        }

        // Update the record
        $nearby->update($updateData);

        // Reset editing state
        $this->isEditing = false;
        $this->reset(['name', 'description', 'distance', 'image_url']);

        // Redirect based on role
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.nearby-establishment.index')->with('success', 'Nearby Establishment Updated Successfully');
        } elseif (auth()->user()->role === 'owner') {
            return redirect()->route('owner.nearby-establishment.index')->with('success', 'Nearby Establishment Updated Successfully');
        }
        
        abort(403, 'Unauthorized action.');
    }

    public function delete($id){
        $this->isDeleting = true;
        $this->deleteId = $id;
    }
    public function deleted(){
        $delete = Nearby::find($this->deleteId)->delete();
        if($delete){
            // Redirect based on role
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.nearby-establishment.index')->with('success', 'Nearby Establishment deleted successfully in the system.');
            } elseif (auth()->user()->role === 'owner') {
                return redirect()->route('owner.nearby-establishment.index')->with('success', 'Nearby Establishment deleted successfully in the system.');
            }
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
