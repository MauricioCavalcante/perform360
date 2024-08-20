document.addEventListener('DOMContentLoaded', function() {
    const radioElements = document.querySelectorAll('.score');
    const deductionElements = document.querySelectorAll('.deduction');

    function calcularPontuacao() {
        let totalScore = 0;

        radioElements.forEach(radio => {
            if (radio.checked) {
                const questionContainer = radio.closest('.container');
                const isDeduction = questionContainer.classList.contains('deduction');
                
                if (!isDeduction) {
                    totalScore += parseFloat(radio.value);
                }
            }
        });

        let totalDeductionPercentage = 0;

        // Calcular a porcentagem total de dedução
        deductionElements.forEach(element => {
            const questionId = element.getAttribute('data-question-id');
            const deductionPercentage = parseFloat(element.getAttribute('data-question-score'));

            if (element.querySelector(`#score_${questionId}_nao2`).checked) {
                totalDeductionPercentage += deductionPercentage;
            }
        });

        const deductionAmount = totalScore * (totalDeductionPercentage / 100);
        const finalScore = totalScore - deductionAmount;

        document.getElementById('currentValue').textContent = finalScore.toFixed(2);
        document.getElementById('totalScore').value = finalScore.toFixed(2);
    }

    radioElements.forEach(radio => {
        radio.addEventListener('change', calcularPontuacao);
    });

    deductionElements.forEach(element => {
        element.querySelectorAll('input[type=radio]').forEach(radio => {
            radio.addEventListener('change', calcularPontuacao);
        });
    });

    calcularPontuacao();
});

document.addEventListener('DOMContentLoaded', function () {
    const deductionRadios = document.querySelectorAll('input[name="deduction"]');
    const scoreLabel = document.getElementById('score-label');

    function updateScoreLabel() {
        const selectedValue = document.querySelector('input[name="deduction"]:checked');
        if (selectedValue) {
            if (selectedValue.value === 'Sim') {
                scoreLabel.textContent = 'Desconto de (%):';
            } else {
                scoreLabel.textContent = 'Nota:';
            }
        }
    }

    // Initialize label based on the initial state
    updateScoreLabel();

    // Attach event listeners to the radio buttons
    deductionRadios.forEach(radio => {
        radio.addEventListener('change', updateScoreLabel);
    });
});