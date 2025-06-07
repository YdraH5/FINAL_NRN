<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Announcement;

class AnnouncementForm extends Component
{
    public $category;
    public $title;
    public $content;
    public $priority;
    public $status;
    public $start_date;

    public function save()
    {
        $this->validate([
            'category' => 'required',
            'title' => 'required',
            'content' => 'required',
            'priority' => 'required',
            'status' => 'required',
            'start_date' => 'required',
        ]);

        Announcement::create([
            'category' => $this->category,
            'title' => $this->title,
            'content' => $this->content,
            'priority' => $this->priority,
            'status' => $this->status,
            'start_date' => $this->start_date,
        ]);
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.announcement.index')->with('success', 'Posting Announcement Success');
        } elseif (auth()->user()->role === 'owner') {
            return redirect()->route('owner.announcement.index')->with('success', 'Posting Announcement Success');
        } else {
            // Handle if user doesn't have the right role
            abort(403, 'Unauthorized action.');
        }

    }

    public function render()
    {
        $categories = Category::whereNull('deleted_at')->get();

        if (auth()->user()->role === 'admin') {
            return view('livewire.admin.announcement-form', [
                'categories' => $categories,
            ]);
        } elseif (auth()->user()->role === 'owner') {
            return view('livewire.owner.announcement-form', [
                'categories' => $categories,
            ]);
        } else {
            // Handle if user doesn't have the right role
            abort(403, 'Unauthorized action.');
        }
    }
}
