<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Profil;

class ProfilController extends Controller
{
    public function index(){
        return Profil::all();
    }

    public function show($id){
        return Profil::findOrFail($id);
    }

    public function store(Request $request){
        $profil = Profil::create($request->all());
        return response()->json($profil);
    }

    public function update(Request $request, $id){
        $profil = Profil::findOrFail($id);
        $profil->update($request->all());
        return response()->json($profil);
    }

    public function destroy($id){
        $profil = Profil::findOrFail($id);
        $profil->delete();
        return response()->json(['message'=>'Profil deleted']);
    }
}
