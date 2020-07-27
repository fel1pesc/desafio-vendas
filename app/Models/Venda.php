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
            'desconto'       => 'required|numeric|min:0|max:100'
        ];
    }

    public $mensages = [
        'nome_cliente.required'  => 'Nome não informado!',
        'email_cliente.required' => 'Email não informado!',
        'email_cliente.email'    => 'Email inválido!',
        'desconto.required'      => 'Desconto não informado! (Caso não queira dar desconto, digite 0)',
        'desconto.numeric'       => 'Somente números podem ser cadastrados a Desconto!',
        'desconto.min'           => 'O limite mínimo para Desconto é 0!',
        'desconto.max'           => 'O limite máximo para Desconto é 100!',
    ];
}
