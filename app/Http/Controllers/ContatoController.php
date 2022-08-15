<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contato;
use App\Telefone;
use App\User;
use Illuminate\Support\Facades\DB;

class ContatoController extends Controller
{
    public function index(){
        //pega o usuario para verificar os contatos a ser mostrados
        $user = auth()->user();
        if($user){
            $contatos = User::find($user->id);
            $contatos = $contatos->contatos()->get();
            return view('welcome', ['contatos' => $contatos]);
        }
        return view('welcome');
    }
    ##LER
    public function buscar(Request $request){
        $user = auth()->user();
        if($request->tipo == 'nome'){
            $contatos = Contato::where('user_id', $user->id)->where(function($query) use ($request){
                $query->where('nome', 'like', '%'.$request->search.'%')
                ->orWhere('sobrenome', 'like', '%'.$request->search.'%');
            })
            ->get();
        }elseif($request->tipo == 'telefone'){
            $telefones = Telefone::where([
                ['telefone', 'like', '%'.$request->search.'%']
            ])->get();
            $contatos = array();
            foreach($telefones as $contato){
                $contato = $contato->contato()->get();
                if(!in_array($contato[0], $contatos) && $contato[0]['user_id'] == $user->id){
                    array_push($contatos, $contato[0]);
                }
            }
        }

        return view('welcome', ['contatos' => $contatos, 'search' => $request->search]);
    }  
    ##CRIAR
    public function formularioCriarContato(){
        return view('contato/criar-contato');
    }
    public function criarContato(Request $request){
        $user = auth()->user();
        $contato = Contato::create([
            'nome' => $request->nome,
            'sobrenome' => $request->sobrenome,
            'user_id' => $user->id
        ]);
        foreach($request->telefone as $telefone){
            Telefone::create([
                'telefone' => $telefone,
                'contato_id' => $contato->id
            ]);
        }
        return $this->index();
    }
    ##EDITAR
    public function formularioEditarContato($id){
        $contato = Contato::find($id);
        $telefones = $contato->telefones;
        return view('contato/editar-contato', ['contato' => $contato, 'telefones' =>$telefones]);
    }
    public function editarContato(Request $request, $id){
        $contato = Contato::find($id);
        $telefones = $contato->telefones;        
        $contato->update([
            'nome' => $request->nome,
            'sobrenome' => $request->sobrenome
        ]);
        if(count($request->telefone) > count($telefones)){
            for($i = 0;$i < count($request->telefone);$i++){
                if($i < count($telefones)){
                    $telefones[$i]->update([
                        'telefone' => $request->telefone[$i]
                    ]);
                }else{
                    Telefone::create([
                        'telefone' => $request->telefone[$i],
                        'contato_id' => $id
                    ]);
                }
            }
        }else{
            for($i = 0; $i < count($telefones); $i++){
                if($i < count($request->telefone)){
                    $telefones[$i]->update([
                        'telefone' => $request->telefone[$i]
                    ]);
                }else{
                    $telefones[$i]->delete();
                }
            }

        }
        $contatos = Contato::all();
        return $this->index();
        //return view('welcome', ['contatos' => $contatos]);
    }
    ##EXCLUIR
    public function excluirContato($id){
        Contato::find($id)->telefones()->delete();
        Contato::find($id)->delete();
        $contatos = Contato::all();
        //return view('welcome', ['contatos' => $contatos]);
        return $this->index();

    }
    ##MOSTRAR TELEFONES CADASTRADOS
    public function mostrarTelefones($id){
        $contato = Contato::find($id);
        $telefones = Contato::find($id)->telefones()->get();
        return view('/contato/mostrar-telefones', ['telefones' => $telefones, 'contato' => $contato]);
    }
}
