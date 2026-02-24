<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Toy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

use Intervention\Image\Laravel\Facades\Image;

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
    public function store(Request $request)
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
            $file = $request->file('image');

            //destination et nom de l'image
            $fileName = 'toys/' . uniqid() . '.webp';

            //compression de l'image
            $compressedImage = Image::read($file)->scale(width: 1000)->toWebp(60);

            //enregistrement de l'image'
            Storage::disk('public')->put($fileName, $compressedImage);

            //ajout du chemin pour la bd
            $toyData['image_path'] = '/storage/' . $fileName;
        }

        //stockage du titre description et le chemin de l'image dans la db
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
    public function update(Request $request, Toy $toy)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $updateData =
            [
                'name' => $validated['name'],
                'description' => $validated['description']
            ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('toys', 'public');
            $updateData['image_path'] = '/storage/' . $path;
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
            $path = str_replace('/storage/', '', $toy->image_path);
            Storage::disk('public')->delete($path);
        }
        $toy->delete();
        return redirect()->back()->with('success', 'Le jouet a été bien supprimé');
    }
}
