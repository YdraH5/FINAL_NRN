<div >
    <!-- Table -->
    <div class="flex justify-between items-center mx-4 my-4">
        <h2 class="text-xl font-semibold text-gray-800">Payment History</h2>
        <div class="relative w-1/2 ml-auto">
            <input id="search-input" wire:model.debounce.300ms.live="search" type="search" placeholder="Search payments..."
                class="no-print w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
            <svg class="no-print absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
            </svg>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th wire:click="doSort('created_at')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            {{ __('Date Paid') }}
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="created_at" />
                        </div>
                    </th>
                    <th wire:click="doSort('category')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            {{ __('Category') }}
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="category" />
                        </div>
                    </th>
                    <th wire:click="doSort('payment_due_date')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            {{ __('Due Date') }}
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="payment_due_date" />
                        </div>
                    </th>
                    <th wire:click="doSort('payment_method')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            {{ __('Payment Method') }}
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="payment_method" />
                        </div>
                    </th>
                    <th wire:click="doSort('status')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            {{ __('Payment Status') }}
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="status" />
                        </div>
                    </th>
                    <th wire:click="doSort('amount')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            {{ __('Amount') }}
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="amount" />
                        </div>
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach($payments as $payment)
                <tr class="hover:bg-indigo-100">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{ Carbon\Carbon::parse($payment->created_at)->format('F j, Y') }}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{ $payment->category }}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                        {{ Carbon\Carbon::parse($payment->payment_due_date)->format('F j, Y') }}
                    </td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{ $payment->payment_method }}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{ $payment->status }}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{ $payment->amount }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
