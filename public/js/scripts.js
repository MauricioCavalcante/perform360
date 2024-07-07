
function reload(){
    window.location.reload();
}

document.getElementById('editar').addEventListener('click', function() {
    let form = document.getElementById('formEditar');
    let table = document.getElementById('avaliacao');

    // Se o display não foi definido no estilo inline, obtenha o valor computado
    if (window.getComputedStyle(table).display === 'block') {
        form.style.display = 'block';
        table.style.display = 'none';
    } else {
        form.style.display = 'none';
        table.style.display = 'block';
    }
});


function toggleFormCliente() {
    let formCliente = document.getElementById('formCliente');

    if (formCliente.style.display === 'none' || formCliente.style.display === '') {
        formCliente.style.display = 'block';
    } else {
        formCliente.style.display = 'none';
    }
}
