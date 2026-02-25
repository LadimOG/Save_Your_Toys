<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChildController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

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

        $validated = $request->validate(
            [
                'name' => 'required|string|max:255'
            ],
            [
                'name' => 'Vous devez ajouter un nom'
            ]
        );

        Child::create($validated);

        return redirect()->back()->with('success', "Votre enfant a bien été ajouté");
    }

    /**
     * Display the specified resource.
     */
    public function show(Child $child)
    {
        return Inertia::render('Children/Show', [
            'child' => [
                'id' => $child->id,
                'name' => $child->name
            ],
            'toys' => $child->toys()->latest()->get(),
        ]);
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
    public function destroy(Child $child)
    {
        $child->delete();
        return redirect()->back()->with('success', "Votre enfant a bien été suprimer");
    }
}
