{{-- Halaman keranjang peminjaman --}}
{{-- Data dari controller: $books, $quantities --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Keranjang Peminjaman
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash message: sukses/error dari controller --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if ($books->isEmpty())
                {{-- Cart kosong --}}
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-12 text-center">
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Keranjang kosong.</p>
                    <a href="{{ route('bookList.index') }}"
                        class="text-indigo-600 dark:text-indigo-400 hover:underline font-bold">
                        ← Pilih buku dulu
                    </a>
                </div>
            @else
                {{-- Daftar buku di cart --}}
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="font-bold text-gray-800 dark:text-white">Buku yang akan dipinjam</h3>
                    </div>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        {{-- @foreach = loop tiap buku. $quantities[$book->id] = jumlah eksemplar --}}
                        @foreach ($books as $book)
                            <li class="px-6 py-4 flex justify-between items-center">
                                <div>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $book->title }}</span>
                                    <span class="text-gray-500 dark:text-gray-400 ml-2">× {{ $quantities[$book->id] ?? 1 }}</span>
                                </div>
                                {{-- Form hapus: POST ke route dengan method DELETE --}}
                                <form action="{{ route('loans.cart.remove', $book) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">
                                        Hapus 1
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Form checkout: tanggal pinjam, due date, submit --}}
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="font-bold text-gray-800 dark:text-white mb-4">Selesaikan Peminjaman</h3>
                    <form action="{{ route('loans.checkout') }}" method="POST">
                        @csrf
                        <div class="grid gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Pinjam</label>
                                <input type="date" name="loan_date" value="{{ date('Y-m-d') }}"
                                    class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                                @error('loan_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jatuh Tempo</label>
                                <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+7 days')) }}"
                                    class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                                @error('due_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full px-4 py-2 bg-indigo-600 text-white font-bold rounded hover:bg-indigo-700">
                            Ajukan Peminjaman
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
