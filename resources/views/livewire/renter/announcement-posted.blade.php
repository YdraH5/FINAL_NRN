<div class="container mx-auto p-4">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Latest Announcements</h1>
        
        <!-- Search Box -->
        <div class="relative w-full md:w-1/3">
            <input 
                wire:model.live.debounce.300ms="search" 
                type="search" 
                placeholder="Search by title, content or priority..."
                class="w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
            >
            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
            </svg>
        </div>
    </div>

    @if($announcements->isEmpty())
        <p class="text-gray-500 text-center py-8">
            @if($this->search)
                No announcements found matching "{{ $this->search }}"
            @else
                No announcements available at the moment.
            @endif
        </p>
    @else
        <div class="space-y-6">
            @foreach($announcements as $announcement)
                <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 hover:text-indigo-600 transition">
                                {{ $announcement->title }}
                            </h2>
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-gray-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($announcement->created_at)->diffForHumans() }}
                                </span>
                                @if($announcement->priority === 'High')
                                    <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full">Urgent</span>
                                @else
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">Normal</span>
                                @endif
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-500 mt-2">
                            Posted on {{ \Carbon\Carbon::parse($announcement->start_date)->format('F j, Y') }}
                        </p>
                        
                        <p class="text-gray-700 mt-3">
                            {{ Str::limit($announcement->content, 200, '...') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>