
function showEps(id) {
    const ul = document.querySelector(`#eps-${id}`)

    if (ul.hasAttribute('hidden')) {
        ul.removeAttribute('hidden')
    } else {
        ul.hidden = true;
    }

}

function addTemp() {
    const formData = new FormData();
    const ultimaTemp = document.querySelector('#ultimaTemp')? document.querySelector('#ultimaTemp'): "1,1,1";
    const tempEEp = ultimaTemp.textContent !== undefined? ultimaTemp.dataset.infotemp.split(',') : ultimaTemp.split(',');
    const input = document.querySelector('#epsPorTemp')
    const epsPorTem = input.value;
    const idSerie = input.dataset.serieid;
    console.log(tempEEp)
    let link;
    if (ultimaTemp.dataset.link != null) {
        link = ultimaTemp.dataset.link;
        console.log(link)
        link = link.replace('1*', tempEEp[0]+"*")
        console.log(link)
        link = link.replace('2^', tempEEp[1]+"^")
        console.log(link)
        link = link.replace(' ', '');
        console.log(link)
    } else {
        link = null;
    }
    console.log(link);
    const temp = parseInt(tempEEp[0]);
    const ep = parseInt(tempEEp[1])
    const uniEp = parseInt(tempEEp[2])
    formData.append('ep', ep);
    formData.append('temp', temp);
    formData.append('link', link);
    formData.append('uniEp', uniEp);
    formData.append('idSerie', idSerie);
    formData.append('epsPorTemp', epsPorTem);
    const url = "/series/temporada/adicionar";
    const request = servicePost(url, formData);
    reload(request);
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

    reload(request)
}


function addDataBase(idTemp, link, ep) {
    const url = "http://localhost:8000/series/temporada/episodio/adicionar";
    const formData = new FormData();

    formData.append('idTemp', idTemp);
    if (link) formData.append('link', link);
    formData.append('ep', ep);

    return servicePost(url, formData)
}

function removerEp(idEp) {
    const formData = new FormData();
    const url = "http://localhost:8000/series/temporada/episodio/remover";
    formData.append('id', idEp);
    let request = servicePost(url, formData);

    reload(request);
}

function removerTemp(idTemp) {
    console.log('oi')
    const formData = new FormData();
    const url = "http://localhost:8000/series/temporada/remover";
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

function reload(request) {
    setInterval(() => {
        if (request != null || request != undefined) {
            document.location.reload(true);
            request = null;
        }
    }, 100)
}
