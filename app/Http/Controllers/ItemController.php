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
        $this->repositoryItem = new RepositoryItem($this->request);
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
        return $this->repositoryItem->store();
    }

    public function edit(Item $item)
    {
        return view('pages.item.form', compact('item'));
    }

    public function destroy()
    {
        return $this->repositoryItem->destroy();
    }
}
