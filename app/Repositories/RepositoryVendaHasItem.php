<?php


namespace App\Repositories;


use App\Models\VendaHasItem;
use Illuminate\Http\Request;

class RepositoryVendaHasItem extends RepositoryBase
{
    public function __construct(Request $request = null)
    {
        parent::__construct(new VendaHasItem(), $request);
    }

    public function deletarPorVendaId($vendaId){
        return VendaHasItem::where('venda_id', $vendaId)->delete();
    }

    // API

    public function obterValorTotalPorVendaId($vendaId){
        return VendaHasItem::where('venda_has_item.venda_id', $vendaId)
                           ->select('i.id', 'i.descricao', 'venda_has_item.quantidade', 'venda_has_item.preco');
    }

    public function obterItensPorVendaId($vendaId){
        return VendaHasItem::join('item as i', 'i.id', '=', 'venda_has_item.item_id')
                           ->where('venda_has_item.venda_id', $vendaId)
                           ->select('venda_has_item.id as venda_has_item_id',
                                    'i.id as item_id',
                                    'i.descricao as item_descricao',
                                    'venda_has_item.quantidade',
                                    'venda_has_item.preco');
    }
}
