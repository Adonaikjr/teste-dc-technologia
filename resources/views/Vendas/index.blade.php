<!DOCTYPE html>
<html lang="pt-br">

@include('Layout.head')

<body>

    <div class="shadow-lg p-3 mb-5 bg-body rounded container mt-5">
        <div class=" container d-flex flex-column gap-4" style="justify-content: space-between;">


            <h1 style="padding: 2rem 0rem;">Venda <a class="btn btn-warning" href="{{ route('lista-venda') }}">Lista de
                    vendas</a></h1>

            @include('Layout.alert')

            <div class="flex-fill flex-1 d-flex gap-4">
                <div class="flex-fill d-flex gap-4 flex-column">
                    <div class="flex-fill d-flex gap-4">
                        <div class="flex-fill form-floating">
                            <input style="" id="cliente-search" style="flex: 1;" class=" form-control"
                                placeholder="Digite o nome do cliente">
                            <label for="floatingInput">Cliente</label>
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#criarCliente">
                            +</button>
                    </div>

                    <div class="flex-fill card" style="display: none; " id="card-list" style="width: 18rem;">
                        <ul class="list-group list-group-flush" id="cliente-list">

                        </ul>
                    </div>
                </div>

                @include('Vendas.Cliente.cadastro-modal')
            </div>

            <div style="flex: 1;" class="produto-item d-flex gap-4">
                @include('Vendas.Produto.cadastro-modal')
                <form id="carrinho-form" style="width: 100%;" class="d-flex gap-4">
                    @csrf
                    <div class="flex-fill d-flex gap-2">
                        <div class="form-floating flex-fill">
                            <input id="produto-search" class="form-control" placeholder="Digite o nome do produto">
                            <label for="floatingInput">Produto</label>
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#criarProduto">+</button>
                    </div>

                    <div class="form-floating">
                        <input style="" id="floatingInput" class="form-control quantidade"
                            placeholder="Digite o nome do cliente" name="quantidade">
                        <label for="floatingInput">Quantidade</label>
                    </div>

                    <div class="form-floating">
                        <input style="" id="floatingInput" class="form-control valor_unitario"
                            placeholder="Digite o nome do cliente">
                        <label for="floatingInput">Valor Unitário</label>
                    </div>

                    <div class="form-floating">
                        <input style="" id="floatingInput" class="form-control sub_total"
                            placeholder="Digite o nome do cliente">
                        <label for="floatingInput">Sub Total</label>
                    </div>

                    <input type="hidden" name="produto_id" id="produto_id">
                    <input type="hidden" name="cliente_id" id="cliente_id">
                    <input type="hidden" name="sub_total" id="sub_total">
                    <input type="hidden" name="valor_unitario" id="valor_unitario">
                    <input type="hidden" name="produto_titulo" id="produto_titulo">

                    <button type="submit" class="btn btn-success">Adicionar</button>
                </form>
            </div>

            <table class="table">
                <thead>
                    <tr class="table-primary">
                        <th scope="col">#</th>
                        <th scope="col">PRODUTO</th>
                        <th scope="col">QUANTIDADE</th>
                        <th scope="col">TOTAL</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="carrinho">

                </tbody>
            </table>

            <div class="flex-fill d-flex   justify-content-between">
                <div>
                    <h1>Pagamento</h1>
                    <h4>Como você quer pagar? <span class="badge bg-secondary" id="valorAPagar"> </span></h4>

                    <span class="mb-4">Digite o número de parcelas:</span>
                    <div class="d-flex gap-2">
                        <div class="form-floating">
                            <input style="" id="floatingInput" class="form-control "
                                placeholder="Digite o nome do cliente" value="1" name="numeroParcelas"
                                min="1">
                            <label for="floatingInput">Parcela(s)</label>
                        </div>
                        <button type="button" onclick="gerarParcelas()" class="btn btn-info">Gerar Parcelas</button>
                    </div>
                </div>

                <table class="table" style="width: 50%;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">DATA VENC</th>
                            <th scope="col">VALOR</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="ver_parcelas">

                    </tbody>
                </table>
            </div>

            <button type="button" onclick="handleOnSubmit()" class="btn btn-dark">
                FINALIZAR VENDA
            </button>

        </div>
    </div>

    <script>
        async function handleOnSubmit() {
            const valorAPagar = document.getElementById(`valorAPagar`).textContent
            const valorTotal = parseFloat(valorAPagar.replace('R$', '').replace(',', '.').trim())
            const Carrinho = JSON.parse(localStorage.getItem('ultimaResposta'))
            const Parcelas = JSON.parse(localStorage.getItem('valor_parcelas'))
            if (Parcelas === null) {
                return alert('Você precisa gerar as parcelas antes de finalizar a venda')
            }
            const data = {
                cliente_id: document.getElementById('cliente_id').value === '' ? alert(
                    'Você precisa selecionar o cliente') : document.getElementById('cliente_id').value,
                valor_total: valorTotal,
                itens_carrinho: Carrinho,
                parcelas: Parcelas,
            }
            try {
                const response = await fetch('{{ route('criar-venda') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });

                if (response.ok) {
                    const data = await response.json()
                    // console.log(data)
                    localStorage.clear();
                    const redirecionar = `/vendas/${data}`;
                    window.location.href = redirecionar;

                }
            } catch (error) {
                console.log(error)
            }
        }
        document.getElementById('carrinho-form').addEventListener('submit', async function(event) {
            event.preventDefault()
            const form = event.target
            const formData = new FormData(form)

            const data = {
                quantidade: formData.get('quantidade'),
                valor_unitario: formData.get('valor_unitario'),
                sub_total: formData.get('sub_total'),
                produto_id: formData.get('produto_id'),
                produto_titulo: formData.get('produto_titulo'),
                cliente_id: formData.get('cliente_id'),
            }

            try {
                const carrinho = localStorage.getItem('ultimaResposta');
                const carrinhoArray = carrinho ? JSON.parse(carrinho) : [];
                carrinhoArray.push(data);
                localStorage.setItem('ultimaResposta', JSON.stringify(carrinhoArray));
                ItemCarrinho()

            } catch (error) {
                console.error('Erro na requisição:', error)
            }
        });

        $(document).ready(function() {
            $('#cliente-search').typeahead({
                source: function(query, process) {
                    return $.get('{{ route('buscar') }}', {
                        query: query
                    }, function(data) {
                        return process(data)
                    })
                },
                displayText: function(item) {
                    return item.nome
                },
                afterSelect: function(item) {
                    $('#cliente-list').empty()

                    $('#cliente-list').append(`
                     <li style="background-color: #56baed" class="list-group-item">Dados do cliente</li>`)

                    $('#cliente-list').append(`
                    <li class="list-group-item">  Nome: ${item.nome} </li>`)

                    $('#cliente-list').append(`
                    <li class="list-group-item">  CPF: ${item.cpf} </li>`)

                    $('#card-list').css({
                        'display': 'block',
                    })

                    $('#cliente_id').val(item.id);

                }
            });

            $('#produto-search').typeahead({
                source: function(query, process) {
                    return $.get('{{ route('buscarProduto') }}', {
                        query: query
                    }, function(data) {
                        // console.log(data)
                        return process(data)
                    })
                },
                displayText: function(item) {

                    return item.titulo
                },
                afterSelect: function(item) {
                    // console.log('produto: =>', item)
                    $('#produto_id').val(item.id);
                    $('#produto_titulo').val(item.titulo);
                    $('.quantidade').val(1);
                    $('#valor_unitario').val(item.preco);
                    $('.valor_unitario').val(item.preco);
                    $('.sub_total').val(item.preco);
                    $('#sub_total').val(item.preco);
                    // console.log(item)
                }
            });

            $('.quantidade').on('input', function() {
                const quantiade = $(this).val()
                const valorUnitario = parseFloat($('.valor_unitario').val())

                function calculo(quantidade, valorUnitario) {
                    return quantidade * valorUnitario
                }

                const resultSubtotal = calculo(quantiade, valorUnitario)
                $('.sub_total').val(resultSubtotal.toFixed(2))
                $('#sub_total').val(resultSubtotal.toFixed(2))

            });
        });
    </script>

    @include('Layout.footer')

</body>

</html>
