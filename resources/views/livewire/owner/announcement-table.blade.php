<div>
  <!-- Search Bar -->
  <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
    <div class=" flex gap-2 text-gray-700">
      <h1 class="text-2xl font-semibold text-black">Announcements Management</h1>
    </div>
    <div class="relative w-1/2 ml-auto">
        <input id="search-input" wire:model.debounce.300ms.live="search" type="search" placeholder="Search..."
            class="w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
        <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
        </svg>
    </div>
    
    <button class="" x-data x-on:click="$dispatch('open-modal',{name:'add-announcement'})"title="add announcement">
        @include('buttons.add')
    </button> 
  </div>
       <!-- Table -->
    <div class="overflow-x-auto bg-white shadow-lg">
        <table class="min-w-full mx-2 border-collapse">
                @if (session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: '{{ session('success') }}',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        });
                    </script>
                @endif
            <thead>
            <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th  class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Audience
                        </div>
                    </th>               
                    <th class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Title
                        </div>
                    </th>  
                    <th class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Content
                        </div>
                    </th>  
                    <th  class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Priority
                        </div>
                    </th>  
                    <th  class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Status
                        </div>
                    </th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Start Date
                        </div>
                    </th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($announcements as $announcement)
                <tr class="hover:bg-indigo-100">
                    @php
                        $category = \App\Models\Category::find($announcement->category);
                    @endphp
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                        {{ $category ? $category->name : 'Unknown Category' }}
                    </td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$announcement->title}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$announcement->content}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$announcement->priority}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$announcement->status}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                    {{\Carbon\Carbon::parse($announcement->start_date)->format('F d, Y')}}
                    </td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                        <button
                            x-data="{ id: {{$announcement->id}} }"
                            x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'edit-announcement' })"
                            title="edit"
                            wire:click="edit(id)"
                            type="button">@include('buttons.edit')
                        </button>
                            @if($isEditing)
<x-modal name="edit-announcement" title="Edit Announcement" max-width="4xl">
    <x-slot:body>
        <!-- Form -->
        <form id="announcementForm" class="space-y-6" wire:submit.prevent="update">
            @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were {{ count($errors) }} errors with your submission</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="space-y-6">
                <!-- First Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Category -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <select wire:model="category" class="mt-1 block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md border">
                            <option value="all">All Categories</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Title -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" wire:model="title" placeholder="Announcement Title" 
                            class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Content -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea wire:model="content" rows="5" placeholder="Announcement Content" 
                        class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    @error('content') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Second Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Priority -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Priority</label>
                        <select wire:model="priority" 
                            class="mt-1 block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md border">
                            <option value="" disabled selected hidden>Select Priority</option>
                            <option value="Low">Minor</option>
                            <option value="High">Urgent</option>
                        </select>
                        @error('priority') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select wire:model="status" 
                            class="mt-1 block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md border">
                            <option value="" disabled selected hidden>Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Start Date -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" wire:model="start_date" 
                            class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('start_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <button x-on:click="$dispatch('close-modal',{name:'edit-announcement'})" type="button" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </button>
                <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save Changes
                </button>
            </div>
        </form>
    </x-slot:body>
</x-modal>
                            @endif
                            @if($isDeleting)
                            <x-modal name="delete-announcement" title="Delete Announcement">
                                <x-slot name="body">
                                    <div class="p-4">
                                        <p class="text-lg font-semibold mb-4">Are you sure you want to delete this announcement?</p>
                                        <p class="text-gray-600 mb-8">This action cannot be undone. Please confirm.</p>
                                        
                                        <div class="flex justify-end">
                                            <button type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-4" x-on:click="$dispatch('close-modal',{name:'delete-apartment'})">Cancel</button>
                                            <button type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded" wire:click="deleted">Delete</button>
                                        </div>
                                    </div>
                                </x-slot>
                            </x-modal>
                        @endif
                        <button
                            x-data="{ id: {{$announcement->id}} }"
                            x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'delete-announcement' })"
                            wire:click="delete(id)"
                            title ="Delete" 
                            type="button"
                            class="my-2">
                            @include('buttons.delete')
                        </button>
                    </td>
                </tr>
                @endforeach  
            </tbody>
        </table>
    </div>
      
</div>
