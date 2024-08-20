<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string|max:1000',
        ]);

        $evaluation = Evaluation::findOrFail($id);

        // Criação do comentário
        Comment::create([
            'evaluation_id' => $evaluation->id,
            'user_id' => Auth::id(), // Usuário autenticado
            'text' => $request->input('text'),
        ]);

        return redirect()->back()->with('success', 'Comentário adicionado com sucesso!');
    }
    public function update(Request $request, $id) {
        $request->validate([
            'text' => 'required|string|max:1000',
        ]);
    
        $comment = Comment::findOrFail($id); 
        $comment->text = $request->input('text');
        $comment->save();
    
        return redirect()->back()->with('success', 'Comentário editado com sucesso');
    }
    
    public function destroy(Request $request, $id) {
        
        $comment = Comment::findOrFail($id); 
        $comment->delete();
    
        return redirect()->back()->with('success', 'Comentário deletado.');
    }
}

