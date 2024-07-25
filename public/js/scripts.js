

function reload() {
    window.location.reload();
}

// Script Avaliação (details_evaluation.blade.php) --------------------------------------------------------
function exibirFormEdit() {
    let form = document.getElementById('formEdit');
    let table = document.getElementById('evaluation');


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

document.getElementById('edit').addEventListener('click', exibirFormEdit);

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('formEdit').style.display = 'none';
});

// Fim Script Avaliação --------------------------------------------------------

// Script Novo e Editar Cliente (painel_user.blade.php) --------------------------------------------------------

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('nameConfigContainer').style.display = 'none';
});

document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('button[id^="showFormEditarCliente"]');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const clienteId = this.getAttribute('data-id');
            fetch(`/clientes/${clienteId}`)
                .then(response => response.json())
                .then(cliente => {
                    const formEditarCliente = document.getElementById('formEditarCliente');
                    formEditarCliente.style.display = 'block';
                    formEditarCliente.querySelector('form').action = `/clientes/${cliente.id}`;
                    document.getElementById('name').value = cliente.name;
                    document.getElementById('projeto').value = cliente.projeto;
                })
                .catch(error => console.error('Erro:', error));
        });
    });
});

function toggleFormCliente() {
    let formNovoCliente = document.getElementById('formNovoCliente');

    if (formNovoCliente.style.display === 'none' || formNovoCliente.style.display === '') {
        formNovoCliente.style.display = 'block';
    } else {
        formNovoCliente.style.display = 'none';
    }
}


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

// Fim Script Novo e Editar Cliente ---------------------------------

// Script Score --------------------------------------------------------

document.addEventListener('DOMContentLoaded', function() {
    const scoreElement = document.getElementById('score');
    const indicatorElement = document.getElementById('indicator');
    const fillValueInput = document.getElementById('fillValue');
    
    if (fillValueInput) {
        fillValueInput.addEventListener('change', function() {
            const fillValue = parseInt(fillValueInput.value);
            
            if (isNaN(fillValue) || fillValue < 0 || fillValue > 100) {
                alert('Por favor, insira um valor válido de 0 a 100.');
                return;
            }
            
            // Atualiza o círculo de score
            updateScoreCircle(fillValue);
            
            // Atualiza o indicador
            updateIndicator(fillValue);
        });
    }
    
    function updateScoreCircle(fillValue) {
        if (scoreElement) {
            scoreElement.style.setProperty('--fill', fillValue / 100);
            indicatorElement.style.setProperty('--fill', fillValue / 100);
        }
    }
});
