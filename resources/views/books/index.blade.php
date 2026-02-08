<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('List Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">

                <div
                    class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Daftar Buku</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total jumlah yang terdaftar di sistem.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('books.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            + Tambah Buku
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-300">
                            <tr>
                                <th class="px-6 py-4 font-bold">Buku</th>
                                <th class="px-6 py-4 font-bold">Info Teknis</th>
                                <th class="px-6 py-4 font-bold">Lokasi Rak</th>
                                <th class="px-6 py-4 font-bold text-center">Stok</th>
                                <th class="px-6 py-4 text-right font-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($books as $book)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="flex-shrink-0 h-16 w-12 rounded bg-gray-200 dark:bg-gray-900 overflow-hidden border border-gray-200 dark:border-gray-700">
                                                @if ($book->cover_image)
                                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover"
                                                        class="h-full w-full object-cover">
                                                @else
                                                    <div
                                                        class="flex h-full items-center justify-center text-[10px] text-gray-400">
                                                        No Image</div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-900 dark:text-white">
                                                    {{ $book->title }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $book->author }}
                                                </div>
                                                <div class="mt-1 flex gap-1">
                                                    @foreach ($book->categories as $category)
                                                        <span
                                                            class="px-2 py-0.5 text-[10px] bg-indigo-100 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300 rounded-full">
                                                            {{ $category->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="text-xs text-gray-600 dark:text-gray-400 uppercase font-mono tracking-tighter">
                                            Code: {{ $book->book_code }}</div>
                                        <div class="text-xs text-gray-500">ISBN: {{ $book->isbn ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $book->rack->name ?? 'Unset' }}
                                        </div>
                                        <div class="text-xs text-gray-500 italic">{{ $book->rack->location ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-bold text-gray-900 dark:text-white">
                                        {{ $book->stock }}
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-3">
                                        <a href="{{ route('books.show', $book->id) }}"
                                            class="text-blue-600 dark:text-blue-400 hover:underline font-bold transition">Detail</a>
                                        <a href="{{ route('books.edit', $book->id) }}"
                                            class="text-indigo-600 dark:text-indigo-400 hover:underline font-bold transition">Edit</a>
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 dark:text-red-400 hover:underline font-bold transition"
                                                onclick="return confirm('Hapus buku ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada list buku yang tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- @if ($books->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    {{ $books->links() }}
                </div>
                @endif --}}
            </div>
        </div>
    </div>
</x-app-layout>