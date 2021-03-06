@extends('layout')

@section('titleDocument')
Adicionar Nova Série
@endsection

@section('title')
Adicionar Série
@endsection

@section('head')
@endsection

@section('content')
    @include('errors', ['erros' => $errors])

    <form method="POST">
    @csrf

        <div class="row">
            <div class="col col-8">
                <label for="nome">Nome da Série:</label>
                <input type="text" id="nome" name="nome" class="form-control w-100">
            </div>
            <div class="col col-2">
                <label for="temporadas">N° de Temp:</label>
                <input type="number" id="temporadas" name="temporadas" class="form-control w-100">
            </div>
            <div class="col col-2">
                <label for="episodios">N° de eps por Temp:</label>
                <input type="number" id="episodios" name="episodios" class="form-control w-100">
            </div>
        </div>
        <div class="group-check d-flex flex-column">
            <div>
                <input type="checkbox" name="pobreflix">
                <label for="probreflix" class="label__check">Assistiar pela PobreFlix</label>
            </div>
            <div>
                <input type="checkbox" name="animeshouse">
                <label for="animeshouse" class="label__check">Assistar pelo AnimesHouse</label>
            </div>
            <div>
                <input type="checkbox" name="checkPersonaliza" id="checkPersonaliza" class="checkPersonaliza">
                <label for="checkPersonaliza" class="label__check">Personalizar fonte</label>
            </div>
        </div>
        <div class="input-group-link row">
            <div class="col col-9 col-link">
                <label for="input-link">link do primeiro ep:</label>
                <input type="text" id="link" name="link" class="form-control w-100">
                <span>coloque o link do primeiro episodio é no lugar do variante da temporada coloque $*<br> e no lugar do variante do episodio coloque $^.</span>
            </div>

        </div>
        <button class="btn btn-primary mt-2">Adicionar</button>
    </form>
@endsection


@section('javaScript')
    <script src="{{ asset('seriespub/assets/js/createSeries.js') }}"></script>
@endsection
