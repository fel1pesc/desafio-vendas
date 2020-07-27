<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item {{$vendas}}" style="border-right: 1px solid grey">
                <a class="nav-link {{$disableVendas}}" href="{{ url('venda') }}">Vendas</a>
            </li>
            <li class="nav-item {{$itens}}">
                <a class="nav-link {{$disableItens}}" href="{{ url('item') }}">Itens</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto" style="float: right;">
            <form action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-default" style="color: white;">Logout</button>
            </form>
        </ul>
    </div>
</nav>