@extends('layout')

@section('titleDocument')
    Listar series
@endsection

@section('title')
    Séries
@endsection

@section('content')
    @if (!empty($mensagem))
        <span class="alert alert-success d-block">{{$mensagem}}</span>
    @endif
    <a class="btn btn-dark mb-3" href="{{ route('series.adicionar') }}">Adicionar Séries</a>
    <ul class="list-group w-80 w-auto">
        @foreach ($series as $serie)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <p id="nameSerie-{{ $serie->id }}">{{ $serie->nome }}</p>

            <div class="input-group w-50" hidden id="input-nome-serie-{{ $serie->id }}">
                <input type="text" class="form-control" id="input-edit-{{ $serie->id  }}" value="{{ $serie->nome }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" onclick="editSerie({{ $serie->id }})">
                        <i class="fas fa-check"></i>
                    </button>
                    @csrf
                </div>
            </div>

            <div class="d-flex">
                <a href="/series/{{$serie->id}}/temporadas" class="btn btn-info btn-sm"><i class="fas fa-external-link-alt"></i></a>
                @auth
                <button class="btn btn-info btn-sm ml-2" onclick="toggleInput({{ $serie->id }})">
                    <i class="fas fa-edit"></i>
                </button>
                <form action="/series/remover/{{ $serie->id }}" method="POST" onsubmit="return confirm('tem certeza que deseja excluir {{ addslashes($serie->nome) }}')">
                    @csrf
                    @method("DELETE")
                    <button class="btn btn-danger btn-sm ml-2"><i class="far fa-trash-alt"></i></button>
                </form>
                @endauth
            </div>
        </li>
        @endforeach
    </ul>
@endsection

@section('javaScript')
    <script>
        function toggleInput(id) {
            const input = document.querySelector(`#input-nome-serie-${id}`);
            const nome = document.querySelector(`#nameSerie-${id}`);

            if (nome.hasAttribute('hidden')) {
                hidden(nome, input)
            } else {
                hidden(input, nome)
            }
        }

        function editSerie(id) {
            const formData = new FormData();

            const novoNome = document.querySelector(`#input-edit-${id}`).value

            const token = document.querySelector('input[name="_token"]').value;

            const nome = document.querySelector(`#nameSerie-${id}`);

            const url = `/series/${id}/editar`

            formData.append('nome', novoNome);
            formData.append('_token', token)

            fetch(url, {
                body: formData,
                method: 'POST'
            })

            nome.textContent = novoNome;

            toggleInput(id);

        }

        function hidden(mostrar, desaparecer) {
            mostrar.removeAttribute('hidden')
            desaparecer.hidden = true;
        }

    </script>
@endsection
