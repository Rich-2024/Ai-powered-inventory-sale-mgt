@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-blue-50 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-blue-900 mb-8 border-b border-blue-300 mt-0 pb-4">Journal Entries</h1>

    <!-- Summary Section -->
    <div id="summary" class="mb-10 p-6 bg-white rounded-lg shadow flex justify-around text-center space-x-6">
        <div>
            <h3 class="text-gray-700 text-xl font-semibold mb-2">Revenue</h3>
            <p class="text-green-600 text-3xl font-extrabold">Ugx{{ number_format($revenue, 2) }}</p>
        </div>
        <div>
            <h3 class="text-gray-700 text-xl font-semibold mb-2">COGS</h3>
            <p class="text-red-600 text-3xl font-extrabold">Ugx: {{ number_format($cogs, 2) }}</p>
        </div>
        <div>
            <h3 class="text-gray-700 text-xl font-semibold mb-2">Cash</h3>
            <p class="text-blue-600 text-3xl font-extrabold">Ugx: {{ number_format($cash, 2) }}</p>
        </div>
        <div>
            <h3 class="text-gray-700 text-xl font-semibold mb-2">Inventory</h3>
            <p class="text-yellow-600 text-3xl font-extrabold">Ugx: {{ number_format($inventory, 2) }}</p>
        </div>
    </div>

    <!-- Journal Entries Listing -->
    @foreach($journalEntries as $date => $entries)
        <div class="mb-8 bg-white rounded-lg shadow-sm border border-blue-200">
            <div class="p-4 bg-blue-100 rounded-t-lg flex justify-between items-center">
                <div>
                    <p class="text-blue-900 font-semibold text-lg">📅 {{ $date }}</p>
                </div>
            </div>

            @foreach($entries as $entry)
                <div class="border-t border-blue-200 p-4">
                    <div class="mb-3 flex justify-between items-center">
                        <div>
                            <p class="text-blue-800 font-semibold">Ref: {{ $entry->reference }}</p>
                            <p class="text-blue-600 italic">{{ $entry->description }}</p>
                        </div>
                        <div>
                            {{-- <span class="text-sm text-blue-600 font-medium">Admin ID: {{ $entry->admin_id }}</span> --}}
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="text-blue-700 bg-blue-50 border-b border-blue-300">
                                <tr>
                                    <th class="py-2 px-3">Account</th>
                                    <th class="py-2 px-3 text-green-700 text-right">Debit</th>
                                    <th class="py-2 px-3 text-red-700 text-right">Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($entry->journalLines as $line)
                                    <tr class="border-b border-blue-100 hover:bg-blue-50 transition-colors duration-150">
                                        <td class="py-2 px-3">{{ $line->account->name ?? 'Unknown' }}</td>
                                        <td class="py-2 px-3 text-green-700 text-right">Ugx: {{ number_format($line->debit, 2) }}</td>
                                        <td class="py-2 px-3 text-red-700 text-right">Ugx: {{ number_format($line->credit, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection
