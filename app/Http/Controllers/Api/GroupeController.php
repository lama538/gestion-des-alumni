<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Groupe;

class GroupeController extends Controller
{
    public function index(){
        return Groupe::with('membres')->get();
    }

    public function show($id){
        return Groupe::with('membres')->findOrFail($id);
    }

    public function store(Request $request){
        $request->validate([
            'user_id'=>'required|exists:users,id',
            'nom'=>'required|string',
            'description'=>'nullable|string'
        ]);

        $groupe = Groupe::create($request->all());
        return response()->json($groupe);
    }

    public function update(Request $request, $id){
        $groupe = Groupe::findOrFail($id);
        $groupe->update($request->all());
        return response()->json($groupe);
    }

    public function destroy($id){
        $groupe = Groupe::findOrFail($id);
        $groupe->delete();
        return response()->json(['message'=>'Groupe deleted']);
    }
}
