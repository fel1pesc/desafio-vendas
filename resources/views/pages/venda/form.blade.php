@extends('layouts.app')

@section('content')

    @includeIf('layouts.navbar', ['vendas' => 'active', 'itens' => '', 'disableVendas' => 'disabled', 'disableItens' => ''])
    @includeIf('layouts.alert')

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-12">
                <h2> {{ (isset($venda)) ? 'Editar' : 'Cadastrar' }} Venda</h2>
            </div>
        </div>
        <br/>
        @if(isset($venda))
            {!! Form::model($venda, ['url' => route('venda.store'), 'id' => 'form-venda']) !!}
        @else
            {!! Form::open(['url' => route('venda.store'), 'id' => 'form-venda']) !!}
        @endif
        <div class="row">
            {!! Form::hidden('id', null, ['id' => 'id']) !!}
            {!! Form::hidden('itens_values', null, ['id' => 'itens-values']) !!}
            <div class="col-md-3">
                {!! Form::label('nome_cliente', 'Nome Cliente*:') !!}
                {!! Form::text('nome_cliente', null, ['class' => 'form-control', 'maxlength' => 255]) !!}
                @if ($errors->has('nome_cliente'))
                    <span id="nome_cliente-error" class="error text-danger" for="input-nome_cliente">{{ $errors->first('nome_cliente') }}</span>
                @endif
            </div>
            <div class="col-md-3">
                {!! Form::label('email_cliente', 'Email Cliente*:') !!}
                {!! Form::text('email_cliente', null, ['class' => 'form-control', 'maxlength' => 120]) !!}
                @if ($errors->has('email_cliente'))
                    <span id="email_cliente-error" class="error text-danger" for="input-email_cliente">{{ $errors->first('email_cliente') }}</span>
                @endif
            </div>
            <div class="col-md-6">
                {!! Form::label('endereco', 'Endereço:') !!}
                {!! Form::text('endereco', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-12">
                <fieldset>
                    <legend>Itens</legend>
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::select('item_id', $itens, null, ['class' => 'form-control select2', 'id' => 'item-select']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::text('quantidade', null, ['class' => 'form-control', 'placeholder' => 'Quantidade', 'id' => 'qtd-item', 'onkeypress' => 'return somenteNumeros(event)']) !!}
                        </div>
                        <div class="col-md-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                </div>
                                {!! Form::text('preco', null, ['class' => 'form-control', 'placeholder' => 'Preço Unit.', 'id' => 'preco-item']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary" id="adicionar-item"><i class="fa fa-plus" aria-hidden="true"></i> Incluir Item</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 table-max-height" style="max-height: 300px; !important;">
                            <br />
                            <table class="table table-hover">
                                <thead>
                                <th>Nome</th>
                                <th>Quantidade</th>
                                <th>Preço Unit. (R$)</th>
                                <th>Preço Unit. Total (R$)</th>
                                <th style="text-align: center" width="16%">Ações</th>
                                </thead>
                                <tbody id="table-body-itens">
                                    @if(!is_null(old('itens_values')) && !isset($venda))

                                        @php
                                            $total = 0
                                        @endphp

                                        @foreach(json_decode((old('itens_values')), true) as $key => $item)

                                            @php
                                                $valorItem = $item['qtd']*$item['preco'];
                                                $total += $valorItem;
                                            @endphp

                                            <tr>
                                                <td>{{ $item['item_descricao'] }}</td>
                                                <td>{{ $item['qtd'] }}</td>
                                                <td>{{ number_format($item['preco'], 2, ',', '.') }}</td>
                                                <td>{{ number_format($valorItem, 2, ',', '.') }}</td>
                                                <td align="center" style="width: 45px;">
                                                    <button type="button" class="btn btn-danger btn-xs" onclick="deletarItem(this, '{{$item['item_id']}}')">
                                                        <span class="fa fa-trash-o" aria-hidden="true"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </fieldset>
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::label('desconto', 'Desconto (%)*:') !!}
                        {!! Form::text('desconto', isset($venda->desconto) ? $venda->desconto : '0', ['class' => 'form-control', 'onkeypress' => 'return somenteNumeros(event)', 'onkeyup' => 'return atualizarValorTotal()']) !!}
                        @if ($errors->has('desconto'))
                            <span id="desconto-error" class="error text-danger" for="input-desconto">{{ $errors->first('desconto') }}</span>
                        @endif
                    </div>
                    <div class="offset-7 col-md-2">
                        <p>Valor Total: R$<span style="font-weight: bold" id="valor-total"> {{ isset($total) ? number_format($total - ($total * (old('desconto') / 100)), 2, ',', '.') : '0,00' }}</span></p>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="footer">
            <button type="submit" class="btn btn-success" style="float: right;"> Salvar</button>
            <a href="{{url('venda')}}" type="button" class="btn btn-primary" style="float: left;"> Voltar</a>
        </div>
        {!! Form::close() !!}
    </div>
@stop

@section('scripts-footer')
    <script src="{{ asset('plugins/priceFormat/jquery.priceformat.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bootstrap3-editable-1.5.1/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
    <script src="{{ asset('js/app/venda.js') }}"></script>
@stop
