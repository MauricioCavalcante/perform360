document.addEventListener('DOMContentLoaded', function() {
    const radioElements = document.querySelectorAll('.score');
    const seriousRadioElements = document.querySelectorAll('.score-serious');
    
    function calcularPontuacao() {
        let currentValue = 0;

        // Calcular a pontuação total para todas as perguntas
        radioElements.forEach(radio => {
            if (radio.checked && radio.value !== '100') {
                currentValue += parseFloat(radio.value);
            }
        });

        // Verificar se a opção "Não" para a seriedade foi selecionada
        const seriousNaoSelected = Array.from(seriousRadioElements).find(radio => radio.id === 'score_serious_nao2').checked;

        if (seriousNaoSelected) {
            currentValue = 0;
        } else {
            // Adicionar a pontuação de seriedade, se aplicável
            seriousRadioElements.forEach(radio => {
                if (radio.checked && radio.value !== '100') {
                    currentValue += parseFloat(radio.value);
                }
            });
        }

        // Atualizar a exibição e o valor total
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
