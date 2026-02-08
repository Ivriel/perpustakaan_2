<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Rack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with(['rack', 'categories'])->get();

        return view('books.index', [
            'books' => $books,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $racks = Rack::all();

        return view('books.create', [
            'categories' => $categories,
            'racks' => $racks,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'isbn' => 'required|string|max:20|unique:books,isbn',
            'rack_id' => 'required|exists:racks,id',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'title' => 'required|string',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'publication_year' => 'required|digits:4',
            'pages' => 'required|integer',
            'stock' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required|string',
        ], [
            'isbn.unique' => 'ISBN ini sudah terdaftar di sistem. Gunakan ISBN lain.',
        ]);

        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('cover_image', 'public');
            $validatedData['cover_image'] = $imagePath;
        } else {
            unset($validatedData['cover_image']);
        }

        $book = Book::create(collect($validatedData)->except('categories')->all());
        $book->categories()->sync($request->input('categories', []));

        return redirect()->route('books.index')->with('success', 'Buku baru berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::with(['rack', 'categories'])->findOrFail($id);

        return view('books.show', [
            'book' => $book,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::with(['rack', 'categories'])->findOrFail($id);
        $racks = Rack::all();
        $categories = Category::all();

        return view('books.edit', [
            'racks' => $racks,
            'book' => $book,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);
        $validatedData = $request->validate([
            'isbn' => 'required|string|max:20|unique:books,isbn,'.$book->id,
            'rack_id' => 'required|exists:racks,id',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'title' => 'required|string',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'publication_year' => 'required|digits:4',
            'pages' => 'required|integer',
            'stock' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required|string',
        ]);

        $data = collect($validatedData)->except(['cover_image', 'categories'])->toArray();

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('cover_image', 'public');
        }

        $book->update($data);
        $book->categories()->sync($request->input('categories', []));

        return redirect()->route('books.index')->with('success','Berhasil memperbarui data buku');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Berhasil menghapus buku');
    }
}
