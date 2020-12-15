
@extends('layout')

@section('titleDocument')
    Lista de temporadas
@endsection


@section('heade')
    <style>
        ul.list-temp {
            margin-bottom: 5rem;
            overflow: hidden;
        }

        .item-temp {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .item-ep {
            font-size: 1rem;
            transition: all 0.5s ease-in-out;

        }

        .list-eps {
            transform: translateX(110%);
            animation: showEps .5s ease-in-out forwards 0.1s;
        }

        @keyframes showEps {
            to {
                transform: translateX(0px);

            }
        }

        .count {
            height: 1.5rem;
        }

        .btn {
            transform: translateY(-5px);
        }


        #ultimaTemp {
            display: none;
        }

        .form {
            padding-right: 10px;
        }

</style>
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
            <li class="list-group-item item-temp">
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
                @if($iT == $serie->temporadas()->count())
                <span id="ultimaTemp" hidden>{{ $iT+1 }}, {{ $temporada->episodios()->count() }}, {{ $serie->epsPorTemp() }}</span>
                @endif
        @endforeach
    </ul>
    <form action="/series/temporada/adicionar" method="POST" class="d-flex flex-column float-right w-25">
        @csrf
        <div class="form-group">
            <label for="epsPorTemp">Digite o número de episodio da nova Temporada:</label>
            <input type="number" id="epsPorTemp" name="epsPorTemp" class="form-control">
            <input type="hidden" id="temp" name="temp">
            <input type="hidden" id="link" name="link">
            <input type="hidden" id="ep" name="ep">
            <input type="hidden" id="uniEp" name="uniEp">
            <input type="hidden" id="idSerie" name="idSerie" value="{{ $serie->id }}">
            <br>
            <button class="btn btn-primary">Adicionar</button>
        </div>
    </form>
@endsection



@section('javaScript')
    <script>
        function showEps(id) {
            const ul = document.querySelector(`#eps-${id}`)

            if (ul.hasAttribute('hidden')) {
                ul.removeAttribute('hidden')
            } else {
                ul.hidden = true;
            }

        }

        window.onload = () => {
            const ultimaTemp = document.querySelector('#ultimaTemp')? document.querySelector('#ultimaTemp'): "1,1,1";
            const input = document.querySelector('#temp')
            const inputUniEp = document.querySelector('#uniEp')
            const inputLink = document.querySelector('#link');
            const inputEp = document.querySelector('#ep');
            const tempEEp = ultimaTemp.textContent !== undefined? ultimaTemp.textContent.split(',') : ultimaTemp.split(',');
            console.log(tempEEp)
            @if (!empty($link[0][1]))
            let link = "{{ $link[0][1] }}";
            console.log(link)
            link = link.replace('1', '1*');
            console.log(link)
            link = link.replace('2', "2^")
            console.log(link)
            link = link.replace('1*', tempEEp[0]+"*")
            console.log(link)
            link = link.replace('2^', tempEEp[1]+"^")
            console.log(link)
            link = link.replace(' ', '');
            console.log(link)
            @elseif(empty($link))
            let link = null;
            @endif
            const temp = parseInt(tempEEp[0]);
            const ep = parseInt(tempEEp[1])
            const uniEp = parseInt(tempEEp[2])

            input.value = temp;
            inputLink.value = link;
            inputEp.value = ep;
            inputUniEp.value = uniEp;
        }

        function watchForLink(targetLink, idCountTemp, idEp) {
            const input = document.querySelector(`.check-${idCountTemp}-${idEp}`);
            if (!input.hasAttribute('checked') || !input.hasAttribute(`data-check-${idCountTemp}`)) whatchEp(input, idCountTemp, idEp);
            input.setAttribute('checked', "");
            input.checked = true;
        }

        function whatchEp(target, idCountTemp, idEp) {
            let i = 0;
            const count = document.querySelector(`.count-${idCountTemp}`);
            const checado = target;
            if (checado.hasAttribute(`data-check-${idCountTemp}`)) {
                checado.removeAttribute(`data-check-${idCountTemp}`)
                i--
            } else {
                i++
                checado.setAttribute(`data-check-${idCountTemp}`, idEp.toString())
            }
            count.textContent = i + parseInt(count.textContent);

            insertData(idCountTemp);
        }

        function insertData(idTemp) {
            const formData = new FormData();


            const check = document.querySelectorAll(`[data-check-${idTemp}]`);
            let arrayAssistido = []
            console.log(check)
            check.forEach(cheka => arrayAssistido.push(cheka.dataset[`check-${idTemp}`]));
            console.log(arrayAssistido)
            formData.append('assistidoId', arrayAssistido);

            const url = `/series/${idTemp}/episodio/assistir`;

            servicePost(url, formData);

        }

        let iCenter = 1;
        function addEps(idTemp, ultimoEp, link, epTotal) {
            const novoEp = ultimoEp+iCenter;
            const ultimoEpTotal = epTotal+iCenter
            iCenter++;
            let novoLink;
            console.log(link)
            if (link == null) {
                novoLink = null;
            } else {
                novoLink = link.replace(`${ultimoEp}`, `${novoEp}`);
                novoLink = novoLink.replace(`${epTotal}`, `${parseInt(ultimoEpTotal)}`);
            }

            let request = addDataBase(idTemp, novoLink, novoEp);

            setInterval(() => {
                if (request != null || request != undefined) {
                    document.location.reload(true);
                    request = null;
                }
            }, 100)
        }


        function addDataBase(idTemp, link, ep) {
            const url = "{{ route('series.temporada.episodio.adicionarDo') }}";
            const formData = new FormData();

            formData.append('idTemp', idTemp);
            if (link) formData.append('link', link);
            formData.append('ep', ep);

            return servicePost(url, formData)
        }

        function removerEp(idEp) {
            const formData = new FormData();
            const url = "{{ route('series.temporada.episodio.removerDo') }}";
            formData.append('id', idEp);
            let request = servicePost(url, formData);

            setInterval(() => {
                if (request != null || request != undefined) {
                    document.location.reload(true);
                    request = null;
                }
            }, 100)
        }

        function removerTemp(idTemp) {
            console.log('oi')
            const formData = new FormData();
            const url = "{{ route('series.temporada.removerDo') }}";
            formData.append('idTemp', idTemp);
            servicePost(url, formData);

        }

        function servicePost(url, formData) {
            const token = document.querySelector('[name=_token]').value;
            formData.append('_token', token);

            return fetch(url, {
                body: formData,
                method: 'POST'
            })
        }

    </script>
@endsection
