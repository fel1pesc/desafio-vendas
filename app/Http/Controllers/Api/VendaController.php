<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\VendaHasItem;
use App\Repositories\RepositoryVenda;
use App\Repositories\RepositoryVendaHasItem;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    private $request;
    private $repositoryVenda;
    private $repositoryVendaHasItem;

    public function __construct()
    {
        $this->request = Request::capture();
        $this->repositoryVenda = new RepositoryVenda($this->request);
        $this->repositoryVendaHasItem = new RepositoryVendaHasItem($this->request);
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
