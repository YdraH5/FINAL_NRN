<div>
    <!-- Search Bar -->
    <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm no-print">
        <div class="flex gap-2 text-gray-700">
            <h1 class="no-print text-2xl font-semibold text-black">Reservations Report</h1>
        </div>
        <div class="relative w-1/2 ml-auto">
            <input id="search-input" wire:model.debounce.300ms.live="search" type="search" placeholder="Search..."
                class="no-print w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
            <svg class="no-print absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
            </svg>
        </div>
        <button onclick="window.print()" class="no-print bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Print Report
        </button>
    </div>

    <!-- Print-Only Section -->
    <div class="print-only bg-white p-6 rounded-lg shadow-md mb-6">
    <!-- Logo and Title -->
    <div class="flex items-center justify-between mb-4">
        <img src="{{ asset('images/NRN LOGO.png') }}" class="h-16">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-800">Monthly Reservation Report</h1>
            <p class="text-gray-600 text-sm">For: {{ date('F Y') }}</p>
            <p class="text-gray-600 text-sm">Generated on: {{ date('F d, Y') }}</p>
        </div>
    </div>

    <h2 class="text-xl font-semibold mb-6 text-indigo-600">Monthly Reservation Summary</h2>
    
    @php
        // Filter reservations for current month
        $currentMonthReservations = $reservations->filter(function ($reservation) {
            return \Carbon\Carbon::parse($reservation->check_in)->isCurrentMonth() && 
                   \Carbon\Carbon::parse($reservation->check_in)->isCurrentYear();
        });
        
        // Calculate monthly counts
        $monthlyTotal = $currentMonthReservations->count();
        $monthlyApproved = $currentMonthReservations->where('reservation_status', 'approved')->count();
        $monthlyPending = $currentMonthReservations->where('reservation_status', 'pending')->count();
        $monthlyRejected = $currentMonthReservations->where('reservation_status', 'rejected')->count();
    @endphp
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-green-100 p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-green-600">Received</h3>
            <p class="text-4xl font-bold">{{ $totalReservations }}</p>
        </div>
        <div class="bg-green-100 p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-green-600">Approved</h3>
            <p class="text-4xl font-bold">{{ $monthlyApproved }}</p>
        </div>
        <div class="bg-yellow-100 p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-yellow-600">Pending</h3>
            <p class="text-4xl font-bold">{{ $monthlyPending }}</p>
        </div>
        <div class="bg-red-100 p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-red-600">Rejected</h3>
            <p class="text-4xl font-bold">{{ $rejectedCount }}</p>
        </div>
    </div>


        <!-- Prepared By Section -->
        <div class="mt-10 border-t pt-4">
            <p class="text-gray-700 font-medium">Prepared by: <span class="font-bold">{{ auth()->user()->name }}</span></p>
            <p class="text-gray-600 text-sm">Position: {{ auth()->user()->role }}</p>
        </div>
    </div>
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
    <!-- Table Section -->
    <div class="print-only overflow-x-auto bg-white shadow-lg">
        <table class="min-w-full mx-2 border-collapse">
            <thead>
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th wire:click="doSort('user_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Name
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="user_name" />
                        </div>
                    </th>
                    <th wire:click="doSort('email')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Email
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="email" />
                        </div>
                    </th>
                    <th wire:click="doSort('building_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Room Info
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="building_name" />
                        </div>
                    </th>
                    <th wire:click="doSort('check_in')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Check In
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="check_in" />
                        </div>
                    </th>
                    <th wire:click="doSort('rental_period')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Rental Period
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="rental_period" />
                        </div>
                    </th>
                    <th wire:click="doSort('total_price')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Total Amount
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="total_price" />
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
        
                @foreach($reservations->filter(function ($reservation) {
                    return \Carbon\Carbon::parse($reservation->created_at)->isCurrentMonth() && 
                           \Carbon\Carbon::parse($reservation->created_at)->isCurrentYear();
                }) as $reservation)
                    <tr class="hover:bg-indigo-100">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->user_name}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->email}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->building_name}}-{{$reservation->room_number}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->check_in_date}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->rental_period}} Months</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->reservation_status}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Table Section -->
    <div class="no-print overflow-x-auto bg-white shadow-lg">
        <table class="min-w-full mx-2 border-collapse">
            <thead>
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th wire:click="doSort('user_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Name
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="user_name" />
                        </div>
                    </th>
                    <th wire:click="doSort('email')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Email
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="email" />
                        </div>
                    </th>
                    <th wire:click="doSort('building_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Room Info
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="building_name" />
                        </div>
                    </th>
                    <th wire:click="doSort('check_in')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Visit Date
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="check_in" />
                        </div>
                    </th>
                    <th wire:click="doSort('rental_period')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Rental Period
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="rental_period" />
                        </div>
                    </th>
                    <th wire:click="doSort('reservation_status')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                             Status
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="reservation_status" />
                        </div>
                    </th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                <tr class="hover:bg-indigo-100">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->user_name}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->email}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->building_name}}-{{$reservation->room_number}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->check_in_date}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->rental_period}} Months</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$reservation->reservation_status}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                        @if($reservation->reservation_status !== 'Approved')
                        <button 
                            x-data="{ id: {{$reservation->reservation_id}} }"
                            x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'approve-reservation' })"
                            wire:click="approve(id)"
                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm"
                        >
                            Approve
                        </button>
                                                <!-- Reject Button -->
                        <button 
                            x-data="{ id: {{$reservation->reservation_id}} }"
                            x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'reject-reservation' })"
                            wire:click="reject(id)"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm"
                        >
                            Reject
                        </button>

                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="no-print py-4">
        <div class="flex items-center mb-3">
                    <label for="perPage" class="no-print mr-2 mt-2 text-sm font-medium text-gray-700">Per Page:</label>
                    <select id="perPage" wire:model.live="perPage" class="no-print border border-gray-300 rounded px-2 py-1 h-8 w-20 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="" disabled selected>Select</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                </div>
        <div class="mt-4">
            {{ $reservations->links() }}
        </div>
    </div>

    <!-- Reject Confirmation Modal -->
    <x-modal name="reject-reservation" title="Confirm Rejection">
        <x-slot name="body">
            <div class="p-6">
                <div class="flex justify-center mb-4">
                    <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-center mb-2">Reject this reservation?</h3>
                <p class="text-gray-600 text-center mb-6">The tenant will be notified of the rejection.</p>
                <div class="flex justify-end space-x-3">
                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-md"
                        x-on:click="$dispatch('close-modal',{name:'reject-reservation'})">
                        Cancel
                    </button>
                    <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-md"
                        wire:click="rejected">
                        Confirm Rejection
                    </button>
                </div>
            </div>
        </x-slot>
    </x-modal>
    @if ($isApprove)
    <!-- Modal for approving reservation -->
    <x-modal name="approve-reservation" title="Approve Reservation">
        <x-slot name="body">
            <div class="p-6">
                
                <!-- Confirmation message -->
                <h3 class="text-lg font-semibold text-center text-gray-800 mb-2">Confirm Reservation Approval</h3>
                <p class="text-gray-600 text-center mb-6">This will mark the apartment as reserved and notify the tenant.</p>
                
                <!-- Action buttons -->
                <div class="flex justify-end space-x-3">
                    <button 
                        type="button" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition"
                        x-on:click="$dispatch('close-modal',{name:'approve-reservation'})"
                    >
                        Cancel
                    </button>
                    <button 
                        type="button" 
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition"
                        wire:click="approved"
                    >
                        Confirm Approval
                    </button>
                </div>
            </div>
        </x-slot>
    </x-modal>
    @endif
</div>