<?php


namespace App\Repositories;


use App\Models\VendaHasItem;

class RepositoryVendaHasItem extends RepositoryBaseContract
{
    public function __construct()
    {
        parent::__construct(new VendaHasItem());
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
