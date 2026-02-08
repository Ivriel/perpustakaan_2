<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Eksplorasi Koleksi Perpustakaan') }}
            </h2>
            <div class="relative w-full md:w-72">
                <input type="text" placeholder="Cari judul atau penulis..."
                    class="w-full rounded-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500 shadow-sm text-sm">
                <span class="absolute right-3 top-2.5 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse ($books as $book)
                    <div
                        class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col">

                        <div class="relative aspect-[3/4] overflow-hidden">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div
                                    class="w-full h-full bg-gray-200 dark:bg-gray-700 flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="text-xs font-medium text-gray-500 uppercase">No Cover Available</span>
                                </div>
                            @endif

                            <div class="absolute top-3 left-3">
                                <span
                                    class="px-2 py-1 {{ $book->stock > 0 ? 'bg-green-500/90' : 'bg-red-500/90' }} text-white text-[10px] font-bold uppercase tracking-wider rounded-md backdrop-blur-sm">
                                    {{ $book->stock > 0 ? 'Tersedia: ' . $book->stock : 'Habis' }}
                                </span>
                            </div>
                        </div>

                        <div class="p-5 flex-1 flex flex-col">
                            <div class="mb-auto">
                                <p
                                    class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mb-1">
                                    {{ $book->author }}
                                </p>
                                <h3
                                    class="text-lg font-extrabold text-gray-900 dark:text-white leading-tight mb-2 group-hover:text-indigo-600 transition-colors">
                                    <a href="{{ route('bookList.show', $book->id) }}">{{ $book->title }}</a>
                                </h3>

                                <div class="flex items-center gap-2 mb-4">
                                    <span
                                        class="text-xs text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">
                                        {{ $book->publication_year }}
                                    </span>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 italic">
                                        Rak: {{ $book->rack->name ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2 mt-4">
                                <a href="{{ route('bookList.show', $book->id) }}"
                                    class="w-full flex items-center justify-center gap-1 px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat Detail
                                </a>

                                <div class="grid grid-cols-2 gap-2">
                                    <form action="{{ route('collections.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <button type="submit"
                                            class="w-full flex items-center justify-center gap-1 px-3 py-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 text-xs font-bold rounded-xl hover:bg-indigo-600 hover:text-white transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                            </svg>
                                            Koleksi
                                        </button>
                                    </form>

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
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <p class="text-gray-500 dark:text-gray-400">Belum ada buku yang dapat ditampilkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>