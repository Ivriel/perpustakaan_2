<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Existed Rack') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-8">
                    <header class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Informasi Rak {{ $rack->name }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Edit rak {{ $rack->name }} untuk mengorganisir koleksi buku perpustakaan.
                        </p>
                    </header>

                    <form method="post" action="{{ route('racks.update', $rack->id)}}" class="space-y-6 max-w-xl">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Nama Rak')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name', $rack->name)" placeholder="Contoh: Rak Fiksi A1" required
                                autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="location" :value="__('Lokasi')" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full"
                                :value="old('location', $rack->location)" placeholder="Contoh: Lantai 2, Sayap Kiri" />
                            <x-input-error class="mt-2" :messages="$errors->get('location')" />
                        </div>

                        <div>

                            <x-input-label for="note" :value="__('Catatan')" />
                            <textarea id="note" name="note" rows="4"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                placeholder="Tambahkan keterangan tambahan jika perlu...">{{ old('note', $rack->note) }}</textarea>
                            <div class="flex items-center gap-4">
                                <x-primary-button>
                                    {{ __('Simpan Rak') }}
                                </x-primary-button>
                            </div>

                            <a href="{{ route('racks.index') }}"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition">
                                {{ __('Batal') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>