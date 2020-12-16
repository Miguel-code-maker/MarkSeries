
@extends('layout')

@section('titleDocument')
    Lista de temporadas
@endsection


@section('head')
@endsection


@section('title')
    Temporadas de {{ $serie->nome }}
@endsection


{{--//se tivesse dois codigos indenticos no meu blade eu poderia fazer isso:
   @include('nomeDoBladeExtra', ['varQueEleUtiliza' => $varQueEleUtiliza])

   e também poderia deixar uma condição:
   @includeWhen( condição ,'nomeDoBladeExtra', ['varQueEleUtiliza' => $varQueEleUtiliza])

--}}


@section('content')

    @if (!empty($mensagem))
        <span class="alert alert-success d-block">{{$mensagem}}</span>
    @endif

    <ul class="list-group list-temp w-80 w-auto">
    <?php $iT = 0; ?>
        @foreach ($temporadas as $temporada)
            <?php $iT++; ?>
            @if($iT == $serie->temporadas()->count())
                <li class="list-group-item item-temp" id="ultimaTemp" data-link="{{ $link[0][1]? $linkModelo[0][1] : null}}" data-infotemp="{{ $iT+1 }}, {{ $temporada->episodios()->count() }}, {{ $serie->epsPorTemp() }}">
            @else
                <li class="list-group-item item-temp">
            @endif
                <div class="d-flex justify-content-between" onclick="showEps({{ $temporada->id }})"><p>{{ $temporada->numero }}° Temporada</p>
                    <div class="d-flex">
                        @if ($iT == $serie->temporadas()->count())
                            <form class="form" action="{{ route('series.temporada.removerDo') }}" method="POST">
                                @csrf
                                <input type="hidden" name="idTemp" value="{{ $temporada->id }}">
                                <button type="submit" class="btn btn-danger">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        @endif
                        <div class="badge badge-secondary count">
                            <span class="i count-{{ $temporada->id }}">{{ $temporada->getEpsAssistidos()->count() }}</span> / {{ $temporada->episodios->count() }}
                        </div>
                    </div>
                </div>
                <ul id="eps-{{ $temporada->id }}" class="list-eps p-0" hidden>
                <?php $i = 0; ?>
                    @foreach ($temporada->episodios as $eps)
                        <?php $i++; ?>
                            <li id="ep-{{$i}}" class="d-flex justify-content-between p-2 item-ep">
                        @if(!empty($link[0][0]))
                            <a href="{{ $link[$iT-1][$i-1] }}" onclick="watchForLink(this, {{ $temporada->id }}, {{ $eps->id }})" target="_blank">Episodio {{$i}}</a>
                        @else
                            Episodio {{$i}}
                        @endif
                        <div id="putEp">
                            @if ($i == $temporada->episodios->count())
                                <button onclick='addEps({{ $temporada->id }}, {{ $i }}, {{ !empty($link[0][0])? "'{$link[$iT-1][$i-1]}'" : 'null'}}, {{ $serie->epsPorTemp() }})' class="btn btn-info btn-sm">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button onclick="removerEp({{ $eps->id }})" class="btn btn-danger btn-sm">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            @endif
                            <input class="check-{{ $temporada->id }}-{{ $eps->id }}" onclick="whatchEp(this, {{ $temporada->id }}, {{ $eps->id }})" {{ $eps->assistido? "data-check-{$temporada->id}={$eps->id} checked": '' }} type="checkbox">
                        </div>
                        @csrf
                    </li>
                    @endforeach

                </ul>
            </li>

        @endforeach
    </ul>
    <div class="d-flex flex-column float-right w-25">
        @csrf
        <div class="form-group">
            <label for="epsPorTemp">Digite o número de episodio da nova Temporada:</label>
            <input type="number" data-serieid="{{ $serie->id }}" id="epsPorTemp" name="epsPorTemp" class="form-control">
            <br>
            <button class="btn btn-primary" onclick="addTemp()">Adicionar</button>
        </div>
    </div>
@endsection



@section('javaScript')
    <script src="{{ asset('seriespub/assets/js/indexTemp.js') }}"></script>
@endsection
