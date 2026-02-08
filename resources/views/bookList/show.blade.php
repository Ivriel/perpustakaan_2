<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <nav class="flex text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('books.index') }}" class="hover:text-indigo-600 transition-colors">Eksplorasi</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800 dark:text-gray-200 font-medium">Detail Buku</span>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 shadow-2xl sm:rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-700">

                <div class="flex flex-col md:flex-row">
                    <div
                        class="md:w-5/12 bg-gray-50 dark:bg-gray-900/50 p-8 flex justify-center items-center border-b md:border-b-0 md:border-r border-gray-100 dark:border-gray-700">
                        <div class="relative group">
                            <div
                                class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200">
                            </div>

                            <div
                                class="relative rounded-2xl shadow-2xl overflow-hidden bg-white dark:bg-gray-800 w-full max-w-[300px]">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                        class="w-full h-auto object-cover">
                                @else
                                    <div class="py-32 px-12 flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="text-xs font-bold tracking-widest uppercase">No Cover Available</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="md:w-7/12 p-8 md:p-12 flex flex-col">
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($book->categories as $category)
                                <span
                                    class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-widest rounded-full border border-indigo-100 dark:border-indigo-800">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>

                        <div class="mb-8">
                            <h1
                                class="text-4xl font-black text-gray-900 dark:text-white leading-tight mb-2 tracking-tight">
                                {{ $book->title }}
                            </h1>
                            <p class="text-xl text-gray-500 dark:text-gray-400 font-medium">
                                Karya <span
                                    class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $book->author }}</span>
                            </p>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                            <div
                                class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-2xl border border-gray-100 dark:border-gray-600">
                                <p class="text-[10px] text-gray-400 uppercase font-bold mb-1">Tahun</p>
                                <p class="text-sm font-bold text-gray-800 dark:text-gray-200">
                                    {{ $book->publication_year }}
                                </p>
                            </div>
                            <div
                                class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-2xl border border-gray-100 dark:border-gray-600">
                                <p class="text-[10px] text-gray-400 uppercase font-bold mb-1">Halaman</p>
                                <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $book->pages }} hlm</p>
                            </div>
                            <div
                                class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-2xl border border-gray-100 dark:border-gray-600">
                                <p class="text-[10px] text-gray-400 uppercase font-bold mb-1">Stok</p>
                                <p class="text-sm font-bold {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $book->stock }} Unit
                                </p>
                            </div>
                            <div
                                class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-2xl border border-gray-100 dark:border-gray-600">
                                <p class="text-[10px] text-gray-400 uppercase font-bold mb-1">Lokasi</p>
                                <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">
                                    {{ $book->rack->name ?? '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h3
                                class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-widest mb-3 flex items-center">
                                Sinopsis
                                <div class="h-px flex-1 bg-gray-100 dark:bg-gray-700 ml-4"></div>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed italic">
                                "{{ $book->description ?: 'Buku ini belum memiliki deskripsi singkat.' }}"
                            </p>
                        </div>

                        <div class="space-y-2 mb-10 text-sm border-t border-gray-50 dark:border-gray-700 pt-6">
                            <div class="flex justify-between">
                                <span class="text-gray-400 uppercase text-[11px] font-bold">ISBN</span>
                                <span
                                    class="text-gray-700 dark:text-gray-300 font-mono">{{ $book->isbn ?: 'Tidak Tersedia' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400 uppercase text-[11px] font-bold">Penerbit</span>
                                <span class="text-gray-700 dark:text-gray-300">{{ $book->publisher }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400 uppercase text-[11px] font-bold">Kode Buku</span>
                                <span class="text-gray-700 dark:text-gray-300 font-bold">{{ $book->book_code }}</span>
                            </div>
                        </div>

                        <div class="mt-auto flex flex-col sm:flex-row gap-4">
                            <form action="{{ route('loans.cart.add', $book) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-8 py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-sm font-black uppercase tracking-widest rounded-2xl hover:bg-indigo-600 dark:hover:bg-indigo-400 transition-all duration-300 transform hover:-translate-y-1 shadow-xl">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                    Pinjam Sekarang
                                </button>
                            </form>

                            <form action="{{ route('collections.store') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-8 py-4 bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 border-2 border-indigo-600 dark:border-indigo-400 text-sm font-black uppercase tracking-widest rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-300 transform hover:-translate-y-1">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                    </svg>
                                    Tambah Koleksi
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-xs text-gray-400 uppercase tracking-widest">
                    Ditambahkan pada {{ $book->created_at->format('d F Y H:i') }}
                </p>
            </div>
        </div>
    </div>
</x-app-layout>