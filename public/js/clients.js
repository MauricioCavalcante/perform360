// config.js

// Função para alternar a visibilidade do formulário de novo client
function toggleFormClient() {
    const formNewClient = document.getElementById('formNewClient');
    if (formNewClient.style.display === 'none' || formNewClient.style.display === '') {
        formNewClient.style.display = 'block';
    } else {
        formNewClient.style.display = 'none';
    }
}

// Função para esconder o formulário de novo client
function hideFormNewClient() {
    const formNewClient = document.getElementById('formNewClient');
    if (formNewClient) {
        formNewClient.style.display = 'none';
    }
}

// Função para mostrar/ocultar o formulário de edição do client
function showFormClient(clientId) {
    const cardContainer = document.querySelector(`.card-container[data-id="${clientId}"]`);
    const formContainer = document.getElementById(`formContainer-${clientId}`);
    cardContainer.classList.add('flip');
    formContainer.style.display = 'block';
}

// Função para ocultar o formulário de edição
function hideFormClient(clientId) {
    const cardContainer = document.querySelector(`.card-container[data-id="${clientId}"]`);
    const formContainer = document.getElementById(`formContainer-${clientId}`);
    cardContainer.classList.remove('flip');
    formContainer.style.display = 'none';
}

// Adiciona os ouvintes de eventos para os botões de edição
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.showFormEditClient').forEach(button => {
        button.addEventListener('click', function() {
            const clientId = this.getAttribute('data-id');
            showFormClient(clientId);
        });
    });

    document.querySelectorAll('.btn-secondary').forEach(button => {
        button.addEventListener('click', function() {
            const clientId = this.getAttribute('onclick').match(/\d+/)[0];
            hideFormClient(clientId);
        });
    });

    document.getElementById('newClient').addEventListener('click', toggleFormClient);
});
