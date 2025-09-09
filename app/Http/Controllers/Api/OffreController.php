<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Offre;

class OffreController extends Controller
{
    public function index(){
        return Offre::all();
    }

    public function show($id){
        return Offre::findOrFail($id);
    }

    public function store(Request $request){
        $request->validate([
            'user_id'=>'required|exists:users,id',
            'titre'=>'required|string',
            'description'=>'required|string',
            'type'=>'required|in:emploi,stage',
        ]);
        $offre = Offre::create($request->all());
        return response()->json($offre);
    }

    public function update(Request $request, $id){
        $offre = Offre::findOrFail($id);
        $offre->update($request->all());
        return response()->json($offre);
    }

    public function destroy($id){
        $offre = Offre::findOrFail($id);
        $offre->delete();
        return response()->json(['message'=>'Offre deleted']);
    }
}
