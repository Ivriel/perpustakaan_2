<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @if (auth()->user()->role === 'visitor')
                My Collections
            @else
                Book Collections
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">

                <div class="p-6 bg-gradient-to-r from-indigo-600 to-violet-700 dark:from-indigo-900 dark:to-violet-950">
                    <div class="flex justify-between items-center text-white">
                        <div>
                            <p class="text-indigo-100 text-sm font-medium uppercase tracking-wider">Total Koleksi</p>
                            <h3 class="text-3xl font-bold">{{ $data->count() }} Buku</h3>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-md">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead
                            class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-gray-900/50 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-4 font-bold">Buku & Penulis</th>
                                <th class="px-6 py-4 font-bold">Detail Koleksi</th>
                                <th class="px-6 py-4 font-bold">Tanggal Disimpan</th>
                                <th class="px-6 py-4 text-right font-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                            @forelse ($data as $collection)
                                <tr
                                    class="group hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10 transition-all duration-200">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="relative flex-shrink-0 h-20 w-14 rounded-lg shadow-md overflow-hidden group-hover:scale-105 transition-transform duration-200">
                                                @if($collection->book->cover_image)
                                                    <img src="{{ asset('storage/' . $collection->book->cover_image) }}"
                                                        class="h-full w-full object-cover">
                                                @else
                                                    <div
                                                        class="h-full w-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                        <span class="text-[8px] text-gray-400">NO COVER</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div
                                                    class="text-base font-bold text-gray-900 dark:text-white leading-tight mb-1">
                                                    {{ $collection->book->title }}
                                                </div>
                                                <div
                                                    class="text-sm text-indigo-600 dark:text-indigo-400 font-medium italic">
                                                    {{ $collection->book->author }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="space-y-1">
                                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                                <span
                                                    class="font-mono bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded mr-2 border dark:border-gray-700">
                                                    {{ $collection->book->book_code }}
                                                </span>
                                            </div>
                                            <div class="text-xs font-semibold text-gray-600 dark:text-gray-300">
                                                Rak: {{ $collection->book->rack->name ?? 'Unset' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ $collection->created_at->format('d M Y H:i') }}
                                        </div>
                                        <div class="text-[10px] text-gray-400 uppercase tracking-tighter">
                                            {{ $collection->created_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('books.show', $collection->book_id) }}"
                                                class="p-2 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors"
                                                title="Lihat Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('collections.destroy', $collection->id) }}" method="POST"
                                                class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-gray-400 hover:text-red-600 transition-colors"
                                                    onclick="return confirm('Hapus {{ $collection->book->title }} dari koleksi?')"
                                                    title="Hapus dari Koleksi">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-20 text-center">
                                        <div class="max-w-xs mx-auto">
                                            <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-full inline-block mb-4">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                    </path>
                                                </svg>
                                            </div>
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-white">Koleksi Kosong</h4>
                                            <p class="text-sm text-gray-500">Anda belum menyimpan buku apapun ke dalam
                                                koleksi pribadi.</p>
                                            <a href="{{ route('books.index') }}"
                                                class="mt-4 inline-block text-indigo-600 font-bold hover:underline">Cari
                                                Buku Menarik &rarr;</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{--
                @if($collections->hasPages())
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                    {{ $collections->links() }}
                </div>
                @endif --}}
            </div>
        </div>
    </div>
</x-app-layout>