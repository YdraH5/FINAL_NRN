<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Announcement;
use App\Models\Appartment;

class AnnouncementPosted extends Component
{
    public $search = '';

    public function render()
    {
        // Find the apartment based on the logged-in user's ID
        $currentApartment = Appartment::where('renter_id', auth()->id())->first(); 
        
        if (!$currentApartment) {
            return view('livewire.renter.announcement-posted', [
                'announcements' => collect(),
            ]);
        }

        // Base query with status and category filtering
        $announcementsQuery = Announcement::where('status', 'active')
            ->where(function($query) use ($currentApartment) {
                $query->where('category', $currentApartment->category_id)
                      ->orWhere('category', 'all');
            });

        // Apply search filter if search term exists
        if ($this->search) {
            $searchTerm = '%'.strtolower($this->search).'%';
            $announcementsQuery->where(function($query) use ($searchTerm) {
                $query->whereRaw('LOWER(title) LIKE ?', [$searchTerm])
                      ->orWhereRaw('LOWER(content) LIKE ?', [$searchTerm])
                      ->orWhereRaw('LOWER(priority) LIKE ?', [$searchTerm]);
            });
        }

        // Final query with ordering
        $announcements = $announcementsQuery
            ->orderBy('start_date', 'desc')
            ->get();

        return view('livewire.renter.announcement-posted', [
            'announcements' => $announcements
        ]);
    }

    
}
