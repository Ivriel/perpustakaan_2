<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Buku: ') . $book->title }}
            </h2>
            <a href="{{ route('books.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    @if (session('error'))
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-4">
            <div
                class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-900/50 text-red-800 dark:text-red-200 rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-4">
            <div
                class="p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-900/50 text-emerald-800 dark:text-emerald-200 rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">

                <div class="p-8">
                    <div class="flex flex-col lg:flex-row gap-12">

                        <div class="w-full lg:w-1/3">
                            <div class="sticky top-8">
                                <div
                                    class="rounded-lg shadow-lg overflow-hidden bg-gray-100 dark:bg-gray-900 border dark:border-gray-700">
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                                            alt="Cover {{ $book->title }}" class="w-full h-auto object-cover">
                                    @else
                                        <div class="flex flex-col items-center justify-center py-24 text-gray-400">
                                            <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span>No Cover Available</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-6 space-y-4">
                                    <div
                                        class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Stok Tersedia</span>
                                        <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $book->stock }}
                                            Unit</span>
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        @foreach($book->categories as $category)
                                            <span
                                                class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 text-xs font-bold rounded-full border border-indigo-200 dark:border-indigo-800">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full lg:w-2/3 space-y-8">
                            <div>
                                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">
                                    {{ $book->title }}
                                </h1>
                                <p class="text-xl text-indigo-600 dark:text-indigo-400 font-medium italic">
                                    {{ $book->author }}
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400">Identitas Buku
                                    </h3>
                                    <ul class="space-y-3">
                                        <li class="flex justify-between border-b dark:border-gray-700 pb-2">
                                            <span class="text-gray-500 dark:text-gray-400">Kode Buku</span>
                                            <span
                                                class="font-mono font-bold text-gray-900 dark:text-gray-200">{{ $book->book_code }}</span>
                                        </li>
                                        <li class="flex justify-between border-b dark:border-gray-700 pb-2">
                                            <span class="text-gray-500 dark:text-gray-400">ISBN</span>
                                            <span
                                                class="font-bold text-gray-900 dark:text-gray-200">{{ $book->isbn ?? '-' }}</span>
                                        </li>
                                        <li class="flex justify-between border-b dark:border-gray-700 pb-2">
                                            <span class="text-gray-500 dark:text-gray-400">Penerbit</span>
                                            <span
                                                class="font-bold text-gray-900 dark:text-gray-200">{{ $book->publisher }}</span>
                                        </li>
                                        <li class="flex justify-between border-b dark:border-gray-700 pb-2">
                                            <span class="text-gray-500 dark:text-gray-400">Tahun Terbit</span>
                                            <span
                                                class="font-bold text-gray-900 dark:text-gray-200">{{ $book->publication_year }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="space-y-4">
                                    <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400">Fisik & Lokasi
                                    </h3>
                                    <ul class="space-y-3">
                                        <li class="flex justify-between border-b dark:border-gray-700 pb-2">
                                            <span class="text-gray-500 dark:text-gray-400">Jumlah Halaman</span>
                                            <span class="font-bold text-gray-900 dark:text-gray-200">{{ $book->pages }}
                                                Hlm</span>
                                        </li>
                                        <li class="flex justify-between border-b dark:border-gray-700 pb-2">
                                            <span class="text-gray-500 dark:text-gray-400">Rak (Lokasi)</span>
                                            <span
                                                class="font-bold text-indigo-600 dark:text-indigo-400 underline">{{ $book->rack->name ?? 'Belum Diatur' }}</span>
                                        </li>
                                        <li class="flex justify-between border-b dark:border-gray-700 pb-2">
                                            <span class="text-gray-500 dark:text-gray-400">Posisi Rak</span>
                                            <span
                                                class="text-gray-900 dark:text-gray-200 italic">{{ $book->rack->location ?? '-' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-900/40 p-6 rounded-2xl border dark:border-gray-700">
                                <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-4">Sinopsis /
                                    Deskripsi</h3>
                                <div class="text-gray-700 dark:text-gray-300 leading-relaxed text-sm lg:text-base">
                                    {!! nl2br(e($book->description)) ?: '<span class="italic text-gray-500">Tidak ada deskripsi tambahan untuk buku ini.</span>' !!}
                                </div>
                            </div>

                            <div
                                class="pt-6 flex flex-wrap gap-6 text-[11px] text-gray-400 uppercase tracking-widest border-t dark:border-gray-700">
                                <div>Ditambahkan: {{ $book->created_at->format('d M Y, H:i') }}</div>
                                <div>Terakhir Diperbarui: {{ $book->updated_at->diffForHumans() }}</div>
                            </div>

                            <div class="flex gap-4 pt-4">
                                <form action="{{ route('collections.store') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                    <button type="submit"
                                        class="flex-1 inline-flex justify-center items-center px-6 py-3 text-sm font-medium text-center text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:outline-none focus:ring-emerald-300 dark:bg-emerald-500 dark:hover:bg-emerald-600">
                                        Tambah ke Koleksi
                                    </button>
                                </form>
                                <a href="{{ route('books.edit', $book->id) }}"
                                    class="text-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition shadow-lg shadow-indigo-500/20">
                                    Edit Buku
                                </a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="flex-1">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Hapus buku {{ $book->title }} secara permanen?')"
                                        class="w-full px-6 py-3 bg-white dark:bg-gray-800 border border-red-200 dark:border-red-900/50 text-red-600 font-bold rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                        Hapus Buku
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>