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
            $result = \DB::transaction(function ()
            {
                $id = $this->request->input('id');

                $item = Item::findOrNew($id);

                $action = isset($item->id) ? 'edit' : 'create';

                $item->fill($this->request->all());

                $validate = validator($this->request->all(), $item->rules(), $item->mensages);

                if ($validate->fails())
                    return redirect()->route("item.$action", $action == 'edit' ? $item : [])->withErrors($validate)->withInput();

                $save = $item->save();

                if(!$save)
                    throw new \Exception('Erro ao cadastrar Item!');

                return redirect()->route('item.index')->withStatus('Item cadastrado com sucesso!');
            });

            \DB::commit();
            return $result;

        } catch (\Exception $exc){
            \DB::rollback();
            return response()->json(['success' => null, 'msg' => $exc->getMessage()]);
        }
    }

    public function edit(Item $item)
    {
        return view('pages.item.form', compact('item'));
    }

    public function destroy()
    {
        try {
            $result = \DB::transaction(function (){

                $id = $this->request->input('id');

                $delete = $this->repositoryItem->deletarPorId($id);

                if(!$delete)
                    throw new \Exception('Erro ao excluir Item');

                return response()->json(['success' => true, 'msg'=> 'Item excluido com sucesso.']);
            });

            \DB::commit();
            return $result;

        } catch (\Exception $exc){
            \DB::rollback();
            return response()->json(['success' => null, 'msg' => $exc->getMessage()]);
        }
    }
}
