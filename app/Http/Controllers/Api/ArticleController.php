<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(){
        return Article::all();
    }

    public function show($id){
        return Article::findOrFail($id);
    }

    public function store(Request $request){
        $request->validate([
            'user_id'=>'required|exists:users,id',
            'titre'=>'required|string',
            'contenu'=>'required|string',
            'image'=>'nullable|string'
        ]);

        $article = Article::create($request->all());
        return response()->json($article);
    }

    public function update(Request $request, $id){
        $article = Article::findOrFail($id);
        $article->update($request->all());
        return response()->json($article);
    }

    public function destroy($id){
        $article = Article::findOrFail($id);
        $article->delete();
        return response()->json(['message'=>'Article deleted']);
    }
}
