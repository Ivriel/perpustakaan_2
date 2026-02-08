<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BookListController extends Controller
{
    public function index()
    {
        $books = Book::with(['rack', 'categories'])->get();

        return view('bookList.index', [
            'books' => $books,
        ]);
    }

    public function show(string $id)
    {
        $book = Book::with(['rack', 'categories'])->findOrFail($id);

        return view('bookList.show', [
            'book' => $book,
        ]);
    }
}
