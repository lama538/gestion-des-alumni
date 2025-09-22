<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        return User::all();
    }

    public function show($id){
        return User::findOrFail($id);
    }

    public function update(Request $request, $id){
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user);
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message'=>'User deleted']);
    }

    // Récupérer le profil de l’utilisateur connecté
    public function profile(Request $request) {
        return response()->json($request->user());
    }

    // Mettre à jour le profil de l’utilisateur connecté
    public function updateProfile(Request $request) {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6|confirmed' // pour réinitialiser le mot de passe
        ]);

        $data = $request->only('name', 'email');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json($user);
    }

    // Mettre à jour un utilisateur par ID (pour admin)
    
    public function updateUser(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user);
    }
    public function updatePassword(Request $request) {
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);

    $user = $request->user();

    if (!\Hash::check($request->current_password, $user->password)) {
        return response()->json(['message' => 'Mot de passe actuel incorrect'], 400);
    }

    $user->password = bcrypt($request->new_password);
    $user->save();

    return response()->json(['message' => 'Mot de passe mis à jour avec succès !']);
}

}
