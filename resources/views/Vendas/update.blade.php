<!DOCTYPE html>
<html lang="en">
@include('Layout.head')

<script>
    function handleEditar() {
        return alert('não consegui termianar precisava de mais tempo, sorry 🥹 ')
    }
</script>

<body>
    <div class="container">
        <div style="padding-top: 4rem;">


        @include('Layout.alert')

        <a class="btn btn-warning" href="{{route('lista-venda')}}">Voltar para lista</a>
      </div>
        <h1 style="padding: 2rem 0rem;">Detalhes da venda</h1>


        <div class="form-floating mb-3">
            <input disabled type="email" class="form-control" id="floatingInput" value={{ $venda->id }}
                placeholder="name@example.com">
            <label for="floatingInput">ID da venda</label>
        </div>

        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" value={{ $venda->cliente->nome }}
                placeholder="name@example.com">
            <label for="floatingInput">Nome do cliente</label>
        </div>


         <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" value={{ $venda->carrinho_id }}
                placeholder="name@example.com">
            <label for="floatingInput">ID do carrinho</label>
        </div>


          <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" value={{ $venda->valor_total }}
                placeholder="name@example.com">
            <label for="floatingInput">Valor Total da venda</label>
        </div>

        <h3 style="padding: 2rem 0rem;">Itens da venda</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Produto</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Preço unitario</th>
                    <th scope="col">Valor total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($carrinhoItems as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>{{ $item->produto->titulo }}</td>
                        <td>{{ $item->quantidade }}</td>
                        <td>{{ $item->produto->preco }}</td>
                        <td>{{ $item->valor_final_produto }}</td>
                        <td><button type="button" class="btn btn-warning" onclick="handleEditar()">Editar</button></td>
                    </tr>
                @endforeach



            </tbody>
        </table>

    </div>
</body>

</html>
