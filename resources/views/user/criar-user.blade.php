  @include('Layout.head')

  <div class="wrapper fadeInDown">
      <div id="formContent">

          <form class="d-flex flex-column align-items-center pt-3 pb-3" action="{{ route('criar-user') }}" method="POST">
              @csrf
              <input type="text" id="password" class="fadeIn third" name="name" placeholder="Nome">
              <input type="text" id="login" class="fadeIn second" name="email" placeholder="Email">
              <input type="text" id="password" class="fadeIn third" name="password" placeholder="Senha">
              <input type="submit" class="fadeIn fourth mt-2 mb-0" value="Criar">
          </form>

      </div>
  </div>
