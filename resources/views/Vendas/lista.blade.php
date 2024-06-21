<!DOCTYPE html>
<html lang="en">
@include('Layout.head')


<script>
    async function handleExcluirVenda(id) {
        try {
            await fetch(`/vendas/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            });
            return location.reload();
        } catch (error) {
            console.log(error)
        }
    }
</script>

<body>

    <div class="container">


        <div style="padding-top: 4rem;">

            <a class="btn btn-warning" href="{{ route('vendas') }}">Voltar para Venda</a>
        </div>
            @include('Layout.alert')
        <h1 style="padding: 2rem 0rem;">Lista de Vendas</h1>

        {{-- {{dd($vendas)}} --}}
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id venda</th>
                    <th scope="col">Nome cliente</th>
                    <th scope="col">Carrinho id</th>
                    <th scope="col">Valor total</th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendas as $venda)
                    <tr>
                        <th scope="row">{{ $venda->id }}</th>
                        <td>{{ $venda->cliente->nome }}</td>
                        <td>{{ $venda->carrinho_id }}</td>
                        <td>{{ $venda->valor_total }}</td>
                        <td> <button type="button" class="btn btn-danger"
                                onclick="handleExcluirVenda({{ $venda->id }})">Excluir</button> </td>
                        <td> <a class="btn btn-warning" href="{{ route('dados-venda', $venda->id) }}">Editar</a> </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
