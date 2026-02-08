<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Book Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">

                <div
                    class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Kategori Buku</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola kategori untuk pengelompokan koleksi
                            buku.</p>
                    </div>
                    <a href="{{ route('categories.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        + Kategori Baru
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-300">
                            <tr>
                                <th class="px-6 py-4 font-bold">ID</th>
                                <th class="px-6 py-4 font-bold">Nama Kategori</th>
                                <th class="px-6 py-4 font-bold">Dibuat Pada</th>
                                <th class="px-6 py-4 text-right font-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($data as $category)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-200">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-300">
                                        #{{ $category->id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-2 w-2 rounded-full bg-indigo-500 mr-3"></div>
                                            <span
                                                class="text-gray-800 dark:text-gray-200 font-semibold">{{ $category->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                        <span class="text-xs block">{{ $category->created_at->format('d M Y') }}</span>
                                        <span
                                            class="text-[10px] text-gray-400">{{ $category->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-3">
                                        <a href="{{ route('categories.edit', $category->id) }}"
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 font-bold transition">Edit</a>

                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 dark:text-red-400 hover:text-red-900 font-bold transition"
                                                onclick="return confirm('Hapus kategori {{ $category->name }}? Kategori yang dihapus mungkin mempengaruhi data buku terkait.')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                </path>
                                            </svg>
                                            <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada kategori buku.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- @if($categories->hasPages())
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                    {{ $categories->links() }}
                </div>
                @endif
                --}}
            </div>
        </div>
    </div>
</x-app-layout>