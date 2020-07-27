<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'venda';

    protected $fillable = [
        'nome_cliente',
        'email_cliente',
        'endereco',
        'desconto'
    ];

    public function rules() {
        return [
            'nome_cliente'   => 'required',
            'email_cliente'  => 'required|email',
            'desconto'       => 'numeric|max:100'
        ];
    }

    public $mensages = [
        'nome_cliente.required'  => 'Nome não informado!',
        'email_cliente.required' => 'Email não informado!',
        'email_cliente.email'    => 'Email inválido!',
        'desconto.numeric'       => 'Somente números podem ser cadastrados a Desconto!',
        'desconto.max'         => 'O limite para Desconto é de 100!',
    ];
}
