document.addEventListener('DOMContentLoaded', function() {
    const radioElements = document.querySelectorAll('.score');
    const inicialValue = 0;

    function calcularPontuacao() {
        let currentValue = inicialValue;

        radioElements.forEach(radio => {
            if (radio.checked) {
                currentValue += parseFloat(radio.value);
            }
        });

        document.getElementById('currentValue').textContent = currentValue;
        document.getElementById('totalScore').value = currentValue;
    }

    
    radioElements.forEach(radio => {
        radio.addEventListener('change', calcularPontuacao);
    });

    calcularPontuacao();
});

