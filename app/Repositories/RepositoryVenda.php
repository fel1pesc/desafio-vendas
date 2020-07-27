<?php


namespace App\Repositories;


use App\Models\Venda;

class RepositoryVenda extends RepositoryBase
{
    public function __construct()
    {
        parent::__construct(new Venda());
    }
}
