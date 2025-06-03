@section('title', 'Activity Logs')

<x-owner-layout>
@section('content')
<section class="text-gray-700 body-font mx-4 mt-6">
    @php
    $logTypes = [
        'apartment' => 'Apartments',
        'reservation' => 'Reservations',
        'building' => 'Buildings',
        'payment' => 'Payments',
        'report' => 'Reports',
        'Announcement' => 'Announcements',
    ];
    
    $recentActivities = Spatie\Activitylog\Models\Activity::with(['subject'])
        ->when(request('log_name'), function($query) {
            return $query->where('log_name', request('log_name'));
        })
        ->latest()
        ->paginate(20)
        ->appends(request()->query());
    @endphp
    
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Recent Activities</h2>
        
        <!-- Filter dropdown -->
        <div class="relative">
            <form method="GET" action="">
                <select name="log_name" onchange="this.form.submit()" 
                    class="block appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-indigo-500">
                    <option value="">All Activity Types</option>
                    @foreach($logTypes as $key => $label)
                        <option value="{{ $key }}" {{ request('log_name') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </form>
        </div>
    </div>

    <div class="mb-2">
        {{ $recentActivities->links()}}
    </div>
    
    <!-- Rest of your existing content remains exactly the same -->
    <div class="bg-white p-4 rounded-lg shadow-lg">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
            @forelse($recentActivities as $activity)
                @php
                    // Decode the properties from the activity log
                    $properties = json_decode($activity->properties, true);
                    $activityData = [];
                    $subject = $activity->subject;

                    // Switch case for different activity log types
                    switch ($activity->log_name) {
                        case 'apartment':
                            $apartment = \App\Models\Appartment::withTrashed()->find($activity->subject_id);
                            $user = \App\Models\User::find($activity->subject_id);
                            if ($apartment) {
                                $buildingName = \App\Models\Building::find($apartment->building_id)->name ?? 'N/A';
                                $activityData = [
                                    'Building Name' => $buildingName,
                                    'Room Number' => $apartment->room_number,
                                    'Renter' => $user->name ?? 'N/A',
                                    'Status' => $apartment->status,
                                ];
                            }
                            break;
                        case 'reservation':
                            $reservation = \App\Models\Reservation::withTrashed()->find($activity->subject_id);
                            if ($reservation) {
                                $user = \App\Models\User::find($reservation->user_id);
                                $apartment = \App\Models\Appartment::find($reservation->apartment_id);
                                $activityData = [
                                    'Apartment' => $apartment ? 'Room '.$apartment->room_number : 'N/A',
                                    'Customer' => $user ? $user->name : 'N/A',
                                    'Check-in Date' => Carbon\Carbon::parse($reservation->check_in)->format('F j, Y'),
                                    'Rental Period' => $reservation->rental_period.' months',
                                    'Occupants' => $reservation->occupants,
                                    'Status' => $reservation->status,
                                ];
                            }
                            break;
                        case 'building':
                            $building = \App\Models\Building::withTrashed()->find($activity->subject_id);
                            if ($building) {
                                $activityData = [
                                    'Building Name' => $building->name,
                                    'Units' => $building->units,
                                    'Parking Space' => $building->parking_space ? 'Yes' : 'No',
                                ];
                            }
                            break;
                        case 'payment':
                            $payment = \App\Models\Payment::withTrashed()->find($activity->subject_id);
                            if ($payment) {
                                $user = \App\Models\User::find($payment->user_id);
                                $apartment = \App\Models\Appartment::find($payment->apartment_id);
                                $activityData = [
                                    'User' => $user ? $user->name : 'N/A',
                                    'Apartment' => $apartment ? 'Room '.$apartment->room_number : 'N/A',
                                    'Amount' => '₱' . number_format($payment->amount, 2),
                                    'Payment Method' => ucfirst($payment->payment_method),
                                    'Payment Category' => $payment->category,
                                    'Status' => $payment->status,
                                ];
                            }
                            break;
                        case 'report':
                            $report = \App\Models\Report::withTrashed()->find($activity->subject_id);
                            if ($report) {
                                $user = \App\Models\User::find($report->user_id);
                                $activityData = [
                                    'Category' => ucfirst($report->report_category),
                                    'Description' => $report->description,
                                    'User' => $user ? $user->name : 'N/A',
                                    'Status' => $report->status,
                                ];
                            }
                            break;
                        case 'Announcement':
                            $announcement = \App\Models\Announcement::withTrashed()->find($activity->subject_id);
                            if ($announcement) {
                                $activityData = [
                                    'Title' => $announcement->title,
                                    'Content' => Str::limit($announcement->content, 50),
                                    'Priority' => $announcement->priority,
                                    'Status' => $announcement->status,
                                    'Start Date' => Carbon\Carbon::parse($announcement->start_date)->format('F j, Y'),
                                ];
                            }
                            break;
                    }
                @endphp

                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                @switch($activity->log_name)
                                    @case('apartment')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                        @break
                                    @case('reservation')
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                        @break
                                    @case('building')
                                        <path d="M5 21v-8h14v8m0 0v2H5v-2m6-10h2M8 5h8m-4 0v6"></path>
                                        @break
                                    @case('payment')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        @break
                                    @case('report')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                                        @break
                                    @case('Announcement')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
                                        @break
                                @endswitch
                            </svg>
                            <div class="text-lg font-semibold text-gray-900">{{ ucfirst($activity->log_name) }}</div>
                        </div>
                        <div class="text-sm text-gray-500">{{ $activity->created_at->diffForHumans() }}</div>
                    </div>

                    <div class="mb-4">
                        @if($activity->event === 'deleted')
                            <span class="text-red-500">Deleted</span> 
                        @elseif($activity->event === 'updated')
                            <span class="text-yellow-500">Updated</span> 
                        @elseif($activity->event === 'created')
                            <span class="text-green-500">Created</span> 
                        @else
                            {{ $activity->description }}
                        @endif
                    </div>

                    {{-- Activity details --}}
                    <div class="space-y-2 text-sm text-gray-700">
                        @foreach($activityData as $key => $value)
                            <div class="flex justify-between">
                                <span class="font-medium">{{ $key }}:</span>
                                <span>{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-gray-500">No activity logs found.</div>
            @endforelse
        </div>
    </div>
</section>
@endsection
</x-owner-layout>