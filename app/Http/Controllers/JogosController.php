<?php


namespace App\Http\Controllers;


use App\Models\Jogo;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class JogosController extends Controller
{
    public function index() {
        return Inertia::render('Jogos/Index', [
            'filtros' => Request::all('pesquisa'),
            'jogos' => Jogo::orderByNome()
                ->filtro(Request::only('pesquisa'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($jogo) => [
                    'id' => $jogo->id,
                    'nome' => $jogo->nome
                ]),
        ]);
    }

    public function create() {
        return Inertia::render('Jogos/Create');
    }

    public function store() {
        Jogo::create(Request::validate([
            'nome' => ['required', 'max:255']
        ]));

        return Redirect::route('jogos')->with('success', 'Jogo adicionado.');
    }

    public function edit(Jogo $jogo) {

    }

    public function update(Jogo $jogo) {

    }

    public function destroy(Jogo $jogo) {
        $jogo->delete();

        return Redirect::back()->with('success', 'Jogo excluído.');
    }
}