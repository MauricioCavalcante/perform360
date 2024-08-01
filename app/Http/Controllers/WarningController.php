<?php

namespace App\Http\Controllers;

use App\Models\Warning;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class WarningController extends Controller
{
    public function index()
    {
        $warnings = Warning::all();

        return view('warnings.warning', compact('warnings'));
    }

    public function panel()
    {
        $warnings = Warning::all();

        return view('warnings.panel', compact('warnings'));
    }

    public function create()
    {
        return view('warnings.new_warning');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string'],
            'body' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'], // Adiciona regras de validação de imagem
        ]);

        try {
            $imagePath = null;

            // Verifique se há um arquivo de imagem na solicitação
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Armazene o arquivo em um diretório público e obtenha o caminho
                $imagePath = $image->store('images', 'public');
            }

            $warningData = Warning::create([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'image' => $imagePath,
            ]);

            if (!$warningData) {
                Log::error('Erro ao criar aviso.');
            }

            return redirect()->route('warnings.index')->with('success', 'Aviso adicionado com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao criar aviso: ' . $e->getMessage());
            return redirect()->route('warnings.index')->withErrors(['error' => 'Erro ao criar aviso.']);
        }
    }
    public function destroy($id)
    {
        try {
            $warnings = Warning::findOrFail($id);
            $warnings->delete();


            return redirect()->route('warnings.index')->with('success', 'Aviso excluído com sucesso.');
        } catch (\Exception $e) {
            Log::error("Erro ao excluir o aviso: " . $e->getMessage());
            return redirect()->route('warnings.index')->with('error', 'Houve um problema ao excluir o aviso.');
        }
    }
}
