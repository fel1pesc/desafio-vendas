<?php


namespace App\Repositories;


use App\Models\Venda;

class RepositoryVenda extends RepositoryBaseContract
{
    public function __construct()
    {
        parent::__construct(new Venda());
    }
}
