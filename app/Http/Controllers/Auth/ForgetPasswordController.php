<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ForgetPasswordController extends Controller
{
    /**
     * Envoie le lien de réinitialisation par email via Notification
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Aucun utilisateur trouvé avec cet email.'], 404);
        }

        // Créer le token de réinitialisation
        $token = app('auth.password.broker')->createToken($user);

        // Envoyer la notification avec le lien vers Angular
        $user->notify(new ResetPasswordNotification($token));

        return response()->json(['message' => 'Lien de réinitialisation envoyé !']);
    }

    /**
     * Réinitialise le mot de passe avec un token
     */
   public function resetPassword(Request $request, $token)
{
    $request->validate([
        'email' => 'required|email',
        'new_password' => 'required|confirmed|min:6',
    ]);

    // Récupérer l’entrée correspondant à l’email
    $record = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->first();

    if (!$record) {
        return response()->json(['message' => 'Token invalide ou expiré.'], 400);
    }

    // Vérifier le token (comparaison hashée)
    if (!\Illuminate\Support\Facades\Hash::check($token, $record->token)) {
        return response()->json(['message' => 'Token invalide ou expiré.'], 400);
    }

    // Récupérer l’utilisateur
    
    $user = User::where('email', $record->email)->first();
    if (!$user) {
        return response()->json(['message' => 'Utilisateur introuvable.'], 404);
    }

    // Mettre à jour le mot de passe
    $user->password = bcrypt($request->new_password);
    $user->save();

    // Supprimer le token utilisé
    DB::table('password_reset_tokens')->where('email', $record->email)->delete();

    return response()->json(['message' => 'Mot de passe réinitialisé avec succès.']);
}

}
