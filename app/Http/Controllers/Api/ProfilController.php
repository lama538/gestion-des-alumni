<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profil;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    // ✅ Récupérer le profil de l'utilisateur connecté
    public function index()
{
    $profil = Profil::where('user_id', Auth::id())->with('user')->first();

    if (!$profil) {
        return response()->json([
            'message' => 'Aucun profil trouvé'
        ], 404);
    }

    return response()->json([
        'profil' => $profil,
        'user' => [
            'name' => $profil->user->name,
            'email' => $profil->user->email,
            'role' => $profil->user->role,
        ]
    ]);
}


    // ✅ Créer un profil pour l'utilisateur connecté
    public function store(Request $request)
    {
        if (Profil::where('user_id', Auth::id())->exists()) {
            return response()->json([
                'message' => 'Vous avez déjà un profil'
            ], 400);
        }

        $request->validate([
            'parcours_academique' => 'nullable|string',
            'experiences_professionnelles' => 'nullable|string',
            'competences' => 'nullable|string',
            'realisations' => 'nullable|string',
        ]);

        $profil = Profil::create([
            'user_id' => Auth::id(),
            'parcours_academique' => $request->parcours_academique,
            'experiences_professionnelles' => $request->experiences_professionnelles,
            'competences' => $request->competences,
            'realisations' => $request->realisations,
        ]);

        return response()->json([
            'message' => 'Profil créé avec succès',
            'profil' => $profil
        ], 201);
    }

    // ✅ Mettre à jour le profil de l'utilisateur connecté
    public function update(Request $request)
    {
        $profil = Profil::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'parcours_academique' => 'nullable|string',
            'experiences_professionnelles' => 'nullable|string',
            'competences' => 'nullable|string',
            'realisations' => 'nullable|string',
        ]);

        $profil->update($request->only([
            'parcours_academique',
            'experiences_professionnelles',
            'competences',
            'realisations'
        ]));

        return response()->json([
            'message' => 'Profil mis à jour avec succès',
            'profil' => $profil
        ]);
    }

    // ✅ Supprimer le profil de l'utilisateur connecté
    public function destroy()
    {
        $profil = Profil::where('user_id', Auth::id())->firstOrFail();
        $profil->delete();

        return response()->json(['message' => 'Profil supprimé avec succès']);
    }
}
