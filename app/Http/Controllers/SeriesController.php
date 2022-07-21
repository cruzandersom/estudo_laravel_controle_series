<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;

class SeriesController extends Controller
{
    // Não precisa de chamar o request
    public function index(Request $request)
    {
        /*
         * Gerando consulta diretamente usando SQl
         * $series = DB::select('SELECT nome from series;');
         * */
        $series = Serie::all();
        //$series = Serie::query()->orderBy('nome', 'desc')->get();
        // Posso usar a função helper do Laravel para pegar dados da função
        // assim com inseri-los;
        $mensagemSucesso = session('mensagem.sucesso');

        //$mensagemSucesso = $request->session()->get('mensagem.sucesso');

        // quando usando o flash para armazenar não preciso mais
        // $request->session()->forget('mensagem.sucesso');


        //return view('listar-series', ['series' => $series]);
        // a funcao compact já gera o array par chave valor  sendo que a variavel precisa
        // estar copm o mesmo nome que o da string;


        // Outra forma de atualizar os dados;
        //return view('listar-series', compact('series'));

        return view('series.index' )->with('series', $series)->with('mensagemSucesso', $mensagemSucesso);

    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {

        /* É UMA DAS FORMAS DE RESGATAR OS DADOS QUE SÃO ORINUNDOS DE UM REQUEST;
        * $nomeSerie = $request->input('nome');
         *
        * FORMA DE EXECUÇÃO DE UM INSERT NO BANCO DE DADOS;
        DB::insert('INSERT INTO series (nome) VALUES(?)', [$nomeSerie]);
        */

        // FORMA MAIS COMPACTA. DAVA PARA USAR UM MÉTODO MÁGICO TAMBÉM.
        //$nomeSerie = $request->nome;
        //$serie = new Serie();
        //$serie->nome = $nomeSerie;
        //$serie->save();

        /*
         * Existe a forma de usar passando a série  com create:
         */
        // Passar validação para o código
        //$request->validate([
        //   'nome' => ['required','min:3', 'max:255']
        //]);
        $serie = Serie::create($request->all()); // no fundo esse foi mais fácil;
        // para funcionar preciso colocar o protected $filable = ['nome'] lá na model;

        // Adicionando mensagem na sesssion:
        $request->session()->flash('mensagem.sucesso', "Série : {$serie->nome} adicionada com sucesso");
        return redirect()->route('series.index');
    }

    // Para deletar diretamente, preciso pegar a model e também o request
    public function destroy(Serie $series, Request $request)
    {
        //Serie::destroy($request->serie); // Passando a Serie $series como parametro de rota,posso usar o delete;
        $series->delete();
        // armazenando dados na sessão // para poder utilizar os dados, será necessário que eu coloque
        // na index o request e a mensagem de sucesso;

        // o put coloca a mensgem na sessão, mas eu vou ter que remover na munheca depois
        // se eu utilizar o flash message ela vai ser armazenada na sessão por um único momento e
        // uma vez utilizada ela será destruída;
        //$request->session()->put('mensagem.sucesso', 'Série removida com sucesso');
        // usando o flash eu posso deixar de utilizar o forget lá na index;


        //$request->session()->flash(mensagem.sucesso', "Série {$series->nome} removida com sucesso");

        // Possso passar a utilzar método ->with para passar os parametros da flash message
        // com isso eu passo a não precisar mais do request
        return to_route('series.index')->with('mensagem.sucesso', "Série {$series->nome} removida com sucesso");
    }


    public function edit(Serie $series)
    {
        //dd($series->temporadas()); // Acesso aos relacionamentos das tabelas through dump and die;
        return view('series.edit')->with('serie', $series);
    }

    public function update(Serie $series, SeriesFormRequest $request)
    {
       $series->fill($request->all());
       $series->save();

        return to_route('series.index')->with('mensagem.sucesso', "Série {$series->nome} atualizada com sucesso");
    }



}
