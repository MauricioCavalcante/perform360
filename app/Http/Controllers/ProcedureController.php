<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcedureController extends Controller
{
    public function index (){
        return view('procedures.service_itinerary');
    }

    public function update(Request $request)
    {
        // Validar o arquivo enviado
        $request->validate([
            'arquivo' => 'required|mimes:pdf|max:2048',
        ]);

        // Remover o arquivo antigo
        $oldFile = 'public/files/procedimentos.pdf';
        if (Storage::exists($oldFile)) {
            Storage::delete($oldFile);
        }

        // Salvar o novo arquivo
        $path = $request->file('arquivo')->storeAs('public/files', 'procedimentos.pdf');

        // Retornar para a página anterior com uma mensagem de sucesso
        return back()->with('success', 'Arquivo substituído com sucesso!');
    }
}
