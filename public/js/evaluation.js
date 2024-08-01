document.addEventListener('DOMContentLoaded', function() {
    const radioElements = document.querySelectorAll('.score');
    const seriousRadioElements = document.querySelectorAll('.score-serious');
    
    function calcularPontuacao() {
        let currentValue = 0;

        radioElements.forEach(radio => {
            if (radio.checked && radio.value !== '100') {
                currentValue += parseFloat(radio.value);
            }
        });

        const seriousNaoSelected = Array.from(seriousRadioElements).find(radio => radio.id === 'score_serious_nao2').checked;

        if (seriousNaoSelected) {
            currentValue = 0;
        } else {
           
            seriousRadioElements.forEach(radio => {
                if (radio.checked && radio.value !== '100') {
                    currentValue += parseFloat(radio.value);
                }
            });
        }

        document.getElementById('currentValue').textContent = currentValue;
        document.getElementById('totalScore').value = currentValue;
    }

    radioElements.forEach(radio => {
        radio.addEventListener('change', calcularPontuacao);
    });

    seriousRadioElements.forEach(radio => {
        radio.addEventListener('change', calcularPontuacao);
    });

    calcularPontuacao();
});
