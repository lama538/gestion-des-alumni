<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function index(){
        return Message::all();
    }

    public function show($id){
        return Message::findOrFail($id);
    }

    public function store(Request $request){
        $request->validate([
            'sender_id'=>'required|exists:users,id',
            'receiver_id'=>'required|exists:users,id',
            'contenu'=>'required|string'
        ]);

        $message = Message::create($request->all());
        return response()->json($message);
    }

    public function update(Request $request, $id){
        $message = Message::findOrFail($id);
        $message->update($request->all());
        return response()->json($message);
    }

    public function destroy($id){
        $message = Message::findOrFail($id);
        $message->delete();
        return response()->json(['message'=>'Message deleted']);
    }
}
