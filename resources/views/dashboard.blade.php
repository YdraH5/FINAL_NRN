@section('title', 'Dashboard')

@section('content')
<x-app-layout>
 <div class="py-6">
    <div class="min-w-full mx-auto">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="flex flex-col">
          <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
            <h1 class="text-2xl font-semibold text-black">Staff Dashboard</h1>
          </div>

          <section class="text-gray-700 body-font">
            <div class="container px-2 py-2 mx-auto">  <!-- Reduced padding from px-4/py-4 to px-2/py-2 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 xl:grid-cols-4 gap-2 text-center">  <!-- Reduced gap from gap-4 to gap-2 -->
                    @foreach([
                        [
                            'route' => '/admin/users',
                            'icon' => 'user',
                            'count' => \App\Models\User::where('role', 'renter')->count(),
                            'label' => 'Occupants',
                            'color' => 'text-indigo-500'
                        ],
                        ['route' => 'admin/reports', 'icon' => 'report', 'count' => \App\Models\Report::count(), 'label' => 'Complaints', 'color' => 'text-red-500'],
                        ['route' => 'admin/apartment', 'icon' => 'room', 'count' => $vacantRooms, 'label' => 'Vacant Room', 'color' => 'text-green-500'],
                        ['route' => 'admin/reservations', 'icon' => 'reservation', 'count' => \App\Models\Reservation::whereNotNull('user_id')->whereDate('check_in', '>', now())->count(), 'label' => 'Reservations', 'color' => 'text-indigo-500'],
                        // Occupancy Rate Card
                        [
                            'route' => '/admin/apartment',
                            'icon' => 'room',
                            'count' => number_format($occupancyRate, 1) . '%',
                            'label' => 'Occupancy Rate',
                            'color' => 'text-blue-500',
                            'custom_icon' => true
                        ],
                        // Current Month Revenue Card
                        [
                            'route' => '/admin/payments',
                            'icon' => 'payment',
                            'count' => '₱' . number_format($currentMonthRevenue),
                            'label' => "This Month's Revenue",
                            'color' => 'text-green-500',
                            'extra' => '<span class="text-sm ' . ($revenueChange >= 0 ? 'text-green-500' : 'text-red-500') . '">' . 
                                       ($revenueChange >= 0 ? '↑' : '↓') . ' ' . number_format(abs($revenueChange), 1) . '%</span>',
                            'custom_icon' => true
                        ],
                        // Expiring Leases Card
                        [
                            'route' => '/owner/occupants',
                            'icon' => 'reservation',
                            'count' => $expiringLeases,
                            'label' => 'Leases Expiring Soon',
                            'color' => 'text-yellow-500',
                            'custom_icon' => true
                        ]
                    ] as $item)
                        <div class="p-2">  <!-- Reduced padding from p-4 to p-2 -->
                            <a href="{{ $item['route'] }}">
                                <div class="border-2 border-gray-600 px-4 py-6 rounded-lg transform transition duration-500 hover:scale-105 h-full">
                                    @if(!isset($item['custom_icon']))
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="{{ $item['color'] }} w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                                            @switch($item['icon'])
                                                @case('user')
                                                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                                                    <circle cx="9" cy="7" r="4"></circle>
                                                    <path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"></path>
                                                    @break
                                                @case('report')
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                                                    @break
                                                @case('room')
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                    @break
                                                @case('reservation')
                                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                                    @break
                                                @case('payment')
                                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                                    @break
                                            @endswitch
                                        </svg>
                                    @else
                                        <!-- Custom icons for the new cards -->
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="{{ $item['color'] }} w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                                            @if($item['label'] == 'Occupancy Rate')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            @elseif($item['label'] == "This Month's Revenue")
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            @elseif($item['label'] == 'Leases Expiring Soon')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            @endif
                                        </svg>
                                    @endif
                                    <h2 class="title-font font-medium text-3xl text-gray-900">{{ $item['count'] }}</h2>
                                    <p class="leading-relaxed">{{ $item['label'] }}</p>
                                    @if(isset($item['extra']))
                                        {!! $item['extra'] !!}
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
          
          
          <!-- Charts Section -->
          <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 px-4">
            
            <!-- Revenue Comparison Chart -->
            <div class="bg-white p-6 rounded-lg shadow-xl mt-6 mx-4 col-span-2">
                <h2 class="text-xl font-bold mb-4">Revenue Comparison</h2>
                <div class="flex space-x-4 mb-4">
                    <button onclick="showChart('weekly')" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Weekly
                    </button>
                    <button onclick="showChart('monthly')" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                        Monthly
                    </button>
                    <button onclick="showChart('yearly')" class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50">
                        Yearly
                    </button>
                </div>
                <div class="w-full h-96">
                    <canvas id="revenueComparisonChart"></canvas>
                </div>
            </div>
           
            <!-- Payment Collection Pie Chart -->
            <div class="bg-white p-6 pb-6 rounded-lg shadow-xl">
                <h2 class="text-xl font-bold">Payment Collection Status</h2>
                <span class="text-sm font-semibold text-gray-500">{{ now()->year }}</span>
                @php
                    $paidCount = \App\Models\DueDate::where('status', 'paid')->count();
                    $pendingCount = \App\Models\DueDate::where('status', 'pending')->count();
                    $overdueCount = \App\Models\DueDate::where('status', '!=', 'paid')
                        ->where('payment_due_date', '<', \Carbon\Carbon::today())
                        ->count();
                @endphp
                <div class="w-full h-64">
                    <canvas id="paymentChart"></canvas>
                </div>
            </div>
                        <!-- Complaint Status Pie Chart -->
            <div class="bg-white p-6 pb-6 rounded-lg shadow-xl">
                <h2 class="text-xl font-bold">Complaint Status</h2>
                <span class="text-sm font-semibold text-gray-500">{{ now()->year }}</span>
                @php
                    $openComplaints = \App\Models\Report::where('status', 'Pending')->count();
                    $inProgressComplaints = \App\Models\Report::where('status', 'Ongoing')->count();
                    $resolvedComplaints = \App\Models\Report::where('status', 'Fixed')->count();
                @endphp
                <div class="w-full h-64">
                    <canvas id="complaintChart"></canvas>
                </div>
            </div>
             <!-- Leases Expiring Soon Table -->
            <div class="bg-white p-6 rounded-lg shadow-xl mt-6 mx-4">
              <h2 class="text-xl font-bold mb-4">Leases Expiring Soon (Next 30 Days)</h2>
              
              @if($expiringLease->count() > 0)
                  <div class="overflow-x-auto">
                      <table class="min-w-full divide-y divide-gray-200">
                          <thead class="bg-gray-50">
                              <tr>
                                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant</th>
                                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Building</th>
                                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-out Date</th>
                                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days Remaining</th>
                              </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200">
                              @foreach($expiringLease as $lease)
                                  <tr class="hover:bg-gray-50">
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="flex items-center">
                                              <div class="text-sm font-medium text-gray-900">
                                                  {{ $lease->user->name }}
                                              </div>
                                          </div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="text-sm text-gray-900">
                                              {{ $lease->apartment->room_number }}
                                          </div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="text-sm text-gray-900">
                                              {{ $lease->apartment->building->name }}
                                          </div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <div class="text-sm text-gray-900">
                                              {{ \Carbon\Carbon::parse($lease->check_in)->format('M d, Y') }}
                                          </div>
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                              {{ now()->diffInDays($lease->check_in) <= 7 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                              {{ now()->diffInDays($lease->check_in) }} days
                                          </span>
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
              @else
                  <p class="text-gray-500">No leases are expiring in the next 30 days.</p>
              @endif
            </div>
            
            
            <!-- Overdue Payments Table -->
            <div class="bg-white p-6 rounded-lg shadow-xl mt-6 mx-4">
                <h2 class="text-xl font-bold mb-4">Overdue Payments</h2>
                
                @if($overdueRenters->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Building</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Due</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days Overdue</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($overdueRenters as $dueDate)
                                    @php
                                        $daysOverdue = now()->diffInDays($dueDate->payment_due_date);
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $dueDate->user->name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $dueDate->apartment->room_number ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $dueDate->apartment->building->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($dueDate->payment_due_date)->format('M d, Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                ₱{{ number_format($dueDate->amount_due, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                {{ $daysOverdue }} days
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">No overdue payments found.</p>
                @endif
            </div>

            {{-- <!-- Chart Container -->
        <div class="bg-white p-6 rounded-lg shadow-xl my-4">
          <h2 class="text-xl font-bold mb-4">Building Occupancy</h2>
          <div class="w-full h-64">
              <canvas id="buildingOccupancyChart"></canvas>
          </div>
        </div> --}}
        </section>
        
       <!-- Load Chart.js and Render Charts -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
          document.addEventListener("DOMContentLoaded", function () {
          
              // Payment Collection Chart
              const paymentCtx = document.getElementById('paymentChart').getContext('2d');
              new Chart(paymentCtx, {
                  type: 'pie',
                  data: {
                      labels: ['Paid', 'Overdue', 'Pending'],
                      datasets: [{
                          data: [
                              @json($paidPayments),
                              @json($overduePayments),
                              @json($pendingPayments)
                          ],
                          backgroundColor: ['#4CAF50', '#F44336', '#FFC107'],
                          hoverOffset: 5
                      }]
                  },
                  options: { responsive: true, maintainAspectRatio: false }
              });
          
              // Complaint Status Chart
              const complaintCtx = document.getElementById('complaintChart').getContext('2d');
              new Chart(complaintCtx, {
                  type: 'pie',
                  data: {
                      labels: ['Open', 'In Progress', 'Resolved'],
                      datasets: [{
                          data: [
                              @json($openMaintenance),
                              @json($inProgressMaintenance),
                              @json($completedMaintenance)
                          ],
                          backgroundColor: ['#FF6384', '#FFCE56', '#36A2EB'],
                          hoverOffset: 5
                      }]
                  },
                  options: { responsive: true, maintainAspectRatio: false }
              });
          });
          // Revenue Comparison Chart
const revenueCtx = document.getElementById('revenueComparisonChart').getContext('2d');
let revenueChart;

function initRevenueChart(type) {
    let labels, data, label, backgroundColor;
    
    switch(type) {
        case 'weekly':
            labels = @json($weeklyRevenue->pluck('week'));
            data = @json($weeklyRevenue->pluck('total'));
            label = 'Weekly Revenue';
            backgroundColor = 'rgba(54, 162, 235, 0.5)';
            break;
        case 'monthly':
            labels = @json($monthlyRevenue->pluck('month')).map(month => new Date(0, month - 1).toLocaleString('default', { month: 'long' }));
            data = @json($monthlyRevenue->pluck('total'));
            label = 'Monthly Revenue';
            backgroundColor = 'rgba(75, 192, 192, 0.5)';
            break;
        case 'yearly':
            labels = @json($yearlyRevenue->pluck('year'));
            data = @json($yearlyRevenue->pluck('total'));
            label = 'Yearly Revenue';
            backgroundColor = 'rgba(153, 102, 255, 0.5)';
            break;
    }

    if (revenueChart) {
        revenueChart.destroy();
    }

    revenueChart = new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: label,
                data: data,
                backgroundColor: backgroundColor,
                borderColor: backgroundColor.replace('0.5', '1'),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '₱' + context.raw.toLocaleString();
                        }
                    }
                }
            }
        }
    });
}

function showChart(type) {
    initRevenueChart(type);
}

// Initialize with weekly data by default
document.addEventListener("DOMContentLoaded", function() {
    initRevenueChart('weekly');
});
          </script>

        
        
        </div>
      </div>
    </div>
  </div>


  @stop

</x-app-layout>