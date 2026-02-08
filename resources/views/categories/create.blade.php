<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-8">
                    <header class="mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Tambah Kategori Baru
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Gunakan nama kategori yang unik untuk mempermudah pengelompokan buku.
                        </p>
                    </header>

                    <form method="post" action="{{ route('categories.store') }}" class="space-y-6 max-w-xl">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Nama Kategori')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                placeholder="Misal: Sains, Novel, Sejarah..." :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <x-primary-button>
                                {{ __('Simpan Kategori') }}
                            </x-primary-button>

                            <a href="{{ route('categories.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>