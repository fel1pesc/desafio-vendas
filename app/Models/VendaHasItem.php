<?php

namespace App\Models;

use App\Repositories\RepositoryVendaHasItem;
use Illuminate\Database\Eloquent\Model;

class VendaHasItem extends Model
{
    protected $table = 'venda_has_item';

    protected $fillable = [
        'venda_id',
        'item_id',
        'quantidade',
        'preco'
    ];

    public static function obterValorTotalPorVendaId($vendaId, $desconto)
    {
        $repository = new RepositoryVendaHasItem();

        $valorTotal = 0;

        $itens = $repository->obterItensPorVendaId($vendaId)->get();

        foreach ($itens as $item)
            $valorTotal += ($item->quantidade * $item->preco);

        $valorTotalComDesconto = $valorTotal - ($valorTotal * ($desconto / 100));

        return $valorTotalComDesconto;
    }
}
