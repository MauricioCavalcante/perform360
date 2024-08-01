function toggleFormClient() {
    const formNewClient = document.getElementById('formNewClient');
    if (formNewClient.style.display === 'none' || formNewClient.style.display === '') {
        formNewClient.style.display = 'block';
    } else {
        formNewClient.style.display = 'none';
    }
}

function hideFormNewClient() {
    const formNewClient = document.getElementById('formNewClient');
    if (formNewClient) {
        formNewClient.style.display = 'none';
    }
}

function showFormClient(clientId) {
    const cardContainer = document.querySelector(`.card-container[data-id="${clientId}"]`);
    const formContainer = document.getElementById(`formContainer-${clientId}`);
    cardContainer.classList.add('flip');
    formContainer.style.display = 'block';
}

function hideFormClient(clientId) {
    const cardContainer = document.querySelector(`.card-container[data-id="${clientId}"]`);
    const formContainer = document.getElementById(`formContainer-${clientId}`);
    cardContainer.classList.remove('flip');
    formContainer.style.display = 'none';
}

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
