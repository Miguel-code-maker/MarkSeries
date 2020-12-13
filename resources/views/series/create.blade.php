@extends('layout')

@section('titleDocument')
Adicionar Nova Série
@endsection

@section('title')
Adicionar Série
@endsection

@section('heade')
    <style>
        .input-group-link {
            padding-left: -10rem;
            margin: 1rem -1rem;
        }
        .group-check {
            margin-top: 3rem;
        }

        .col-link {
            display: none;
        }
    </style>
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
    <script>
        const checks = document.querySelectorAll('[type="checkbox"]');
        const checkPersonaliza = document.querySelector('#checkPersonaliza')
        const linkInput = document.querySelector('#link')
        const divPersonaliza = document.querySelector('.col-link');
        checkPersonaliza.checked = false;
        checks.forEach(check => {
            check.addEventListener('click', e => {
                checks.forEach(c => {
                    c.checked = (c == e.target);
                    if (c.checked && c == checkPersonaliza) {
                        divPersonaliza.style = "display: block;";
                    } else {
                        divPersonaliza.style = "display: none;"
                        linkInput.value = '';
                    }

                })
            })
        })
    </script>
@endsection


@section('javaScript')
@endsection
