<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Evenement;

class EvenementController extends Controller
{
    public function index(){
        return Evenement::with('users')->get();
    }

    public function show($id){
        return Evenement::with('users')->findOrFail($id);
    }

    public function store(Request $request){
        $request->validate([
            'titre'=>'required|string',
            'description'=>'required|string',
            'date'=>'required|date',
            'lieu'=>'nullable|string'
        ]);

        $evenement = Evenement::create($request->all());
        return response()->json($evenement);
    }

    public function update(Request $request, $id){
        $evenement = Evenement::findOrFail($id);
        $evenement->update($request->all());
        return response()->json($evenement);
    }

    public function destroy($id){
        $evenement = Evenement::findOrFail($id);
        $evenement->delete();
        return response()->json(['message'=>'Evenement deleted']);
    }
}
