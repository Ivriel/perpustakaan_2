{{-- Halaman daftar peminjaman user --}}
{{-- Data dari controller: $loans --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Daftar Peminjaman Saya
            </h2>
            <a href="{{ route('loans.cart') }}"
                class="px-4 py-2 bg-indigo-600 text-white text-sm font-bold rounded hover:bg-indigo-700">
                Keranjang
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                @forelse ($loans as $loan)
                    {{-- @forelse = foreach, tapi ada @empty kalau kosong --}}
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 last:border-0">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <span class="font-bold text-gray-900 dark:text-white">
                                    #{{ $loan->id }} — {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}
                                </span>
                                <span class="ml-2 px-2 py-0.5 text-xs rounded
                                            @if($loan->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400
                                            @elseif($loan->status === 'borrowed') bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400
                                            @elseif($loan->status === 'returned') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400
                                            @else bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400
                                            @endif">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </div>
                            <span class="text-sm text-gray-500">Jatuh tempo:
                                {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}</span>
                        </div>
                        {{-- $loan->details = relasi ke loan_details, ->book = relasi ke books --}}
                        <ul class="text-sm text-gray-600 dark:text-gray-400 list-disc list-inside">
                            @foreach ($loan->details as $detail)
                                <li>{{ $detail->book->title ?? 'Buku' }}</li>
                            @endforeach
                        </ul>
                    </div>
                @empty
                    <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                        Belum ada peminjaman.
                        <a href="{{ route('bookList.index') }}"
                            class="text-indigo-600 dark:text-indigo-400 hover:underline block mt-2">
                            Pilih buku untuk dipinjam
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>