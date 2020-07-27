<?php


namespace App\Repositories;


use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepositoryItem extends RepositoryBase
{
    public function __construct(Request $request = null)
    {
        parent::__construct(new Item(), $request);
    }

    public function store()
    {
        DB::beginTransaction();

        try {
            $id = $this->request->input('id');

            $item = Item::findOrNew($id);

            $item->fill($this->request->all());

            $validate = validator($this->request->all(), $item->rules(), $item->mensages);

            if ($validate->fails())
                return redirect()->back()->withErrors($validate)->withInput();

            $save = $item->save();

            if(!$save)
                throw new \Exception('Erro ao cadastrar Item!');

            DB::commit();
            return redirect()->route('item.index')->withStatus('Item cadastrado com sucesso!');

        } catch (\Exception $exc){
            DB::rollback();
            return redirect()->back()->with('validation', $exc->getMessage());
        }
    }

    public function destroy()
    {
        \DB::beginTransaction();

        try {
            $id = $this->request->input('id');

            $delete = self::deletarPorId($id);

            if(!$delete)
                throw new \Exception('Erro ao excluir Item');

            \DB::commit();
            return response()->json(['success' => true, 'msg'=> 'Item excluido com sucesso.']);

        } catch (\Exception $exc){
            \DB::rollback();
            return response()->json(['success' => null, 'msg' => $exc->getMessage()]);
        }
    }

    public function obterTodosParaSelect()
    {
        return arrayToSelect(Item::select('item.id', 'item.descricao')->get()->toArray(), 'id', 'descricao');
    }

    public function obterItensParaFormPorVendaId($vendaId)
    {
        return Item::join('venda_has_item AS vhi', 'vhi.item_id', '=', 'item.id')
                   ->where('vhi.venda_id', $vendaId)
                   ->select('vhi.id', 'item.id as item_id', 'item.descricao', 'vhi.quantidade as qtd', 'vhi.preco');
    }
}
