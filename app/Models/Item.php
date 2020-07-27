<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';

    protected $fillable = [
        'descricao'
    ];

    public function rules() {
        return [
            'descricao'   => 'required|unique:item,descricao'. (($this->id) ? ', ' . $this->id : ''),
        ];
    }

    public $mensages = [
        'descricao.required'  => 'Descrição não informada!',
        'descricao.unique'  => 'Descrição já cadastrada!'
    ];
}
