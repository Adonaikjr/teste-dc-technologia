<script src="https://unpkg.com/@phosphor-icons/web"></script>
@if (Session::has('erro'))
    <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show"
        style="
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;"
        role="alert">
        <i class="ph ph-warning" style="font-size: 24px;"></i>
        <div>{{ Session::get('erro') }}</div>
    </div>
@endif

@if (Session::has('sucesso'))
    <div style="
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;"
        class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
        <i class="ph ph-check-circle" style="font-size: 24px;"></i>
        <div>{{ Session::get('sucesso') }}</div>
    </div>
@endif

@if (Session::has('aviso'))
    <div class="alert alert-warning alert-dismissible fade show">
        <strong class="uppercase"><bdi>Aviso!</bdi></strong>
        {{ Session::get('aviso') }}
    </div>
@endif


