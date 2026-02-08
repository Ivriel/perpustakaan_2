<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Book Collection') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data" class="p-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <div class="space-y-6">
                            <h3
                                class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b dark:border-gray-700 pb-2">
                                Informasi Utama</h3>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="isbn" :value="__('ISBN')" />
                                    <x-text-input id="isbn" name="isbn" type="text" class="mt-1 block w-full"
                                        :value="old('isbn')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('isbn')" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="title" :value="__('Judul Buku')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                    :value="old('title')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="author" :value="__('Penulis')" />
                                    <x-text-input id="author" name="author" type="text" class="mt-1 block w-full"
                                        :value="old('author')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('author')" />
                                </div>
                                <div>
                                    <x-input-label for="publisher" :value="__('Penerbit')" />
                                    <x-text-input id="publisher" name="publisher" type="text"
                                        class="mt-1 block w-full" :value="old('publisher')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('publisher')" />
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="publication_year" :value="__('Tahun')" />
                                    <x-text-input id="publication_year" name="publication_year" type="number"
                                        min="1900" max="{{ date('Y') }}" class="mt-1 block w-full"
                                        :value="old('publication_year')" required />
                                </div>
                                <div>
                                    <x-input-label for="pages" :value="__('Halaman')" />
                                    <x-text-input id="pages" name="pages" type="number" class="mt-1 block w-full"
                                        :value="old('pages')" required />
                                </div>
                                <div>
                                    <x-input-label for="stock" :value="__('Stok')" />
                                    <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full"
                                        :value="old('stock')" required />
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h3
                                class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b dark:border-gray-700 pb-2">
                                Penempatan & Kategori</h3>

                            <div>
                                <x-input-label for="rack_id" :value="__('Pilih Rak (Lokasi)')" />
                                <select id="rack_id" name="rack_id"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="">-- Pilih Rak --</option>
                                    @foreach ($racks as $rack)
                                        <option value="{{ $rack->id }}"
                                            {{ old('rack_id') == $rack->id ? 'selected' : '' }}>
                                            {{ $rack->name }} ({{ $rack->location }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('rack_id')" />
                            </div>

                            <div>
                                <x-input-label :value="__('Kategori Buku')" class="mb-2" />
                                <div
                                    class="grid grid-cols-2 gap-2 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700 max-h-40 overflow-y-auto">
                                    @foreach ($categories as $category)
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                                class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                                {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
                                            <span
                                                class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('categories')" />
                            </div>

                            <div>
                                <x-input-label for="cover_image" :value="__('Cover Buku')" />
                                <input id="cover_image" name="cover_image" type="file"
                                    class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-900 dark:border-gray-700 dark:placeholder-gray-400"
                                    accept="image/*">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG atau JPEG (Max. 2MB).
                                </p>
                                <x-input-error class="mt-2" :messages="$errors->get('cover_image')" />
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="description" :value="__('Deskripsi / Sinopsis')" />
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                placeholder="Masukkan ringkasan buku...">{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 gap-4 border-t dark:border-gray-700 pt-6">
                        <a href="{{ route('books.index') }}"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button>
                            {{ __('Simpan Koleksi Buku') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
