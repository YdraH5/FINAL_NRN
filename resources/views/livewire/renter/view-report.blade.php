<div>
    <!-- Flex container for the entire content -->
    <div class="w-full bg-gray-100 px-2 rounded-lg p-6 shadow-md">
        @if (session('success'))
        <div class="text-green-800">
            {{ session('success') }}
        </div>
        @endif
        @if (session('failed'))
        <div class="text-red-900">
            {{ session('failed') }}
        </div>
        @endif
        <div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold text-gray-800">Reports</h2>
    <div class="relative w-1/2 ml-auto">
        <input id="search-reports-input" wire:model.debounce.300ms.live="search" type="search" placeholder="Search reports..."
            class="no-print w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
        <svg class="no-print absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
        </svg>
    </div>
</div>

    <table class="min-w-full border-collapse">
        <thead>
            <tr class="bg-indigo-500 text-white uppercase text-sm">
                <th wire:click="doSort('id')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                    <div class="inline-flex items-center justify-center">
                        Report ID
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="id" />
                    </div>
                </th>
                <th wire:click="doSort('report_category')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                    <div class="inline-flex items-center justify-center">
                        Category
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="report_category" />
                    </div>
                </th>
                <th wire:click="doSort('created_at')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                    <div class="inline-flex items-center justify-center">
                        Date Submitted
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="created_at" />
                    </div>
                </th>
                <th wire:click="doSort('description')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                    <div class="inline-flex items-center justify-center">
                        Description
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="description" />
                    </div>
                </th>
                <th wire:click="doSort('status')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                    <div class="inline-flex items-center justify-center">
                        Status
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="status" />
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr class="hover:bg-indigo-100">
                <td class="py-3 px-4 text-center border-b border-gray-300">{{$report->id}}</td>
                <td class="py-3 px-4 text-center border-b border-gray-300">{{$report->report_category}}</td>
                <td class="py-3 px-4 text-center border-b border-gray-300">{{ \Carbon\Carbon::parse($report->created_at)->diffForHumans() }}</td>
                <td class="py-3 px-4 text-center border-b border-gray-300">{{$report->description}}</td>
                <td class="py-3 px-4 text-center border-b border-gray-300">{{$report->status}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
