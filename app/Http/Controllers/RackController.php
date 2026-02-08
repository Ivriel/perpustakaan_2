<?php

namespace App\Http\Controllers;

use App\Models\Rack;
use Illuminate\Http\Request;

class RackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $racks = Rack::all();

        return view('racks.index', [
            'racks' => $racks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('racks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:racks,name',
            'location' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

        Rack::create($validatedData);

        return redirect()->route('racks.index')->with('success', 'Berhasil membuat data rak baru');
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
    public function edit(Rack $rack)
    {
        return view('racks.edit', [
            'rack' => $rack,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:racks,name,'.$id,
            'location' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

        Rack::where('id', '=', $id)->update($validatedData);

        return redirect()->route('racks.index')->with('success', 'Data rak berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rack = Rack::findOrFail($id);
        $rack->delete();

        return redirect()->route('racks.index')->with('success', 'Data rak berhasil dihapus');
    }
}
