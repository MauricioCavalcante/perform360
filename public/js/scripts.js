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
function toggleForm() {
    const infoUser = document.getElementById('infoUser');
    const configUser = document.getElementById('configUser');
    
    if (infoUser.style.display === 'none') {
        infoUser.style.display = 'block';
        configUser.style.display = 'none';
    } else {
        infoUser.style.display = 'none';
        configUser.style.display = 'block';
    }
}


function toggleConfigUserCancel() {
    let configUser = document.getElementById('configUser');
    let user = document.getElementById('infoUser');

    configUser.style.display = 'none';
    user.style.display = 'block';
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

function updatePassword(){
    const form = document.getElementById('updatePasswordForm');

    if(form.style.display === 'none'){
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}

