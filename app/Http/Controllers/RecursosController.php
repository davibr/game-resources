<?php


namespace App\Http\Controllers;


use App\Models\Jogo;
use App\Models\Recurso;
use App\Models\TipoRecurso;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class RecursosController extends Controller
{
    public function index() {
        return Inertia::render('Recursos/Index', [
            'filtros' => Request::all('pesquisa'),
            'recursos' => Recurso::orderByJogo()
                ->select('recursos.*')
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
        return Inertia::render('Recursos/Create', [
            'jogos' => Jogo::orderByNome()->get()->map->only('id', 'nome'),
            'tiposRecursos' => TipoRecurso::orderById()->get()->map->only('id', 'nome')
        ]);
    }

    public function store() {
        Recurso::create(
            Request::validate([
                'nome' => ['required', 'max:255'],
                'jogo_id' => ['required', 'exists:jogos,id'],
                'tipo_recurso_id' => ['required', 'exists:tipos_recursos,id'],
                'link' => ['required', 'max:255'],
                'marcar_posicao' => ['required']
            ])
        );

        return Redirect::route('recursos')->with('success', 'Recurso adicionado.');
    }

    public function edit(Recurso $recurso) {
        return Inertia::render('Recursos/Edit', [
            'recurso' => [
                'id' => $recurso->id,
                'nome' => $recurso->nome,
                'jogo_id' => $recurso->jogo_id,
                'tipo_recurso_id' => $recurso->tipo_recurso_id,
                'link' => $recurso->link,
                'marcar_posicao' => $recurso->marcar_posicao
            ],
            'jogos' => Jogo::orderByNome()->get()->map->only('id', 'nome'),
            'tiposRecursos' => TipoRecurso::orderById()->get()->map->only('id', 'nome')
        ]);
    }

    public function update(Recurso $recurso) {
        $recurso->update(
            Request::validate([
                'nome' => ['required', 'max:255'],
                'jogo_id' => ['required', 'exists:jogos,id'],
                'tipo_recurso_id' => ['required', 'exists:tipos_recursos,id'],
                'link' => ['required', 'max:255'],
                'marcar_posicao' => ['required']
            ])
        );
        Cache::forget('link_recurso_' . $recurso->id);

        return Redirect::back()->with('success', 'Recurso atualizado.');
    }

    public function destroy(Recurso $recurso) {
        $recurso->delete();
        Cache::forget('link_recurso_' . $recurso->id);

        return Redirect::route('recursos')->with('success', 'Recurso excluído.');
    }

    public function link(\Illuminate\Http\Request $request, Recurso $recurso) {
        if ($recurso->tipo_recurso->nome == 'Guia TXT') {
            $content = Cache::remember('link_recurso_' . $recurso->id, 60*60*24, function () use ($recurso) {
                $ch = curl_init() ;
                $url = $recurso->link;
                $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
                $options = array(
                    CURLOPT_URL => $url,
                    CURLOPT_HEADER => false ,
                    CURLOPT_TIMEOUT => 20,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_USERAGENT => $agent,
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_RETURNTRANSFER => true
                );

                curl_setopt_array($ch, $options);
                $html = curl_exec($ch);
                curl_close($ch);

                preg_match_all("/<pre id=\"faqspan-\d+\">(.+?)<\/pre>/is", $html,$matches);
                return implode("\n", $matches[1]);
            });

            return response($content, 200)
                ->header('Content-Type', 'text/plain');
        }

        if ($recurso->tipo_recurso->nome == 'Guia HTML') {
            $paginaAtual = $request->query('page', $recurso->posicao_atual ?? 0);

            $recurso->update(['posicao_atual' => $paginaAtual]);

            $ch = curl_init() ;
            $url = $recurso->link . "?page=" . $paginaAtual;
            $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
            $options = array(
                CURLOPT_URL => $url,
                CURLOPT_HEADER => false ,
                CURLOPT_TIMEOUT => 20,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_USERAGENT => $agent,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_RETURNTRANSFER => true
            );

            curl_setopt_array($ch, $options);
            $html = curl_exec($ch);
            curl_close($ch);

            $url = parse_url($recurso->link);

            $html = str_replace('src="/', 'src="' . $url['scheme'] . '://' . $url['host'] . '/', $html);
            $html = str_replace('href="/', 'href="' . $url['scheme'] . '://' . $url['host'] . '/', $html);

            $html = str_replace($recurso->link, route('recursos.link', $recurso), $html);
            $html = str_replace(route('recursos.link', $recurso) . '"', route('recursos.link', $recurso) . '?page=0"', $html);
            //html = str_replace($url['path'], route('recursos.link', $recurso), $html);

            return response($html, 200);
        }

        return \redirect($recurso->link);
    }
}