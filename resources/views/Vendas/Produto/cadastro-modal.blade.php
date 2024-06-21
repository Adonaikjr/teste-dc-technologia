 <!-- Modal -->
 <script>
     async function handleSubmit() {
         const titulo = document.querySelector('input[name="titulo"]').value;
         const preco = document.querySelector('input[name="preco"]').value;

         try {
             const response = await fetch('{{ route('criar-produto') }}', {
                 method: 'POST',

                 headers: {
                     'Content-Type': 'application/json',
                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
                 },
                 body: JSON.stringify({
                     titulo: titulo,
                     preco: preco
                 }),
             })
             if (response.ok) {
                alert('Produto cadastrado')
                 const fecharModal = document.getElementById('criarProduto');
                 const modal = bootstrap.Modal.getInstance(fecharModal);
                 modal.hide();

                 const setValuePadrao = () => {
                     document.querySelector('input[name="titulo"]').value = '';
                     document.querySelector('input[name="preco"]').value = '';
                 }

                 return setValuePadrao()
             } else {
                 return console.error('Erro ao cadastrar o produto:', response.statusText);
             }
         } catch (error) {
             return console.log(error)
         }
     }
 </script>
 <div class="modal fade" id="criarProduto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Cadastre seu Produto</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
          @include('Layout.alert')
             <form action="{{ route('criar-produto') }}" method="POST">
                 @csrf
                 <div class="modal-body">

                     <div class="form-floating mb-3">
                         <input class="form-control" id="floatingInput" name="titulo" placeholder="name@example.com">
                         <label for="floatingInput">Titulo</label>
                     </div>
                     <div class="form-floating mb-3">
                         <input class="form-control" id="floatingInput" name="preco" placeholder="name@example.com">
                         <label for="floatingInput">Preço</label>
                     </div>

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                     <button type="button" onclick="handleSubmit()" class="btn btn-primary">Cadastrar</button>
                 </div>
             </form>


         </div>
     </div>
 </div>
