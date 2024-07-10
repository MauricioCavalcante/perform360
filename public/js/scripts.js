

function reload(){
    window.location.reload();
}

// script.js
function exibirFormEditar() {
    let form = document.getElementById('formEditar');
    let table = document.getElementById('avaliacao');


    if (form && table) {
        if (window.getComputedStyle(table).display === 'block') {
            form.style.display = 'block';
            table.style.display = 'none';
        } else {
            form.style.display = 'none';
            table.style.display = 'block';
        }
    } else {
        console.error('Elemento não encontrado.');
    }
}

document.getElementById('editar').addEventListener('click', exibirFormEditar);

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('formEditar').style.display = 'none';
});



function toggleFormCliente() {
    let formCliente = document.getElementById('formCliente');

    if (formCliente.style.display === 'none' || formCliente.style.display === '') {
        formCliente.style.display = 'block';
    } else {
        formCliente.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Inicializar a visibilidade dos elementos ao carregar a página
    document.getElementById('nameConfigContainer').style.display = 'none';
});



function toggleNameConfigEdit() {
    let confiUserName = document.getElementById('nameConfigContainer');
    let userName = document.getElementById('nameUser');

    if (window.getComputedStyle(confiUserName).display === 'none') {
        confiUserName.style.display = 'block';
        userName.style.display = 'none';
    } else {
        confiUserName.style.display = 'none';
        userName.style.display = 'block';
    }
}

function toggleNameConfigCancel() {
    let confiUserName = document.getElementById('nameConfigContainer');
    let userName = document.getElementById('nameUser');

    confiUserName.style.display = 'none';
    userName.style.display = 'block';
}
