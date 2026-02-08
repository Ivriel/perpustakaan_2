<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <nav class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400">
                <a href="{{ route('loans.index') }}"
                    class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Peminjaman</a>
                <svg class="w-5 h-5 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-900 dark:text-gray-100">Detail Peminjaman</span>
            </nav>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest">
                @if($loan->status === 'pending')
                    <span
                        class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 rounded-md">Pending</span>
                @elseif($loan->status === 'borrowed')
                    <span
                        class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-md">Dipinjam</span>
                @elseif($loan->status === 'returned')
                    <span
                        class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-md">Dikembalikan</span>
                @elseif($loan->status === 'overdue')
                    <span
                        class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-md">Terlambat</span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div
                class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 p-8">
                <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-6">Informasi Peminjaman</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Peminjam</p>
                        <div class="flex items-center gap-3">
                            <div
                                class="h-12 w-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg">
                                {{ substr($loan->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $loan->user->name }}
                                </p>
                                <p class="text-sm text-gray-500">{{ $loan->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">ID Peminjaman</p>
                        <p class="text-lg font-mono font-bold text-indigo-600 dark:text-indigo-400">#{{ $loan->id }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Tanggal Pinjam</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Jatuh Tempo</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}</p>
                    </div>

                    @if($loan->return_date)
                        <div>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Tanggal Kembali</p>
                            <p class="text-lg font-bold text-gray-800 dark:text-gray-200">
                                {{ \Carbon\Carbon::parse($loan->return_date)->format('d M Y') }}</p>
                        </div>
                    @endif

                    @if($loan->fine_amount > 0)
                        <div>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Denda</p>
                            <p class="text-lg font-bold text-red-600 dark:text-red-400">Rp
                                {{ number_format($loan->fine_amount, 0, ',', '.') }}</p>
                        </div>
                    @endif

                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Total Buku</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $loan->details->count() }} Buku
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 p-8">
                <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-6">Daftar Buku yang Dipinjam</h2>

                <div class="space-y-4">
                    @forelse($loan->details as $detail)
                        <div
                            class="flex gap-6 p-6 bg-gray-50 dark:bg-gray-900/20 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-indigo-200 dark:hover:border-indigo-800 transition-all">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-24 h-32 rounded-xl overflow-hidden bg-white dark:bg-gray-800 shadow-lg border-2 border-white dark:border-gray-700">
                                    @if($detail->book->cover_image)
                                        <img src="{{ asset('storage/' . $detail->book->cover_image) }}"
                                            class="w-full h-full object-cover" alt="{{ $detail->book->title }}">
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center bg-gray-100 dark:bg-gray-800 text-gray-400">
                                            <svg class="w-10 h-10 opacity-20" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @forelse($detail->book->categories as $category)
                                        <span
                                            class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-tighter rounded-full border border-indigo-100 dark:border-indigo-800">
                                            {{ $category->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-400 italic">Tanpa Kategori</span>
                                    @endforelse
                                </div>

                                <h3 class="text-xl font-black text-gray-900 dark:text-white mb-2">{{ $detail->book->title }}
                                </h3>

                                <div class="flex items-center gap-2 mb-3">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs shadow">
                                        {{ substr($detail->book->author, 0, 1) }}
                                    </div>
                                    <p class="text-sm font-bold text-gray-700 dark:text-gray-300">
                                        {{ $detail->book->author }}</p>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Kode Buku</p>
                                        <p class="text-sm font-mono font-bold text-gray-700 dark:text-gray-300">
                                            {{ $detail->book->book_code }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Penerbit</p>
                                        <p class="text-sm font-bold text-gray-700 dark:text-gray-300">
                                            {{ $detail->book->publisher }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Tahun</p>
                                        <p class="text-sm font-bold text-gray-700 dark:text-gray-300">
                                            {{ $detail->book->publication_year }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Kondisi</p>
                                        <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400 capitalize">
                                            {{ $detail->condition }}</p>
                                    </div>
                                </div>

                                @if($detail->book->rack)
                                    <div class="mt-3 flex items-center gap-2 text-sm">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="text-gray-600 dark:text-gray-400">
                                            <span class="font-bold">{{ $detail->book->rack->name }}</span> -
                                            {{ $detail->book->rack->location }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-400">
                            <p class="text-lg font-bold">Tidak ada buku dalam peminjaman ini</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 p-8">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-black text-gray-900 dark:text-white">Cetak Bukti Peminjaman</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Download atau cetak bukti peminjaman dalam
                            format PDF</p>
                    </div>
                    <a href="{{ route('loans.printReceipt', $loan) }}" target="_blank"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white text-sm font-black uppercase tracking-widest rounded-xl hover:bg-emerald-700 transition-all shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                            </path>
                        </svg>
                        Cetak PDF
                    </a>
                </div>
            </div>

            @if(Auth::user()->role !== 'visitor')
                <div
                    class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 p-8">
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-6">Ubah Status Peminjaman</h2>

                    <form action="{{ route('loans.updateStatus', $loan) }}" method="POST" class="flex flex-wrap gap-4">
                        @csrf
                        @method('PATCH')

                        <select name="status" required
                            class="flex-1 min-w-[200px] rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="pending" {{ $loan->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="borrowed" {{ $loan->status === 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="returned" {{ $loan->status === 'returned' ? 'selected' : '' }}>Dikembalikan
                            </option>
                            <option value="overdue" {{ $loan->status === 'overdue' ? 'selected' : '' }}>Terlambat</option>
                        </select>

                        <button type="submit"
                            class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black uppercase tracking-widest text-sm rounded-xl transition-all shadow-lg">
                            Update Status
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>