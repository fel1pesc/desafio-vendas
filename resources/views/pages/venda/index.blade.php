@extends('layouts.app')

@section('content')

    @includeIf('layouts.navbar', ['vendas' => 'active', 'itens' => '', 'disableVendas' => 'disabled', 'disableItens' => ''])
    @includeIf('layouts.alert')

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row">
            <div class="offset-10 col-md-2">
                <a href="{{url('venda/create')}}" type="button" class="btn btn-primary">Adicionar</a>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr style="white-space: nowrap;">
                            <th>Nome Cliente</th>
                            <th>Email Cliente</th>
                            <th>Endereço</th>
                            <th>Desconto (%)</th>
                            <th>Valor Total (R$)</th>
                            <th>Data</th>
                            <th style="text-align: center" width="8%">Ações</th>
                        </tr>
                        </thead>
                        <tbody id="table">
                        @foreach($result as $venda)
                            <tr id="{{$venda->id}}">
                                <td>{{ $venda->nome_cliente}}</td>
                                <td>{{ $venda->email_cliente}}</td>
                                <td>{{ $venda->endereco}}</td>
                                <td>{{ $venda->desconto}}</td>
                                <td>{{ number_format(\App\Models\VendaHasItem::obterValorTotalPorVendaId($venda->id, $venda->desconto), 2, ',', '.')}}</td>
                                <td>{{ date('d/m/Y H:i', strtotime($venda->created_at))}}</td>
                                <td align="center">
                                    <a class="btn btn-sm btn-info" data-container="body" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Editar"
                                       onclick="editar('{{$venda->id}}')">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn btn-sm btn-danger" data-container="body" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Excluir {{$venda->descricao}}"
                                       onclick="excluir('{{$venda->id}}', '{{$venda->descricao}}')">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts-footer')
    <script src="{{ asset('js/app/venda.js') }}"></script>
@stop
