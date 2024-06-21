function handleEditar(index) {
    const parcelas = JSON.parse(localStorage.getItem('valor_parcelas'))
    let escolha = prompt(
        `Você está editando a parcela nº: ${index + 1}\nDigite:\n1: para atualizar a data.\n2: para atualizar o valor.`)

    if (escolha === '1') {
        const regexData = /^\d{2}\/\d{2}\/\d{4}$/
        const novaData = prompt(`Edite a data da parcela ${index + 1}:`, parcelas[index].data)

        if (novaData && regexData.test(novaData)) {
            const hoje = new Date()
            if (new Date(novaData) < hoje) {
                alert(`Data da parcela não pode ser menor que hoje.`)
            }

            parcelas[index].data = novaData;
            localStorage.setItem('valor_parcelas', JSON.stringify(parcelas))
            alert(`Data da parcela ${index + 1} atualizada para: ${novaData}`)
            setParcelasTable()
        } else {
            alert('Formato de data inválido ou não fornecido.')
        }


    } else if (escolha === '2') {

        const newValorParcela = prompt(`Edite o valor da parcela ${index + 1}:`, parcelas[index].valor)

        if (newValorParcela) {
            const CalcularValorRestante = (newValorParcela) => {
                const valorTotal = parcelas.reduce((total, parcela) => total + parseFloat(parcela.valor), 0)

                // console.log('valor total', valorTotal)
                const valorDiferenca = valorTotal - newValorParcela
                // console.log(valorDiferenca)
                parcelas[index].valor = newValorParcela

                const quantidadeParcelas = parcelas.length - 1

                const diferencaPorParcela = quantidadeParcelas === 1 ? valorDiferenca : valorDiferenca /
                    quantidadeParcelas
                // console.log(diferencaPorParcela)
                parcelas.forEach((parcela, key) => {
                    if (key !== index) {
                        parcela.valor = parseFloat(diferencaPorParcela).toFixed(2)
                    }
                })

                const DiferencaCentavos = (quantidadeParcelas) => {

                    if (quantidadeParcelas > 0) {
                        parcelas[quantidadeParcelas - 1].valor = (parseFloat(parcelas[quantidadeParcelas - 1].valor) + 0.01)
                            .toFixed(2)
                    }
                }

                DiferencaCentavos(quantidadeParcelas)
            }

            CalcularValorRestante(newValorParcela)

            localStorage.setItem('valor_parcelas', JSON.stringify(parcelas))

            alert(`Valor da parcela ${index + 1} atualizado para: ${parseFloat(newValorParcela).toFixed(2)}`)

            setParcelasTable()
        }

    } else {
        alert('Valor incorreto')
    }
}

const setParcelasTable = () => {
    const tabelaParcelas = document.getElementById('ver_parcelas')
    const parcelas = JSON.parse(localStorage.getItem('valor_parcelas'))

    const insertTabela = parcelas.map((parcela, index) => {
        return `
                        <tr key="${index}">
                            <th scope="row">${index + 1}</th>
                            <td> ${parcela.data}</td>
                            <td>${parcela.valor}</td>
                            <td><button type="button" class="btn btn-warning" onclick="handleEditar(${index})">Editar</button> </td>
                        </tr>
                        `
    })

    tabelaParcelas.innerHTML = insertTabela.join('')
}

const formatDate = (date) => {
    const ano = date.getFullYear()
    const mes = (date.getMonth() + 1).toString().padStart(2, '0')
    const dia = date.getDate().toString().padStart(2, '0')
    return `${dia}/${mes}/${ano}`
}

function gerarParcelas() {
    const numeroParcela = document.querySelector(`[name="numeroParcelas"]`)
    const valorAPagar = document.getElementById(`valorAPagar`).textContent

    if (numeroParcela) {
        const numParcelas = parseInt(numeroParcela.value, 10)
        const hoje = new Date()
        const valorTotal = parseFloat(valorAPagar.replace('R$', '').replace(',', '.').trim())


        const calcularValoresIniciais = (numParcelas, valorTotal) => {
            const valoresParcelas = []
            const valorParcelaBase = parseFloat((valorTotal / numParcelas).toFixed(2))

            for (let i = 0; i < numParcelas; i++) {
                valoresParcelas.push(valorParcelaBase)
            }

            let valorTotalParcelas = valoresParcelas.reduce((acc, val) => acc + val, 0)
            const diferenca = parseFloat((valorTotal - valorTotalParcelas).toFixed(2))
            valoresParcelas[valoresParcelas.length - 1] += diferenca

            return valoresParcelas
        }

        const valoresParcelas = calcularValoresIniciais(numParcelas, valorTotal)

        let parcelas = []

        const setFormarParcelas = (numParcelas) => {
            for (let i = 0; i < numParcelas; i++) {
                const dataParcela = new Date(hoje.getFullYear(), hoje.getMonth() + 1 + i, hoje.getDate())
                const formatarData = formatDate(dataParcela)

                parcelas.push({
                    valor: parseFloat(valoresParcelas[i].toFixed(2)),
                    data: formatarData
                })
            }
        }

        setFormarParcelas(numParcelas)

        localStorage.setItem('valor_parcelas', JSON.stringify(parcelas))

        setParcelasTable()
    }
}

ItemCarrinho()

function handleExcluirItem(index) {
    const carrinhoData = localStorage.getItem('ultimaResposta')
    let carrinho = JSON.parse(carrinhoData)

    carrinho.splice(index, 1)
    localStorage.setItem('ultimaResposta', JSON.stringify(carrinho))
    ItemCarrinho()
    return carrinho
}

function ItemCarrinho() {
    const tabela = document.getElementById('carrinho')
    const carrinhoData = localStorage.getItem('ultimaResposta')
    const newCarrinho = JSON.parse(carrinhoData)
    if (newCarrinho === null) {
        return
    }
    const mostrarItem = newCarrinho.map((item, index) => {
        // console.log(item)
        return `
                        <tr key="${index}">
                            <th class="table-success" scope="row">${index + 1}</th>
                            <td class="table-success">${item.produto_titulo}</td>
                            <td class="table-success">${item.quantidade}</td>
                            <td class="table-success">${item.sub_total}</td>
                            <td class="table-success">
                                <button type="button" class="btn btn-danger" onclick="handleExcluirItem(${index})">Excluir</button>
                            </td>
                        </tr>
                        `
    });

    const valorTotal = newCarrinho.reduce((total, item) => {
        return total + parseFloat(item.sub_total)
    }, 0)


    mostrarItem.push(`<tr>
                                <th class="table-success" scope="row" colspan="4">Total:</th>
                                <td class="table-success" id="valorTotal">${valorTotal.toFixed(2)}</td>
                              </tr>
                            `)

    const valorPendente = document.getElementById('valorAPagar')

    valorPendente.textContent = `R$ ${valorTotal.toFixed(2)}`

    tabela.innerHTML = mostrarItem.join('')
}
