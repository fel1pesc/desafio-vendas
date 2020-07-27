<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\VendaHasItem;
use App\Repositories\RepositoryVenda;
use App\Repositories\RepositoryVendaHasItem;

class VendaController extends Controller
{
    private $repositoryVenda;
    private $repositoryVendaHasItem;

    public function __construct()
    {
        $this->repositoryVenda = new RepositoryVenda();
        $this->repositoryVendaHasItem = new RepositoryVendaHasItem();
    }

    public function obterVendas()
    {
        $vendas = $this->repositoryVenda->obterTodos();

        foreach ($vendas as $venda)
            $venda->valor_total = VendaHasItem::obterValorTotalPorVendaId($venda->id, $venda->desconto);

        return response()->json($vendas, 200);
    }

    public function obterVendaPorId($vendaId)
    {
        $venda = $this->repositoryVenda->obterPorId($vendaId);

        $venda->itens = $this->repositoryVendaHasItem->obterItensPorVendaId($vendaId)->get();

        return response()->json($venda, 200);
    }
}
