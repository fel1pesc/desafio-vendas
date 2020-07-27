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
        $this->repositoryVenda = new RepositoryVenda($this->request);
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
        return $this->repositoryVenda->store();
    }

    public function edit(Venda $venda)
    {
        $itens = $this->repositoryItem->obterTodosParaSelect();

        return view('pages.venda.form', compact('venda', 'itens'));
    }

    public function destroy()
    {
        return $this->repositoryVenda->destroy($this);
    }

    public function obterItensParaFormPorVendaId($vendaId)
    {
        return $this->repositoryItem->obterItensParaFormPorVendaId($vendaId)->get();
    }
}
