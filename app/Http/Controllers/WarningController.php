<?php

namespace App\Http\Controllers;

use App\Models\Warning;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class WarningController extends Controller
{
    public function index()
    {
        $timezone = Config::get('app.timezone');
        $now = Carbon::now($timezone);
        
        $warnings = Warning::where('start', '<=', $now)
            ->where(function($query) use ($now) {
                $query->where('finish', '>=', $now)
                      ->orWhereNull('finish');
            })
            ->get();
        
        return view('warnings.warning', compact('warnings'));
    }
    public function panel()
    {
        $warnings = Warning::all();
        $countdowns = [];

        foreach ($warnings as $warning) {
            $start = Carbon::parse($warning->start);
            $finish = $warning->finish ? Carbon::parse($warning->finish) : null;

            $now = Carbon::now();
            $interval = null;

            if ($finish) {
                $interval = $finish->diff($now);
            }

            $countdowns[$warning->id] = [
                'start' => $start ? $start->toDateTimeString() : null,
                'finish' => $finish ? $finish->toDateTimeString() : null,
                'interval' => $interval,
            ];
        }

        return view('warnings.panel', compact('warnings', 'countdowns'));
    }

    public function create()
    {
        $now = Carbon::now('America/Sao_Paulo')->setTimezone('UTC');
        $nowFormatted = $now->format('Y-m-d\TH:i');

        return view('warnings.form_warning', ['now' => $nowFormatted]);
    }
    public function edit($id)
    {
        $warning = Warning::findOrFail($id);
        $warning->start = $warning->start ? Carbon::parse($warning->start)->timezone('UTC')->format('Y-m-d\TH:i') : null;
        $warning->finish = $warning->finish ? Carbon::parse($warning->finish)->timezone('UTC')->format('Y-m-d\TH:i') : null;


        return view('warnings.form_warning', compact('warning'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => ['required', 'string'],
            'body' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'start' => ['nullable', 'date_format:Y-m-d\TH:i'],
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
            $warning->start = $request->input('start');
            $warning->finish = $request->input('finish');
            $warning->save();

            return redirect()->route('warnings.index')->with('success', 'Aviso editado com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao editar aviso: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Erro ao editar aviso. Por favor, tente novamente mais tarde.']);
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string'],
            'body' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'start' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'finish' => ['nullable', 'date_format:Y-m-d\TH:i'],
        ]);

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('images', 'public');
            }

            $warning = Warning::create([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'image' => $imagePath,
                'start' => $request->input('start') ? Carbon::parse($request->input('start'))->timezone('America/Sao_Paulo')->format('Y-m-d H:i:s') : null,
                'finish' => $request->input('finish') ? Carbon::parse($request->input('finish'))->timezone('America/Sao_Paulo')->format('Y-m-d H:i:s') : null,
            ]);

            return redirect()->route('warnings.index')->with('success', 'Aviso adicionado com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao criar aviso: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Erro ao criar aviso. Por favor, tente novamente mais tarde.']);
        }
    }


    public function delete($id)
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
