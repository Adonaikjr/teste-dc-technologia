 <!-- Modal -->

 <div class="modal fade" id="criarCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Cadastre seu Cliente</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form action="{{route('criar-cliente')}}" method="POST">
                @csrf
                <div class="modal-body">
                     <div class="form-floating mb-3">
                         <input class="form-control" id="floatingInput" name="nome" placeholder="name@example.com">
                         <label for="floatingInput">Nome</label>
                     </div>
                     <div class="form-floating mb-3">
                         <input class="form-control" id="floatingInput" name="cpf" placeholder="name@example.com">
                         <label for="floatingInput">CPF</label>
                     </div>

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                     <button type="submit" class="btn btn-primary">Cadastrar</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
