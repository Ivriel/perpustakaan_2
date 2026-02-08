<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'visitor') {
            $data = Collection::with(['user', 'book.categories'])->where('user_id', '=', $user->id)->get();
        } else {
            $data = Collection::with(['user', 'book.categories'])->get();
        }

        return view('collections.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);
        $userId = Auth::id();
        $bookId = $validatedData['book_id'];

        // Cek duplikat: satu buku hanya sekali per user di koleksi
        $alreadyExist = Collection::where('user_id', '=', $userId)
            ->where('book_id', '=', $bookId)
            ->exists();
        if ($alreadyExist) {
            return redirect()->back()->with('error', 'Buku ini sudah ada di koleksi anda');
        }

        Collection::create([
            'user_id' => $userId,
            'book_id' => $bookId,
        ]);

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke koleksi');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $collection = Collection::findOrFail($id);
        $collection->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus dari collection');
    }
}
