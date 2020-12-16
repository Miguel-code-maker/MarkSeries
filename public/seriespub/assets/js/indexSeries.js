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
