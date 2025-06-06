<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Nearby;
class NearbyForm extends Component
{
    use WithFileUploads;

    public $name, $description, $distance, $image;

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'distance' => 'required|numeric|min:0',
            'image' => 'required|image|', // Image validation rules
        ]);
        
        $imagePath = $this->image->store('uploads/nearby', 'public');
        $this->image_url = $imagePath; // Store path correctly
        
        Nearby::create([
            'name' => $this->name,
            'description' => $this->description,
            'distance' => $this->distance,
            'image_url' => $imagePath,
        ]);
                
        if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.nearby-establishment.index')->with('success', 'Uploading Nearby Establishment Success');

        } elseif (auth()->user()->role === 'owner') {
        return redirect()->route('owner.nearby-establishment.index')->with('success', 'Uploading Nearby Establishment Success');

        } else {
            // Handle if user doesn't have the right role
            abort(403, 'Unauthorized action.');
        }

    }
    public function render()
    {
        
        if (auth()->user()->role === 'admin') {
            return view('livewire.admin.nearby-form');

        } elseif (auth()->user()->role === 'owner') {
            return view('livewire.owner.nearby-form');

        } else {
            // Handle if user doesn't have the right role
            abort(403, 'Unauthorized action.');
        }
    }
}
