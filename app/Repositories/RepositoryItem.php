<?php


namespace App\Repositories;


use App\Models\Item;
use Illuminate\Http\Request;

class RepositoryItem extends RepositoryBase
{
    public function __construct(Request $request)
    {
        parent::__construct(new Item(), $request);
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
