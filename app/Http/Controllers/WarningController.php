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

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'body' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'], // Adiciona regras de validação de imagem
        ]);
    
        try {
            $warning = Warning::findOrFail($id);
    
            if ($request->hasFile('image')) {

                if ($warning->image) {
                    Storage::disk('public')->delete($warning->image);
                }

                $image = $request->file('image');
                $imagePath = $image->store('images', 'public');
                $warning->image = $imagePath;
            }
    
            $warning->title = $request->input('title');
            $warning->body = $request->input('body', $warning->body);
            $warning->save();
    
            return redirect()->route('warnings.index')->with('success', 'Aviso editado com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao editar aviso: ' . $e->getMessage());
            return redirect()->route('warnings.index')->withErrors(['error' => 'Erro ao editar aviso. Por favor, tente novamente mais tarde.']);
        }
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

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('images', 'public');
            }

            $warningData = Warning::create([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'image' => $imagePath,
            ]);

            if (!$warningData) {
                Log::error('Erro ao editar aviso.');
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
