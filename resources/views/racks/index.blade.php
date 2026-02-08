<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rack Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">

                <div
                    class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Daftar Rak</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola lokasi dan penyimpanan buku di sini.
                        </p>
                    </div>
                    <a href="{{ route('racks.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        + Tambah Rak
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-300">
                            <tr>
                                <th class="px-6 py-4 font-bold">ID</th>
                                <th class="px-6 py-4 font-bold">Nama Rak</th>
                                <th class="px-6 py-4 font-bold">Lokasi</th>
                                <th class="px-6 py-4 font-bold">Catatan</th>
                                <th class="px-6 py-4 font-bold">Update Terakhir</th>
                                <th class="px-6 py-4 text-right font-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($racks as $rack)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-200">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-300">
                                        #{{ $rack->id }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 dark:text-gray-200 font-semibold">
                                        {{ $rack->name }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                        {{ $rack->location ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400 max-w-xs truncate">
                                        {{ $rack->note ?? 'Tidak ada catatan' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                        <span class="text-xs block">{{ $rack->updated_at->format('d M Y H:i') }}</span>
                                        <span
                                            class="text-[10px] text-gray-400">{{ $rack->updated_at->diffForHumans() }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-3">
                                        <a href="{{ route('racks.edit', $rack->id) }}"
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 font-bold transition">Edit</a>
                                        <form action="{{ route('racks.destroy', $rack->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 dark:text-red-400 hover:text-red-900 font-bold transition"
                                                onclick="return confirm('Yakin hapus data rak {{ $rack->name }}?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="box-archive"></path>
                                            </svg>
                                            <p class="mt-2 text-gray-500 dark:text-gray-400">Belum ada data rak yang
                                                tersimpan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- @if($racks->hasPages())
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                    {{ $racks->links() }}
                </div>
                @endif --}}

            </div>
        </div>
    </div>
</x-app-layout>