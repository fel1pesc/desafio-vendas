@extends('layouts.app')

@section('content')

    @includeIf('layouts.navbar', ['vendas' => '', 'itens' => 'active', 'disableVendas' => '', 'disableItens' => 'disabled'])
    @includeIf('layouts.alert')

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row">
            <div class="offset-10 col-md-2">
                <a href="{{url('item/create')}}" type="button" class="btn btn-primary">Adicionar</a>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Descrição</th>
                            <th style="text-align: center" width="8%">Ações</th>
                        </tr>
                        </thead>
                        <tbody id="table">
                            @foreach($result as $item)
                                <tr id="{{$item->id}}">
                                    <td>{{ $item->descricao }}</td>
                                    <td align="center">
                                        <a class="btn btn-sm btn-info" data-container="body" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Editar {{$item->descricao}}"
                                           onclick="editar('{{$item->id}}')">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger" data-container="body" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Excluir {{$item->descricao}}"
                                           onclick="excluir('{{$item->id}}', '{{$item->descricao}}')">
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
    <script src="{{ asset('js/app/item.js') }}"></script>
@stop
