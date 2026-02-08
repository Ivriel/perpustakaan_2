<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Book: ') . $book->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('books.update', $book->id) }}" enctype="multipart/form-data"
                    class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <div class="space-y-6">
                            <h3
                                class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b dark:border-gray-700 pb-2">
                                Data Koleksi</h3>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="book_code" :value="__('Kode Buku')" />
                                    <x-text-input disabled id="book_code" name="book_code" type="text"
                                        class="mt-1 block w-full" :value="old('book_code', $book->book_code)"
                                        required />
                                    <x-input-error class="mt-2" :messages="$errors->get('book_code')" />
                                </div>
                                <div>
                                    <x-input-label for="isbn" :value="__('ISBN')" />
                                    <x-text-input id="isbn" name="isbn" type="text" class="mt-1 block w-full"
                                        :value="old('isbn', $book->isbn)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('isbn')" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="title" :value="__('Judul Buku')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                    :value="old('title', $book->title)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="author" :value="__('Penulis')" />
                                    <x-text-input id="author" name="author" type="text" class="mt-1 block w-full"
                                        :value="old('author', $book->author)" required />
                                </div>
                                <div>
                                    <x-input-label for="publisher" :value="__('Penerbit')" />
                                    <x-text-input id="publisher" name="publisher" type="text" class="mt-1 block w-full"
                                        :value="old('publisher', $book->publisher)" required />
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="publication_year" :value="__('Tahun')" />
                                    <x-text-input id="publication_year" name="publication_year" type="number"
                                        class="mt-1 block w-full" :value="old('publication_year', $book->publication_year)" required />
                                </div>
                                <div>
                                    <x-input-label for="pages" :value="__('Halaman')" />
                                    <x-text-input id="pages" name="pages" type="number" class="mt-1 block w-full"
                                        :value="old('pages', $book->pages)" required />
                                </div>
                                <div>
                                    <x-input-label for="stock" :value="__('Stok')" />
                                    <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full"
                                        :value="old('stock', $book->stock)" required />
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h3
                                class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b dark:border-gray-700 pb-2">
                                Klasifikasi</h3>

                            <div>
                                <x-input-label for="rack_id" :value="__('Penempatan Rak')" />
                                <select id="rack_id" name="rack_id"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                                    <option value="">-- Pilih Rak --</option>
                                    @foreach($racks as $rack)
                                        <option value="{{ $rack->id }}" {{ old('rack_id', $book->rack_id) == $rack->id ? 'selected' : '' }}>
                                            {{ $rack->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label :value="__('Kategori')" class="mb-2" />
                                <div
                                    class="grid grid-cols-2 gap-2 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border dark:border-gray-700 max-h-40 overflow-y-auto">
                                    @foreach ($categories as $cat)
                                        <label
                                            class="inline-flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                            <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                {{ $book->categories->contains($cat->id) ? 'checked' : '' }}>
                                            <span
                                                class="ml-2 text-sm text-gray-700 dark:text-gray-200">{{ $cat->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <x-input-label :value="__('Cover Saat Ini')" />
                                <div class="mt-2 mb-4">
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover"
                                            class="w-24 h-32 object-cover rounded shadow-md border dark:border-gray-700">
                                    @else
                                        <div
                                            class="w-24 h-32 flex items-center justify-center bg-gray-100 dark:bg-gray-900 text-gray-400 text-xs rounded border border-dashed dark:border-gray-700">
                                            No Image</div>
                                    @endif
                                </div>
                                <x-input-label for="cover_image" :value="__('Ganti Cover (Opsional)')" />
                                <input id="cover_image" name="cover_image" type="file"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-gray-700 dark:file:text-gray-300"
                                    accept="image/*">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="description" :value="__('Deskripsi Buku')" />
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">{{ old('description', $book->description) }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 gap-4 border-t dark:border-gray-700 pt-6">
                        <a href="{{ route('books.index') }}"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button>
                            {{ __('Perbarui Data Buku') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>