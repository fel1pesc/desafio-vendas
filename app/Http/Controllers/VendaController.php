<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Repositories\RepositoryItem;
use App\Repositories\RepositoryVenda;
use App\Repositories\RepositoryVendaHasItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    private $request;
    private $repositoryVenda;
    private $repositoryItem;
    private $repositoryVendaHasItem;

    public function __construct()
    {
        $this->request = Request::capture();
        $this->repositoryVenda = new RepositoryVenda();
        $this->repositoryItem = new RepositoryItem();
        $this->repositoryVendaHasItem = new RepositoryVendaHasItem();
    }

    public function index()
    {
        $result = $this->repositoryVenda->obterTodos();

        return view('pages.venda.index', compact('result'));
    }

    public function create()
    {
        $itens = $this->repositoryItem->obterTodosParaSelect();

        return view('pages.venda.form', compact('itens'));
    }

    public function store()
    {
        try {
            \DB::beginTransaction();

            $id = $this->request->input('id');
            $itens = $this->request->input('itens_values');

            $venda = Venda::findOrNew($id);

            $action = isset($venda->id) ? 'edit' : 'create';

            $venda->fill($this->request->all());

            $validate = validator($this->request->all(), $venda->rules(), $venda->mensages);

            if ($validate->fails())
                return redirect()->route("venda.$action", $action == 'edit' ? $venda : [])->withErrors($validate)->withInput();

            $venda->save();

            $itens = json_decode($itens, true) ?? [];
            $existeItem = false;

            foreach ($itens as $row) {

                if($row['deletar'] == true)
                    $this->repositoryVendaHasItem->deletarPorId($row['id']);
                else
                    $existeItem = true;

                if($row['id'] === 0 && $row['deletar'] == false)
                {
                    $item = ['venda_id' => $venda->id,
                        'item_id' => $row['item_id'],
                        'quantidade' => $row['qtd'],
                        'preco' => $row['preco']];

                    $this->repositoryVendaHasItem->criar($item);
                }
            }

            if ($existeItem == false) {
                DB::rollBack();
                return redirect()->back()->with('validation', 'Adicione pelo menos um Item a Venda.');
            }

            DB::commit();
            return redirect()->route('venda.index')->withStatus('Venda cadastrada com sucesso!');

        } catch (\Exception $exc){
            DB::rollBack();
            return redirect()->back()->with('validation', 'Error - Nº['.$exc->getCode().'] - Erro ao cadastrar Venda.');
        }
    }

    public function edit(Venda $venda)
    {
        $itens = $this->repositoryItem->obterTodosParaSelect();

        return view('pages.venda.form', compact('venda', 'itens'));
    }

    public function destroy()
    {
        try {
            \DB::beginTransaction();

            $id = $this->request->input('id');

            $this->repositoryVendaHasItem->deletarPorVendaId($id);

            $delete = $this->repositoryVenda->deletarPorId($id);

            if(!$delete)
                throw new \Exception('Erro ao excluir Venda');

            return response()->json(['success' => true, 'msg'=> 'Venda excluido com sucesso.']);

            \DB::commit();
            return $result;

        } catch (\Exception $exc){
            \DB::rollback();
            return response()->json(['success' => null, 'msg' => 'Nº['.$exc->getCode().'] - Erro ao excluir Venda.']);
        }
    }

    public function obterItensParaFormPorVendaId($vendaId)
    {
        return $this->repositoryItem->obterItensParaFormPorVendaId($vendaId)->get();
    }
}
