<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Toy;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Inertia\Inertia;

class ToyController extends Controller
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
    public function store(Request $request, ImageService $imageService)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:50000',
            'child_id' => 'required|exists:children,id'
        ], [
            // Format : 'champ.règle' => 'Message'
            'name.required' => 'Le nom du jouet est obligatoire.',
            'name.string'   => 'Le nom doit être du texte.',
            'name.max'      => 'Le nom est trop long (maximum 255 caractères).',
        ]);

        $toyData = collect($validated)->except('image')->toArray();

        if ($request->hasFile('image')) {

            $toyData['image_path'] = $imageService->imageCompression($request->file('image'), 'toys');
        }

        //stockage du titre, description et le chemin de l'image dans la db
        Toy::create($toyData);

        return redirect()->back()->with("success", "Votre jouet a été ajouté!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Child $child)
    {
        return Inertia::render("Children/Show", [
            "child" => $child,
            "toys"  => $child->toys()->latest()->get() // Récupère uniquement les jouets de cet enfant
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Toy $toy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Toy $toy, ImageService $imageService)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $updateData = collect($validated)->except('image')->toArray();

        if ($request->hasFile('image')) {

            if ($toy->image_path && !str_contains($toy->image_path, 'default-toy.png')) {
                //Suppression de l'ancienne image sur le disque du serveur
                Storage::disk('public')->delete($toy->getRawOriginal('image_path'));
            }

            $updateData['image_path'] = $imageService->imageCompression($request->file('image'), 'toys');
        }
        $toy->update($updateData);

        return redirect()->back()->with('success', 'Votre jouet a bien été modifié');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Toy $toy)
    {
        if ($toy->image_path) {
            $path = $toy->getRawOriginal('image_path');

            if ($path) {
                Storage::disk('public')->delete($path);
            }
        }
        $toy->delete();
        return redirect()->back()->with('success', 'Le jouet a été bien supprimé');
    }
}
