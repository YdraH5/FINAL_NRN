<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Announcement;
use App\Models\Category;

class AnnouncementTable extends Component
{
    public $id;
    public $isDeleting = false;
    public $deleteId,$isEditing,$editAnnouncement,$category,$title,$content,$priority,$status,$start_date;
    public function delete($id){
        $this->isDeleting = true;
        $this->deleteId = $id;
    }
    public function deleted(){
        $delete = Announcement::find($this->deleteId)->delete();
        if($delete){
            // Reset the component state
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.announcement.index')->with('success', 'Announcement deleted successfully.');  

            } elseif (auth()->user()->role === 'owner') {
                return redirect()->route('owner.announcement.index')->with('success', 'Announcement deleted successfully.');  
            } else {
                // Handle if user doesn't have the right role
                abort(403, 'Unauthorized action.');
            }
        }
        $this->isDeleting = false;
    }
    public function edit($id){
        $this->isEditing = true;
        $this->id = $id;
        // to set the value of current data to the public variables
        $editAnnouncement = Announcement::find($id);
          // Assign the announcement's data to the component's public properties
        $this->category = $editAnnouncement->category;
        $this->title = $editAnnouncement->title;
        $this->content = $editAnnouncement->content;
        $this->priority = $editAnnouncement->priority;
        $this->status = $editAnnouncement->status;
        $this->start_date = $editAnnouncement->start_date; // If applicable
    }
   
    public function update(){
              
        $this->validate([
            'category' => 'required',
            'title' => 'required',
            'content' => 'required',
            'priority' => 'required',
            'status' => 'required', 
            'start_date' => 'required', 
        ]);
        $announcement = Announcement::find($this->id);
        $announcement->update([
            'category' => $this->category,
            'title' => $this->title,
            'content' => $this->content,
            'priority' => $this->priority,
            'status' => $this->status,
            'start_date' => $this->start_date,
        ]);

        $this->isEditing = false;
        $this->reset();
        // Reset the component state
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.announcement.index')->with('success', 'Announcement updated successfully.');  

        } elseif (auth()->user()->role === 'owner') {
            return redirect()->route('owner.announcement.index')->with('success', 'Announcement updated successfully.');  
        } else {
            // Handle if user doesn't have the right role
            abort(403, 'Unauthorized action.');
        }
    }

    public function render()
    {
        $categories = Category::whereNull('deleted_at')->get();
        $announcements = Announcement::whereNull('deleted_at')->get();

                 // Conditionally render the correct view based on user role
        if (auth()->user()->role === 'admin') {
            return view('livewire.admin.announcement-table', [
                'announcements' => $announcements,
                'categories' => $categories,
            ]);
        } elseif (auth()->user()->role === 'owner') {
            return view('livewire.owner.announcement-table', [
                'announcements' => $announcements,
                'categories' => $categories,
            ]);
        } else {
            // Handle if user doesn't have the right role
            abort(403, 'Unauthorized action.');
        }
    }
}
