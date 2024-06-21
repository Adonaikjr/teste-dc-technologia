<!DOCTYPE html>
<html>

@include('Layout.head')

<body class="font-sans antialiased dark:bg-black dark:text-white/50">

    <div class="wrapper fadeInDown">
        <div id="formContent">

            <form class="d-flex flex-column align-items-center pt-3 pb-3" action="{{ route('autenticarLogin') }}"
                method="POST">
                @csrf
                <input type="text" id="login" class="fadeIn second" name="email" placeholder="Email">
                <input type="text" id="password" class="fadeIn third" name="password" placeholder="Senha">
                <input type="submit" class="fadeIn fourth mt-2 mb-0" value="Entrar">
            </form>
            <a href="/criar-user">Criar usuário</a>
        </div>
    </div>
</body>

</html>
