@extends('layouts.app')

@section('content')

    @includeIf('layouts.navbar', ['vendas' => '', 'itens' => 'active', 'disableVendas' => '', 'disableItens' => 'disabled'])

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-12">
                <h2> {{ (isset($venda)) ? 'Editar' : 'Cadastrar' }} Item</h2>
            </div>
        </div>
        <br/>
        @if(isset($item))
            {!! Form::model($item, ['url' => route('item.store'), 'id' => 'form-item', 'class' => 'form-item']) !!}
        @else
            {!! Form::open(['url' => route('item.store'), 'id' => 'form-item', 'class' => 'form-item']) !!}
        @endif
        <div class="row">
            {!! Form::hidden('id', null, ['id' => 'id']) !!}
            <div class="col-md-12">
                {!! Form::label('descricao', 'Descrição:', ['class' => 'required']) !!}
                {!! Form::text('descricao', null, ['class' => 'form-control', 'maxlength' => 150]) !!}
                @if ($errors->has('descricao'))
                    <span id="descricao-error" class="error text-danger" for="input-descricao">{{ $errors->first('descricao') }}</span>
                @endif
            </div>
        </div>
        <hr/>
        <div class="footer">
            <button type="submit" class="btn btn-success" style="float: right;"> Salvar</button>
            <a href="{{url('item')}}" type="button" class="btn btn-primary" style="float: left;"> Voltar</a>
        </div>
        {!! Form::close() !!}
    </div>
@stop

@section('scripts-footer')
    <script src="{{ asset('js/item.js') }}"></script>
@stop
