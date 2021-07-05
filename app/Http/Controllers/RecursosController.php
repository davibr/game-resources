<?php


namespace App\Http\Controllers;


use App\Models\Jogo;
use App\Models\Recurso;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class RecursosController extends Controller
{
    public function index() {
        return Inertia::render('Recursos/Index', [
            'filtros' => Request::all('pesquisa'),
            'recursos' => Recurso::orderByJogo()
                ->filtro(Request::only('pesquisa'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($recurso) => [
                    'id'   => $recurso->id,
                    'nome' => $recurso->nome,
                    'jogo' => $recurso->jogo->nome,
                    'tipo' => $recurso->tipo_recurso->nome
                ]),
        ]);
    }

    public function create() {
        return Inertia::render('Recursos/Create');
    }

    public function store() {
        Jogo::create(
            Request::validate([
              'nome' => ['required', 'max:255']
            ])
        );

        return Redirect::route('recursos')->with('success', 'Recurso adicionado.');
    }

    public function edit(Jogo $jogo) {
        return Inertia::render('Recursos/Edit', [
            'jogo' => [
                'id' => $jogo->id,
                'nome' => $jogo->nome,
                'recursos' => $jogo->recursos()->orderByNome()->get()
            ]
        ]);
    }

    public function update(Jogo $jogo) {
        $jogo->update(
            Request::validate([
                'nome' => ['required', 'max:255']
            ])
        );

        return Redirect::back()->with('success', 'Recurso atualizado.');
    }

    public function destroy(Jogo $jogo) {
        $jogo->delete();

        return Redirect::route('recursos')->with('success', 'Recurso excluído.');
    }
}