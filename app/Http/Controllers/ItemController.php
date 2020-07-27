<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Repositories\RepositoryItem;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    private $request;
    private $repositoryItem;

    public function __construct()
    {
        $this->request = Request::capture();
        $this->repositoryItem = new RepositoryItem();
    }

    public function index()
    {
        $result = $this->repositoryItem->obterTodos();

        return view('pages.item.index', compact('result'));
    }

    public function create()
    {
        return view('pages.item.form');
    }

    public function store()
    {
        try {
            \DB::beginTransaction();

            $id = $this->request->input('id');

            $item = Item::findOrNew($id);

            $item->fill($this->request->all());

            $validate = validator($this->request->all(), $item->rules(), $item->mensages);

            if ($validate->fails())
                return redirect()->back()->withErrors($validate)->withInput();

            $save = $item->save();

            if(!$save)
                throw new \Exception('Erro ao cadastrar Item!');

            \DB::commit();
            return redirect()->route('item.index')->withStatus('Item cadastrado com sucesso!');

        } catch (\Exception $exc){
            \DB::rollback();
            return redirect()->back()->with('validation', $exc->getMessage());
        }
    }

    public function edit(Item $item)
    {
        return view('pages.item.form', compact('item'));
    }

    public function destroy()
    {
        try {
            \DB::beginTransaction();

            $id = $this->request->input('id');

            $delete = $this->repositoryItem->deletarPorId($id);

            if(!$delete)
                throw new \Exception('Erro ao excluir Item');

            \DB::commit();
            return response()->json(['success' => true, 'msg'=> 'Item excluido com sucesso.']);

        } catch (\Exception $exc){
            \DB::rollback();
            return response()->json(['success' => null, 'msg' => $exc->getMessage()]);
        }
    }
}
