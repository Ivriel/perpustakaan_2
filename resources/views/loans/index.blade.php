<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 leading-tight tracking-tight">
                    {{ auth()->user()->role === 'visitor' ? '📦 Daftar Peminjaman Saya' : '📋 Manajemen Peminjaman' }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Pantau status dan masa berlaku peminjaman buku.</p>
            </div>
            @if (auth()->user()->role === 'visitor')
                <a href="{{ route('loans.cart') }}"
                    class="group relative inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white text-sm font-bold rounded-2xl hover:bg-indigo-700 transition-all duration-300 shadow-lg shadow-indigo-200 dark:shadow-none">
                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Keranjang Peminjaman
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 rounded-xl flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 dark:bg-rose-900/20 dark:text-rose-400 rounded-xl flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <div class="space-y-6">
                @forelse ($loans as $loan)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                        <div
                            class="px-6 py-4 bg-gray-50/50 dark:bg-gray-900/30 border-b border-gray-100 dark:border-gray-700 flex flex-wrap justify-between items-center gap-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="bg-indigo-100 dark:bg-indigo-900/50 p-2 rounded-xl text-indigo-600 dark:text-indigo-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">ID Pinjam #{{ $loan->id }}</h3>
                                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold">
                                        {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y H:i') }}
                                    </p>
                                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold">Peminjam:
                                        <b>{{ $loan->user->name }}</b>
                                    </p>
                                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold">Role:
                                        <b>{{ $loan->user->role }}</b>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <span class="px-4 py-1.5 text-[11px] font-black uppercase tracking-tighter rounded-full shadow-sm
                                                        @if($loan->status === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400
                                                        @elseif($loan->status === 'borrowed') bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-400
                                                        @elseif($loan->status === 'returned') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400
                                                        @else bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400
                                                        @endif">
                                    ● {{ $loan->status }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div class="space-y-4 flex-1">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Buku yang
                                        dipinjam:</p>
                                    <ul
                                        class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-gray-700 dark:text-gray-300">
                                        @foreach ($loan->details as $detail)
                                            <li
                                                class="flex items-center gap-2 bg-gray-50 dark:bg-gray-700/50 p-2 rounded-lg border border-gray-100 dark:border-gray-600">
                                                <div class="w-1.5 h-1.5 rounded-full bg-indigo-400"></div>
                                                <span
                                                    class="font-medium truncate">{{ $detail->book->title ?? 'Buku Tidak Diketahui' }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div
                                class="md:text-right flex flex-col justify-center bg-rose-50 dark:bg-rose-900/10 p-4 rounded-2xl border border-rose-100 dark:border-rose-900/20">
                                <span class="text-[10px] font-bold text-rose-400 uppercase tracking-widest">Batas
                                    Pengembalian</span>
                                <span class="text-lg font-black text-rose-600 dark:text-rose-400">
                                    {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                                </span>
                                {{-- CATATAN: Jika ada total_amount (sistem berbayar), contoh tampilan: --}}
                                {{-- <span class="text-[10px] font-bold text-gray-500 uppercase mt-2">Total Bayar</span>
                                <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Rp {{ number_format($loan->total_amount ?? 0, 0, ',', '.') }}</span> --}}
                            </div>
                        </div>

                        <div
                            class="px-6 py-4 bg-gray-50/50 dark:bg-gray-900/30 border-t border-gray-100 dark:border-gray-700 flex flex-wrap justify-between items-center gap-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('loans.show', $loan) }}"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-700 border-2 border-gray-900 dark:border-gray-500 text-gray-900 dark:text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-gray-900 hover:text-white dark:hover:bg-gray-600 transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Lihat Detail
                                </a>
                                <a href="{{ route('loans.printReceipt', $loan) }}" target="_blank"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-emerald-700 transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                        </path>
                                    </svg>
                                    Cetak
                                </a>
                            </div>

                            @if (in_array(auth()->user()->role, ['staff', 'admin']) && $loan->status !== 'returned')
                                <div class="flex items-center gap-4">
                                    <span class="text-xs font-bold text-indigo-600/70 dark:text-indigo-400/70 uppercase">Ubah
                                        Status:</span>
                                    <form action="{{ route('loans.updateStatus', $loan) }}" method="POST"
                                        class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status"
                                            class="rounded-xl border-indigo-200 dark:bg-gray-800 dark:border-indigo-900 dark:text-white text-xs font-bold focus:ring-indigo-500 py-1.5">
                                            @if ($loan->status === 'pending')
                                                <option value="borrowed">Set: Dipinjam</option>
                                                <option value="overdue">Set: Terlambat</option>
                                            @elseif ($loan->status === 'borrowed' || $loan->status === 'overdue')
                                                <option value="returned">Set: Dikembalikan</option>
                                                @if ($loan->status === 'borrowed')
                                                    <option value="overdue">Set: Terlambat</option>
                                                @endif
                                            @endif
                                        </select>
                                        <button type="submit"
                                            class="px-4 py-2 bg-indigo-600 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-indigo-700 shadow-sm transition-all">
                                            Update
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div
                        class="py-20 bg-white dark:bg-gray-800 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700 text-center">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Data Masih Kosong</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6 px-4">Anda belum memiliki riwayat peminjaman buku
                            saat ini.</p>
                        <a href="{{ route('bookList.index') }}"
                            class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-indigo-700 transition-colors">
                            Mulai Cari Buku
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>